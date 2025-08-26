<?php

namespace App\Security;

use DateTimeImmutable;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class JwtAuthSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private AuthenticationSuccessHandlerInterface $inner,
        private RefreshTokenManagerInterface $refreshTokenManager,
        private int $ttlDays = 30
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        /** @var UserInterface $user */
        $user = $token->getUser();

        // 1) Laisser Lexik fabriquer la réponse avec le JWT ({"token": "...", ...})
        $response = $this->inner->onAuthenticationSuccess($request, $token);
        $data = json_decode($response->getContent() ?: '{}', true);

        // 2) Générer + persister un refresh_token
        $refresh = $this->refreshTokenManager->create();
        $refresh->setUsername($user->getUserIdentifier());
        $refresh->setRefreshToken(bin2hex(random_bytes(32)));
        $refresh->setValid((new DateTimeImmutable())->modify("+{$this->ttlDays} days"));
        $this->refreshTokenManager->save($refresh);

        // 3) Enrichir la réponse
        $data['refresh_token'] = $refresh->getRefreshToken();

        // (Optionnel) Ajouter des infos utiles au front
        // $data['user'] = ['email' => $user->getUserIdentifier(), 'roles' => $user->getRoles()];
        // $data['expires_in'] = 3600; // si tu veux indiquer le TTL de l'access token

        return new JsonResponse($data);
    }
}
