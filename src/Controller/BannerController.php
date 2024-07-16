<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BannerController extends AbstractController
{
    #[Route('/banner', name: 'app_banner')]
    public function index(): Response
    {
        return $this->render('banner/index.html.twig', [
            'controller_name' => 'BannerController',
        ]);
    }
}
