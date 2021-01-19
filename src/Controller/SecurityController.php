<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */

    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $utilisateur = new Utilisateur();


        $form = $this->createForm(RegistrationType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            $utilisateur->setPassword($hash);

                $manager->persist($utilisateur);
                $manager->flush();


        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}   
