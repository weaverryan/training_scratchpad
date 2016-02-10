<?php

namespace AppBundle\Test;

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FunctionalTestCase extends KernelTestCase
{
    private $session;

    /**
     * @return Session
     */
    public function getSession()
    {
        if ($this->session === null) {
            $driver = new GoutteDriver();
            $this->session = new Session($driver);
        }

        return $this->session;
    }

    protected function visit($uri)
    {
        $baseUrl = getenv('TEST_BASE_URL');
        $this->getSession()->visit($baseUrl.'/'.ltrim($uri, '/'));
    }
}
