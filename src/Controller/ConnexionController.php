<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConnexionController extends AbstractController
{
    #[Route('/', name: 'app_connexion')]
    public function index(): Response
    {
        return $this->render('connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',
        ]);
    }

    #[Route('/connexion', name: 'app_connexion_post', methods: ['POST'])]
    public function connexion(): Response
    {
        //var_dump($this->getUser());
        // Vérifier si l'utilisateur est connecté
        if ($this->getUser()) {
            echo ('Vous êtes déjà connecté');
            //return $this->redirectToRoute('app_home');
        }

        // Votre logique de connexion ici

        // Rediriger vers la page de connexion en cas d'échec de connexion
        return $this->redirectToRoute('app_connexion');
    }
}
