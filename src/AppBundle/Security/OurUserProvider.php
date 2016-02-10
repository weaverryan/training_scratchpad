<?php

namespace AppBundle\Security;

use AppBundle\Model\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class OurUserProvider implements UserProviderInterface
{
    // used by remember_me and switch_user
    public function loadUserByUsername($username)
    {
        return new User($username);
    }

    // used for session-based auth
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass($class)
    {
        // we only have 1 user class
        return true;
    }

}