<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(): Response
    {
        // $user = $this->getUser();
        // dd($user);
        return $this->render('home/index.html.twig', [
       
        ]);
    }
}
