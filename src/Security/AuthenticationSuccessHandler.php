<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            return new RedirectResponse($this->urlGenerator->generate('app_dashboard'));
        }elseif (in_array('ROLE_FOURNISSEUR', $roles)) {
            return new RedirectResponse($this->urlGenerator->generate('home'));
        }elseif (in_array('ROLE_EXPERT', $roles)) {
            return new RedirectResponse($this->urlGenerator->generate('home'));
        }elseif (in_array('ROLE_AGRICULTEUR', $roles)) {
            return new RedirectResponse($this->urlGenerator->generate('home'));
        }
        
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
}