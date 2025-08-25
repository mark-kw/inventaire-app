<?php
// src/DataFixtures/ReservationFixtures.php
namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Payment;
use App\Enum\ReservationStatus;
use App\Enum\PaymentMethod;
use App\Enum\RoomStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory as FakerFactory;
use DateInterval;
use DateTimeImmutable;
use App\Entity\Room;
use App\Entity\Guest;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');
        $faker->seed(20250825);

        $today = new DateTimeImmutable('today');

        // Choisir quelques chambres pour éviter les collisions simples
        $roomNumbers = ['101', '102', '103', '104', '105', '106', '201', '202', '203', '204'];
        $roomPool = $faker->shuffleArray($roomNumbers);

        // 10 réservations variées (passé, présent, futur)
        for ($i = 0; $i < 10; $i++) {
            $roomRef = 'room_' . $roomPool[$i % count($roomPool)];
            $room  = $this->getReference($roomRef, Room::class);
            $guest = $this->getReference('guest_' . $faker->numberBetween(0, 11), Guest::class);

            // fenêtres de dates
            $arrival = $today->sub(new DateInterval('P' . $faker->numberBetween(0, 7) . 'D'));
            if ($i % 3 === 0) { // certaines dans le futur
                $arrival = $today->add(new DateInterval('P' . $faker->numberBetween(1, 10) . 'D'));
            }
            $nights = $faker->numberBetween(1, 5);
            $departure = $arrival->add(new DateInterval('P' . $nights . 'D'));

            $res = (new Reservation())
                ->setCode(sprintf('KAF-%s-%04d', $today->format('Y'), $i + 1))
                ->setGuest($guest)
                ->setRoom($room)
                ->setArrivalDate($arrival)
                ->setDepartureDate($departure)
                ->setAdults($faker->numberBetween(1, 2))
                ->setChildren($faker->boolean(30) ? $faker->numberBetween(1, 2) : 0)
                ->setNotes($faker->optional(0.3)->sentence());

            // Calcul du montant (nuits * prix nuit)
            $pricePerNight = (float) $room->getNightPrice();
            $total = $pricePerNight * $nights;
            $res->setTotalAmount(number_format($total, 2, '.', ''))
                ->setCurrency('XOF');

            // Déterminer le statut
            if ($today < $arrival) {
                $status = ReservationStatus::CONFIRMED; // à venir
            } elseif ($today >= $arrival && $today < $departure) {
                $status = ReservationStatus::CHECKED_IN; // en cours
                $res->setCheckinAt($arrival->setTime(14, 0));
                // la chambre est occupée en ce moment
                $room->setStatus(RoomStatus::OCCUPIED);
            } else {
                $status = ReservationStatus::CHECKED_OUT; // passé
                $res->setCheckinAt($arrival->setTime(14, 0));
                $res->setCheckoutAt($departure->setTime(11, 0));
            }
            $res->setStatus($status);

            // Paiements (0%, 50% ou 100%)
            $payMode = $faker->randomElement([0, 50, 100]);
            if ($payMode > 0) {
                $pay = (new Payment())
                    ->setReservation($res)
                    ->setMethod($faker->randomElement([PaymentMethod::CASH, PaymentMethod::CARD, PaymentMethod::MOBILE_MONEY]))
                    ->setAmount(number_format($total * ($payMode / 100), 2, '.', ''))
                    ->setCurrency('XOF')
                    ->setPaidAt(($today < $arrival ? $today : $arrival)->setTime(12, 0))
                    ->setReference('PMT-' . strtoupper($faker->bothify('####??')));
                $manager->persist($pay);
            }

            $manager->persist($res);
            $this->addReference('reservation_' . $i, $res);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, RoomFixtures::class, GuestFixtures::class];
    }
}
