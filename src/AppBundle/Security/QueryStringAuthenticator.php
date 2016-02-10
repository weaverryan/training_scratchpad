<?php

namespace AppBundle\Security;

use AppBundle\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class QueryStringAuthenticator extends AbstractGuardAuthenticator
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/login') {
            return;
        }

        return $request->query->get('username');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return new User($credentials);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->getFlashbag()->add('error', $exception->getMessageKey());

        $url = $this->urlGenerator->generate('homepage');

        return new RedirectResponse($url);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $request->getSession()->getFlashbag()->add('success', 'Yay! You are authenticated!');

        $url = $this->urlGenerator->generate('homepage');

        return new RedirectResponse($url);
    }

    public function supportsRememberMe()
    {
        return true;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $request->getSession()->getFlashbag()->add('error', 'You need to login by going to /login?username=');

        $url = $this->urlGenerator->generate('homepage');

        return new RedirectResponse($url);
    }
}
