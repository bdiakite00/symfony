<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire",methods={"GET"})
     */
    public function index(CommentaireRepository $repos): Response
    {
        $commentaire=$repos->findAll();
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
            'commentaires'=>$commentaire
        ]);
    }

    /**
     * @Route("/commentaire", name="commentaire_new",methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $commentaire=new Commentaire();
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->persist($commentaire);
            $om->flush();
            return $this->redirectToRoute("commmentaire");
        }
        return $this->render('commentaire/commentaire.html.twig', [
            'controller_name' => 'CommentaireController',
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/commentaire", name="commentaire_edit",methods={"GET", "POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->flush();
            return $this->redirectToRoute("commmentaire");
        }
        return $this->render('commentaire/commentaire.html.twig', [
            'commentaire' => $commentaire,
            'form'=>$form->createView()
        ]);
    }
}
