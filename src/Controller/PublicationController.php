<?php

namespace App\Controller;

use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PublicationRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;

class PublicationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(private PublicationRepository $publicationRepository)
    {
    }

    #[Route('/feed', name: 'feed', methods: ['GET','POST'])]
    public function findAllOrderedByDate(): Response
    {
        $publications = $this->publicationRepository->createQueryBuilder('p')
            ->orderBy('p.date', 'DESC')
            ->getQuery();
    
        $data = [];
        foreach ($publications as $publication) {
            $data[] = [
                'title' => $publication->getTitle(),
                'text' => $publication->getContent(),
                'createdAt' => $publication->getCreatedAt()->format('Y-m-d H:i:s'),
                'author' => $publication->getAuthor()->getName(),
            ];
        }

        $publication = new Publication();
    
        $form = $this->createFormBuilder($publication)
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('text', TextareaType::class, ['label' => 'Contenu'])  
            ->add('submit', SubmitType::class, ['label' => 'Créer Publication'])
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setDate(new \DateTime()); 
            $this->entityManager->persist($publication);
            $this->entityManager->flush();
        }

        return $this->render('publication/feed.html.twig', [
            'publications' => $data,
            'form' => $form->createView(),
        ]);
    }
}
    
