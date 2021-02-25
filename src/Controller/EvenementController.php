<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement", methods={"GET"})
     */
    public function index(EvenementRepository $repository): Response
    {
        $eneves=$repository->findAll();
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'evenements'=>$eneves
        ]);
    }

    /**
     * @Route("/evenement/create", name="evenement_new", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $evenement=new Evenement();
        $user=new User();
        $user=$this->getUser();
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->handleRequest($request);
        $evenement->setCreatedAt(new \DateTime());
        $evenement->setUser($user);
        if($form->isSubmitted() && $form->isValid()){

            $om=$this->getDoctrine()->getManager();
            $om->persist($evenement);
            $om->flush();
            return $this->redirectToRoute("evenement");
        }
        return $this->render('evenement/create.html.twig', [
            'controller_name' => 'EvenementController',
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/evenement/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->handleRequest($request);
        $evenement->setCreatedAt(new \DateTime());
        if($form->isSubmitted() && $form->isValid()){

            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute("evenement");
        }
        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/evenement/show/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        $this->redirectToRoute('evenement_show');
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'evenements'=>$evenement
        ]);
    }
    /**
     * @Route("/{id}", name="evenement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement');
    }


}
