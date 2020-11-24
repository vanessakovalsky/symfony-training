<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{

  /**
   * @Route("/", name="home")
  */
  public function welcome()
  {
    return $this->render('dashboard/index.html.twig');

  }
}
