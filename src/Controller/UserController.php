<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user",methods={"GET"})
     */
    public function index(UserRepository $repository): Response
    {
        $user=$repository->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $user
        ]);
    }

    /**
     * @Route("/new", name="user_new",methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $users=new User();
        $form=$this->createForm(UserType::class,$users);
        $form->handleRequest ($request);
        if ($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager();
            $om->persist($users);
            $om->flush();
            return $this->redirectToRoute("user");
        }

        return $this->render('user/create.html.twig', [
            'user' => $users,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit",methods={"GET","POST"})
     */
    public function edit(Request $request,User $user ): Response
    {
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest ($request);
        if ($form->isSubmitted() && $form->isValid()){
            $om=$this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("user");
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/", name="user_show",methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $user
        ]);
    }
}
