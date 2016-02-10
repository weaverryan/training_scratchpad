<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProductForm;
use AppBundle\Model\Product;
use AppBundle\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function newAction(Request $request)
    {
        $form = $this->createForm(ProductForm::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            dump($form->getData());die;
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}