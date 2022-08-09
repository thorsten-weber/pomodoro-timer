<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        // TODO: render real stuff
        return $this->render('index.html.twig', [
        ]);
    }
}