<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class UtilisateurController extends AbstractController
{
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request): Response
    {
        
        $utilisateur = new Utilisateur();

        
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

           
            return $this->redirectToRoute('success_page'); 
        }
        return $this->render('utilisateur/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
