<?php

namespace AppBundle\Repository;

use AppBundle\Model\Product;

class ProductRepository
{
    /**
     * @return Product[]
     */
    public function findAll()
    {
        $db = new \PDO('sqlite:'.__DIR__.'/../../../app/data.db');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $result = $db->query('SELECT * FROM product');

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