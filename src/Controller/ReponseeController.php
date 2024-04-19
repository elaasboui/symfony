<?php

namespace App\Controller;

use App\Entity\Reponsee;
use App\Form\ReponseeType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;



class ReponseeController extends AbstractController
{
   

   
    #[Route('/reponse', name: 'app_reponse')]
    public function index(): Response
    {
        return $this->render('reponsee/index.html.twig', [
            'controller_name' => 'ReponseeController',
        ]);
    }
    #[Route('/addreponse', name: 'add_Rep')]
    public function addRep(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();
        $reclamationId = $request->query->get('id');
        $reclamation = $em->getRepository(Reclamation::class)->find($reclamationId);
    
        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée.');
        }
    
        $reponse = new Reponsee();
        $reponse->setReclamation($reclamation);
    
        $form = $this->createForm(ReponseeType::class, $reponse);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reponse);
            $em->flush();
    
            
            $reclamation->setEtat(1);
          
            $em->flush();
            return $this->redirectToRoute('list_b');
        }
    
        return $this->renderForm('reponsee/addrep.html.twig', [
            'form' => $form,
            'reclamation' => $reclamation,
        ]);
    }
    #[Route('/editrep/{id}', name: 'rep_edit')]
    public function editrep(Request $request, ManagerRegistry $manager, $id, ReponseeRepository $reprepository): Response
    {
        $em = $manager->getManager();

        $rep = $repepository->find($id);
        $form = $this->createForm(ReponseeType::class, $rep);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($rep);
            $em->flush();
            return $this->redirectToRoute('list_Reclamation');
        }
        return $this->renderForm('reponsee/editrep.html.twig', ['form' => $form]);

    }
    #[Route('/listback', name: 'list_b')]
    public function listReclamtion(ReclamationRepository $reclamrepository): Response
    {
        return $this->render('reponsee\listback.html.twig', [
            'reclamations' => $reclamrepository->findAll(),
        ]);
    }
    
}
