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

    public function insert(Product $product)
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO product (name, description, price, created_at)
            VALUES (:name, :description, :price, :createdAt)
        ');
        $stmt->bindValue(':name', $product->getName());
        $stmt->bindValue(':description', $product->getDescription());
        $stmt->bindValue(':price', $product->getPrice());
        $stmt->bindValue(':createdAt', date('Y-m-d H:i:s'));

        $stmt->execute();
    }
}