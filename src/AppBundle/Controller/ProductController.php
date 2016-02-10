<?php

namespace AppBundle\Controller;

use AppBundle\Model\Product;
use AppBundle\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="product_list")
     */
    public function indexAction()
    {
        $products = $this->get('product_repository')->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}