<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Pizza;
use App\Entity\Ingredient;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/pizzas", name="pizzas_list")
     * @Template()
     */
    public function pizzasAction()
    {
        return [
            'pizzas' => [
                '4 fromages', 'Reine', 'Paysanne'
            ]
        ];
    }

    /**
     * @Route("/insert", name="test")
     */
    public function insertPizzasAction() {
        $em = $this->get('doctrine')->getManager();

        $mozarella = new Ingredient();
        $mozarella->setName('Mozarella2');
        $parmesan = new Ingredient();
        $parmesan->setName('Parmesan2');
        $quatreFromages = new Pizza();
        $quatreFromages
            ->setName('6 fromages')
            ->setPrice(32.2)
            ->setDescription('Pour les gourmands de fromage')
            ;   
        $quatreFromages->addIngredient($mozarella);
        $quatreFromages->addIngredient($parmesan);
        $em->persist($quatreFromages);
        $em->persist($mozarella);
        $em->persist($parmesan);
        $em->flush();

        return new Response('Pizzas créées');
        // $pizzas = $em->getRepository('Pizza')
        //         ->findAll();
    }

    /**
     * @Route("admin", name="admin")
     * @Template()
     */
    public function adminAction()
    {
        return [];
    }
}