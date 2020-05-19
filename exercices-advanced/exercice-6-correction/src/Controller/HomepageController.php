<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomepageController
{

  /**
   * @Route("/", name="home")
  */
  public function welcome()
  {
    return new Response(
      '<html><body>Bienvenue sur notre application
      de pronostic<br />
      <p><a href="game/">Accéder aux Games</a>
      <a href="utilisateur/">Accéder aux Utilisateurs</a>
      <a href="pronostic/">Accéder aux Pronostics</a>
      </p></body></html>'
    );
  }
}
