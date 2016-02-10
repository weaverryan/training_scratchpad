<?php

namespace AppBundle\Security;

use AppBundle\Model\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RandomVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Product;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case 'EDIT':
                return rand(1, 10) > 5;
            default:
                throw new \Exception('Unsupported attribute: '.$attribute);
        }
    }

}