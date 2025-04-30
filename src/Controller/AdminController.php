<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/test', name: 'admin_dashboard')]
    public function index(): Response
    {
        dd('tableau de board admin');
        return $this->render('admin/dashboard.html.twig'); 
    }
}
