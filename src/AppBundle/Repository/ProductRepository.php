<?php

namespace AppBundle\Repository;

use AppBundle\Model\Product;

class ProductRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Product[]
     */
    public function findAll()
    {
        $result = $this->pdo->query('SELECT * FROM product');

        $products = [];
        foreach ($result as $row) {
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
}