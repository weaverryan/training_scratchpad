<?php

namespace AppBundle\Repository\Test;

use AppBundle\Repository\ProductRepository;

class FakedProductRepository extends ProductRepository
{
    protected function getJson($uri)
    {
        if ($uri == '/products.json') {
            $products = [];
            $products[] = [
                'id' => 10,
                'name' => 'Test Product',
                'price' => 99,
                'description' => 'Lorem ipsum',
                'created_at' => '2015-12-06 12:15:30'
            ];
            $products[] = [
                'id' => 15,
                'name' => 'Test Product2',
                'price' => 30,
                'description' => 'Baz bazzles description',
                'created_at' => '2016-01-15 23:00:05'
            ];

            return $products;
        }

        throw new \Exception('Unsupported url: '.$uri);
    }

}