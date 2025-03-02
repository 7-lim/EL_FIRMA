<?php

namespace App\Security;

use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Utilisateur) {
            return;
        }

        if ($user->getIsBlocked()) {
            throw new CustomUserMessageAccountStatusException('Your account is blocked. Contact the administrator.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // No action needed
    }
}