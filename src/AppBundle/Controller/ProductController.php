<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProductForm;
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

    /**
     * @Route("/products/new", name="product_new")
     */
    public function newAction()
    {
        $form = $this->createForm(ProductForm::class);

        return $this->render('product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}