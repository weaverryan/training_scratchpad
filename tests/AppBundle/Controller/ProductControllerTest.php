<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Test\FunctionalTestCase;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use GuzzleHttp\Client;

class ProductControllerTest extends FunctionalTestCase
{
    public function testListProducts()
    {
        $session = $this->getSession();

        $session->visit('http://localhost:9004/app_test.php/products');
        $this->assertEquals(200, $session->getStatusCode());

        $page = $session->getPage();
        $this->assertCount(2, $page->findAll('css', 'h3'));
    }

    public function testAddProducts()
    {
        $session = $this->getSession();

        $session->visit('http://localhost:9004/app_test.php/products');

        $page = $session->getPage();
        $page->clickLink('New Product');
        $page->fillField('Name', 'Foo');
        $page->fillField('Description', 'Description');
        $page->fillField('MSRP', '5.99');
        $page->pressButton('Save');

        $this->assertContains('You did it!', $page->getText());
    }
}
