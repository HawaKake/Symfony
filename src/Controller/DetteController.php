<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'app_dette')]
    public function index(): Response
    {
        return $this->render('dette/index.html.twig', [
            'controller_name' => 'DetteController',
        ]);
    }



    #[Route('/dettes', name: 'dettes_list')]
    public function index(DetteRepository $detteRepository, Request $request): Response
    {
     
        $statuts = $request->query->get('statut', []);

       
        $dettes = $detteRepository->findByStatut($statuts);

        return $this->render('dette/index.html.twig', [
            'dettes' => $dettes,
        ]);
    }

    #[Route('/dette/creer', name: 'dette_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dette = new Dette();
        $dette->setCreateAt(new \DateTime());

        $form = $this->createForm(DetteType::class, $dette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dette);
            $entityManager->flush();

            return $this->redirectToRoute('dettes_list');
        }

        return $this->render('dette/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}







 
