<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;


class FootballCupController extends AbstractController
{

    public function getListGames(){
      $httpClient = HttpClient::create();

      $response = $httpClient->request('GET','/v2/competitions')->getBody();
      $objet = json_decode($response);
      return $objet->competitions;
    }
}
