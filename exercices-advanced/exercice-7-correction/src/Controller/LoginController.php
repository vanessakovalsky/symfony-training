<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LoginType;

class LoginController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     */
    public function connexion(Request $request)
    {
      $form = $this->createForm(LoginType::class);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          return $this->redirectToRoute('home');
      }
      return $this->render('login/login.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}
