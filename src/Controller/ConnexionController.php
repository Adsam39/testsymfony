<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class ConnexionController extends AbstractController
{

    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/', name: 'app_connexion')]
    public function index(): Response
    {
        return $this->render('connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',
        ]);
    }

    /*#[Route('/connexion', name: 'app_connexion_post', methods: ['POST'])]
    public function connexion(Request $request, UserPasswordHasherInterface $passwordHasher, AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs de connexion s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupérer le dernier nom d'utilisateur saisi (s'il y en a)
        $lastUsername = $authenticationUtils->getLastUsername();


        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Récupérer les données du formulaire
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // Vérifier les identifiants de l'utilisateur
        $entityManager = $this->managerRegistry->getManager();
        $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
        if ($user && $passwordHasher->isPasswordValid($user, $password)) {
            // Connecter l'utilisateur et rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        //return $this->redirectToRoute('app_connexion');
        // Rediriger vers la page de connexion avec un message d'erreur
        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => 'Identifiants invalides.',
        ]);
    }*/

    #[Route('/connexion', name: 'app_connexion_post', methods: ['POST'])]
    public function connexion(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $entityManager = $this->managerRegistry->getManager();
        $user = $entityManager->getRepository(User::class)->findOneByEmail($email);

        if ($user && $user->getPassword() === $password) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('connexion/index.html.twig', [
            'error' => 'Identifiants invalides.',
        ]);
    }

    #[Route('/logout', name: 'app_deconnexion')]
    public function deconnexion(): Response
    {
        return $this->redirectToRoute('app_connexion');
    }
}
