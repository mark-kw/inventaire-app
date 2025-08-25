<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250825174210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD reservation_id INT NOT NULL, ADD method VARCHAR(255) NOT NULL, CHANGE amount amount NUMERIC(12, 2) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6D28840DB83297E7 ON payment (reservation_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD status VARCHAR(255) NOT NULL, ADD currency VARCHAR(255) DEFAULT NULL, CHANGE xof checkin_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DB83297E7
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6D28840DB83297E7 ON payment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment DROP reservation_id, DROP method, CHANGE amount amount VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP status, DROP currency, CHANGE checkin_at xof DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }
}
