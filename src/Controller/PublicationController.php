<?php

namespace App\Controller;

use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PublicationRepository;
use App\Service\FlashMessageHelper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PublicationController extends AbstractController
{
    #[Route('/feed', name: 'feed', methods: ['GET', 'POST'])]
    public function findAllOrderedByDate(
        Request $request, 
        EntityManagerInterface $entityManager,
        PublicationRepository $publicationRepository,
        FlashMessageHelper $flashMessageHelper
    ): Response
    {
        $publications = $publicationRepository->createQueryBuilder('p')
            ->orderBy('p.date', 'DESC')
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($publications as $publication) {
            $authorName = $publication->getAuthor() ? $publication->getAuthor()->getName() : 'Auteur inconnu';
            $data[] = [
                'title' => $publication->getTitle(),
                'text' => $publication->getText(),
                'createdAt' => $publication->getDate()->format('Y-m-d H:i:s'),
                'author' => $authorName,
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
            $entityManager->persist($publication);
            $entityManager->flush();

            $this->addFlash('success', 'Publication créée avec succès !');

            return $this->redirectToRoute('feed');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $flashMessageHelper->addFormErrorsAsFlash($form);  
        }

        $result = count($data);

        return $this->render('publication/feed.html.twig', [
            'publications' => $data,
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }
}
