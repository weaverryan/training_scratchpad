<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Repository\ProductRepository;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    public function testFindAll()
    {
        self::bootKernel();

        $productsData = [];
        $productsData[] = [
            'id' => 10,
            'name' => 'Foo',
            'description' => 'bar',
            'price' => 10,
            'created_at' => '2015-10-24 00:20:30',
        ];
        $productsData[] = [
            'id' => 15,
            'name' => 'Foo2',
            'description' => 'bar2',
            'price' => 20,
            'created_at' => '2015-10-24 00:20:30',
        ];

        $client = $this->prophesize('GuzzleHttp\Client');
        $client->get('/products.json')
            ->willReturn(new Response(200, [], json_encode($productsData)));

        $logger = $this->prophesize('Psr\Log\LoggerInterface');

        $repo = new ProductRepository(
            $client->reveal(),
            $logger->reveal(),
            self::$kernel->getContainer()->get('serializer')
        );

        $products = $repo->findAll();
        $this->assertCount(2, $products);
        $this->assertEquals('Foo', $products[0]->getName());
        $this->assertEquals('2015-10-24 00:20:30', $products[0]->getCreatedAt()->format('Y-m-d H:i:s'));
    }
}
