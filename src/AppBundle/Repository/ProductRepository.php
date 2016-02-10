<?php

namespace AppBundle\Repository;

use AppBundle\Model\Product;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProductRepository
{
    private $client;

    private $logger;

    private $serializer;

    public function __construct(Client $client, LoggerInterface $logger, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * @return Product[]
     */
    public function findAll()
    {
        $data = $this->getJson('/products.json');

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
        $this->logger->info(sprintf('Returning %s products', count($products)));

        return $products;
    }

    public function insert(Product $product)
    {
        $this->client->post('/products.json', [
            'body' => $this->serializer->serialize($product, 'json')
        ]);
    }

    /**
     * @param string $uri
     * @return array
     * @throws \Exception
     */
    protected function getJson($uri)
    {
        $response = $this->client->get($uri);

        $data = json_decode($response->getBody(), true);
        if (false === $data) {
            // error handling
            // PSR-7
            throw new \Exception('Bad response! '.$response->getBody());
        }

        return $data;
    }
}