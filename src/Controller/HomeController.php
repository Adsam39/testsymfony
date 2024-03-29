<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ContactRepository;
use App\Entity\Contact;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

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

    #[Route('/home/add', name: 'app_add')]
    public function addContactPage(): Response
    {
        return $this->render('home/add.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home/addcontact', name: 'app_add_post', methods: ['POST'])]
    public function addContact(Request $request): Response
    {
        var_dump($request->request->all());
        $entityManager = $this->managerRegistry->getManager();

        $user = $entityManager->getRepository(User::class)->find(1);

        $contact = new Contact();
        $contact->setName($request->request->get('name'));
        $contact->setProfession($request->request->get('profession'));
        $departement = intval($request->request->get('department'));
        $contact->setDepartement($departement);
        $contact->setVille($request->request->get('city'));
        $contact->setCreatedAt(new \DateTime());
        //$contact->setUser($this->getUser());
        $contact->setUser($user);
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
