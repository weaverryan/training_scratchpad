<?php

namespace AppBundle\Repository;

use AppBundle\Model\Product;
use GuzzleHttp\Client;

class ProductRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Product[]
     */
    public function findAll()
    {
        $response = $this->client->get('/products.json');

        $data = json_decode($response->getBody(), true);
        if (false === $data) {
            // error handling
            // PSR-7
            throw new \Exception('Bad response! '.$response->getBody());
        }

        $products = [];
        foreach ($data as $row) {
            $product = new Product();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setDescription($row['description']);
            $product->setPrice($row['price']);
            $product->setCreatedAt(\DateTime::createFromFormat('Y-m-d H:i:s', $row['created_at']));

            $products[] = $product;
        }

        return $products;
    }

    public function insert(Product $product)
    {
        $data = [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'createdAt' => date('Y-m-d H:i:s')
        ];

        $this->client->post('/products.json', [
            'body' => json_encode($data)
        ]);
    }
}