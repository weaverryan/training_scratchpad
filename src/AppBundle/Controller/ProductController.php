<?php

namespace AppBundle\Controller;

use AppBundle\Model\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="product_list")
     */
    public function indexAction()
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

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}