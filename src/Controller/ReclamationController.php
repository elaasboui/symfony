<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(ManagerRegistry $manager, Request $request): Response
    {
        $entityManager = $manager->getManager();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setEtat(0);
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('add_reclamation');
        }

        return $this->render('reclamation/index.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/show/{name}', name: 'show_reclamation')]
    public function showReclamation($name): Response
    {
        return $this->render('reclamation/showReclamation.html.twig', ['name' => $name]);
    }

    #[Route('/reclamation/{id}', name: 'reclamation_details')]
    public function reclamationDetails($id, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = $reclamationRepository->find($id);

        return $this->render('reclamation/show.html.twig', ['reclamation' => $reclamation, 'id' => $id]);
    }

    #[Route('/add', name: 'add_reclamation')]
    public function addReclamation(ManagerRegistry $manager, Request $request): Response
    {
        $entityManager = $manager->getManager();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setEtat(0);
            $entityManager->persist($reclamation);
            $entityManager->flush();
          
            return $this->redirectToRoute('add_reclamation');
        }

        return $this->renderForm('reclamation/index.html.twig', ['form' => $form]);
    }

    #[Route('/list', name: 'list_Reclamation')]
    public function listReclamtion(ReclamationRepository $reclamrepository): Response
    {
        return $this->render('reclamation\list.html.twig', [
            'reclamations' => $reclamrepository->findAll(),
        ]);
    }

    



    #[Route('/editreclamation/{id}', name: 'reclamation_edit')]
    public function editReclamation($id, Request $request, ReclamationRepository $reclamationRepository, EntityManagerInterface $entityManager): Response
{     
    
    $reclamation = $reclamationRepository->find($id);

    if (!$reclamation) {
        throw $this->createNotFoundException('La réclamation avec l\'identifiant ' . $id . ' n\'existe pas');
    }

    $form = $this->createForm(ReclamationType::class, $reclamation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_reclamation', ['id' => $reclamation->getId()]);
    }

    return $this->renderForm('reclamation/editreclam.html.twig', [
        'form' => $form,
        'reclamation' => $reclamation,
    ]);
}




    #[Route('/deleteReclamation/{id}', name: 'Reclamation_delete')]
    // ReclamationController.php

public function deleteReclam(Request $request, $id, ManagerRegistry $manager, ReclamationRepository $reclamrepository): Response
{
    $em = $manager->getManager();
    $reclam = $reclamrepository->find($id);
    
    // Remove associated Reponsee entities
    foreach ($reclam->getReponses() as $reponse) {
        $em->remove($reponse);
    }
    
    // Remove the Reclamation entity
    $em->remove($reclam);
    $em->flush();

    return $this->render('reclamation/delete.html.twig');
}

}
