<?php

namespace App\Controller;

use App\Entity\Dahiras;
use App\Entity\Encadreur;
use App\Entity\Membres;
use App\Entity\Reunion;
use App\Entity\User;
use App\Repository\DahirasRepository;
use App\Repository\EncadreurRepository;
use App\Repository\MembresRepository;
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
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request,DahirasRepository $dahirasRepository, 
    MembresRepository $membresRepository, EncadreurRepository $encadreurRepository): Response
    {
       
        $dahiraCount = $dahirasRepository->countDahiras();
        $membreCount = $membresRepository->membreCount();
        $encadreurCount = $encadreurRepository->encadreurCount();
        $allnewMembre = $membresRepository->countNewMembres();
        if ($this->isGranted('ROLE_ENCADREUR')) {
            $user = $this->getUser();
            $encadreur = $user->getEncadreur();
            $dahira = $encadreur->getDahiras();

            $newMembre = $membresRepository->countNewMembresByDahira($dahira);
            $membreCount = $this->entityManager->getRepository(Membres::class)->count(['dahiras' => $dahira]);
            $reunionCount = $this->entityManager->getRepository(Reunion::class)->count(['dahiras' => $dahira]);
        
            // Préparer les données pour le rendu
            $dataDahira = [
                'dahira' => $dahira,
                'membreCount' => $membreCount,
                'reunionCount' => $reunionCount,
                'newMembre' => $newMembre
            ];
        
            return $this->render('home/dashboard_encadreur.html.twig', $dataDahira);
        }
        
        return $this->render('home/dashboard_admin.html.twig', [
            'dahiraCount' => $dahiraCount,
            'membreCount' => $membreCount,
            'encadreurCount' => $encadreurCount,
            'allnewMembre' => $allnewMembre,
        ]);
    }
}
