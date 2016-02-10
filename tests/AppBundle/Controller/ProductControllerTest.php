<?php

namespace Tests\AppBundle\Controller;

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use GuzzleHttp\Client;

class ProductControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testListProducts()
    {
        $driver = new GoutteDriver();
        $session = new Session($driver);

        $session->visit('http://localhost:9004/app_test.php/products');
        $this->assertEquals(200, $session->getStatusCode());

        $page = $session->getPage();
        $this->assertCount(2, $page->findAll('css', 'h3'));
    }
}
