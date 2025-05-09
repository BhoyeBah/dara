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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{



    #[Route('/', name: 'app_home')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(
        Request $request,
        DahirasRepository $dahirasRepository,
        MembresRepository $membresRepository,
        EncadreurRepository $encadreurRepository,
        ReunionRepository $reunionRepository,
    ): Response {

        $mois = $request->query->get('mois', date('m'));
        $annee = $request->query->get('annee', date('Y'));
        $date = \DateTime::createFromFormat('Y-m', "$annee-$mois");
        $resultats = $reunionRepository->countReunionsParDahira($mois, $annee);
        $dahiraCount = $dahirasRepository->countDahiras();
       
        $totalReunions = array_sum(array_column($resultats, 'nombre_reunions'));
        $ratio = $dahiraCount > 0 ? "$totalReunions/$dahiraCount" : "0/0";


        $dahiraCount = $dahirasRepository->countDahiras();
        $membreCount = $membresRepository->membreCount();
        $encadreurCount = $encadreurRepository->encadreurCount();
        $allnewMembre = $membresRepository->countNewMembres();
        $reunionCounts = $reunionRepository->reunionCount();



        if ($this->isGranted('ROLE_ENCADREUR')) {
            $user = $this->getUser();
            $encadreur = $user->getEncadreur();
            $dahira = $encadreur->getDahiras();

            $newMembre = $membresRepository->countNewMembresByDahira($dahira);
            $membreCount = $membresRepository->countMembresByDahira($dahira);
            $reunionCount = $reunionRepository->countReunionByDahira($dahira);

            // Préparer les données pour le rendu
            $dataDahira = [
                'dahira' => $dahira,
                'membreCount' => $membreCount,
                'reunionCount' => $reunionCount,
                'newMembre' => $newMembre
            ];

            return $this->render('home/dashboard_encadreur.html.twig', $dataDahira);
        }


        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_PRESIDENT')) {
            return $this->render('home/dashboard_admin.html.twig', [
                'dahiraCount' => $dahiraCount,
                'membreCount' => $membreCount,
                'encadreurCount' => $encadreurCount,
                'allnewMembre' => $allnewMembre,
                'reunionsCount' => $reunionCounts,
                'ratio' => $ratio,
            ]);
        }
    }
}
