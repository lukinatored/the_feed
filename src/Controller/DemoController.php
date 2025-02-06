<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DemoController extends AbstractController
{
    #[Route('/hello', name: 'hello', methods: ["GET"])]
    public function index(): Response
    {
        return $this->render("demo/demo1.html.twig");
    }

    #[Route('/hello/{nom}', name: 'hello2', methods: ["GET"])]
    public function index2(string $nom): Response
    {
        return $this->render("demo/demo2.html.twig", ["nom" => $nom]);
    }
    #[Route('/hello3', name: 'hello3', methods: ["GET"])]
    public function index3(): Response
    {
        $listCourses = [
            "egg",
            "milk",
            "potato"
        ];

        return $this->render("demo/demo3.html.twig", ["list" => $listCourses]);
    }
#[Route('/hello4', name: 'hello4', methods: ["GET"])]
public function index4(): Response
{
    $this->addFlash('success', 'Bienvenue sur la page hello4 !');
    return $this->redirectToRoute('hello3');
}

}