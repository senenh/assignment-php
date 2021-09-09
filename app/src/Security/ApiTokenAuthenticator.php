<?php

namespace App\Security;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    private $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function supports(Request $request): ?bool
    {
        // look for header "Authorization: Bearer <token>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $token = $request->headers->get('Authorization');

        if (null === $token) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $token = substr($token, 7);


        /** @var ApiToken $apiToken */
        $apiToken = $this->apiTokenRepository->findOneBy(['token' => $token]);

        if (null === $apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('API token not found');
        }

        $user = $apiToken->getUser();

        return new SelfValidatingPassport(new UserBadge($user->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntrypointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
