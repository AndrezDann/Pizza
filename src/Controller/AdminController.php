<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Pizza;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends Controller
{
    /**
     * @Route("/new", name="new_pizza")
     * @Template()
     */
    public function new(Request $request)
    {
        $pizza = new Pizza();
        //$pizza->setPizza('Nouvelle Pizza');

        $form = $this->createFormBuilder($pizza)
            ->add('name', TextType::class)
            ->add('price', TextType::class)
            ->add('description', TextareaType::class)
            //->add('ingredients', TextType::class)
            /* ->add('ingredients', EntityType::class, array(
                'class' => 'App\Entity\Ingredient',
                'choice_label' => 'name'
             )) */
            ->add('save', SubmitType::class, array('label' => 'Ajouter'))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $pizza_info = $form->getData();
                $ingredient = new Ingredient();
                $ingredient->setName('Piment');

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                $entityManager = $this->getDoctrine()->getManager();
                $pizza->addIngredient($ingredient);
                $entityManager->persist($pizza_info);
                $entityManager->persist($ingredient);
                
                $entityManager->flush();

                return $this->redirectToRoute('new_pizza');
            }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    

    
}