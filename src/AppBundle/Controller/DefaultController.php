<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/insert", name="insert")
     */
    public function insertAction()
    {
        $db = new \PDO('sqlite:'.__DIR__.'/../../../app/data.db');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->text(50);
            $description = $faker->paragraph(1);
            $price = $faker->numberBetween(10, 150);
            $createdAt = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s');

            $db->exec("
                INSERT INTO product (name, description, price, created_at)
                VALUES ('$name', '$description', $price, '$createdAt')
            ");
        }

        return new Response('ding!');
    }

    /**
     * @Route("/get", name="get")
     */
    public function getAction()
    {
        $db = new \PDO('sqlite:'.__DIR__.'/../../../app/data.db');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $result = $db->query('SELECT * FROM product');

        foreach ($result as $row) {
            dump($row);
        }
        die;

        return new Response('ding!');
    }
}
