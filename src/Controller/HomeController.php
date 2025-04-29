<?php

namespace App\Controller;

use App\Entity\Dahiras;
use App\Entity\Encadreur;
use App\Entity\Membres;
use App\Entity\Reunion;
use App\Entity\User;
use App\Repository\ReunionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    private $entityManager;
    private $reunionRepository;
    public function __construct(EntityManagerInterface $entityManager,ReunionRepository $reunionRepository)
    {
        $this->entityManager = $entityManager;
        $this->reunionRepository = $reunionRepository;

    }

 


    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
      
        
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       
        
        return $this->render('home/dashboard_admin.html.twig');
    }
}
