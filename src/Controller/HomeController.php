<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ContactRepository;
use App\Entity\Contact;

class HomeController extends AbstractController
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        //avoir toutes les données de contact
        $entityManager = $this->managerRegistry->getManager();
        $contacts = $entityManager->getRepository(Contact::class)->findAll();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'contacts' => $contacts
        ]);
    }
}
