<?php

namespace App\Controller;

use App\Entity\Pronostic;
use App\Form\PronosticType;
use App\Repository\PronosticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use App\Controller\FootballCupController;
use App\Event\LogEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/pronostic")
 */
class PronosticController extends AbstractController
{

  private $logger;

  public function __construct(LoggerInterface $logger_interface, FootballCupController $football_cup, EventDispatcherInterface $event_dispatcher){
    $this->logger = $logger_interface;
    $this->football_cup = $football_cup;
    $this->event_dispatcher = $event_dispatcher;
  }
    /**
     * @Route("/", name="pronostic_index", methods="GET")
     */
    public function index(PronosticRepository $pronosticRepository): Response
    {
      //$liste_competitions = $this->football_cup->getListGames();
      $this->logger->info('Affichage de la page index pronostic');
        return $this->render('pronostic/index.html.twig', ['pronostics' => $pronosticRepository->findAll()]);
    }

    /**
     * @Route("/new", name="pronostic_new", methods="GET|POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function new(Request $request): Response
    {
        $pronostic = new Pronostic();
        $form = $this->createForm(PronosticType::class, $pronostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pronostic);
            $em->flush();

            return $this->redirectToRoute('pronostic_index');
        }

        //$log_event = new LogEvent();
        //$this->event_dispatcher->dispatch(LogEvent::LOGAPP, $log_event);

        return $this->render('pronostic/new.html.twig', [
            'pronostic' => $pronostic,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="pronostic_show", methods="GET")
     */
    public function show(Pronostic $pronostic): Response
    {
        return $this->render('pronostic/show.html.twig', ['pronostic' => $pronostic]);
    }

    /**
     * @Route("/{id}/edit", name="pronostic_edit", methods="GET|POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function edit(Request $request, Pronostic $pronostic): Response
    {
      if($this->getUser()->getId() == $pronostic->getIdUser()->getId())
      {
        $form = $this->createForm(PronosticType::class, $pronostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pronostic_edit', ['id' => $pronostic->getId()]);
        }

        return $this->render('pronostic/edit.html.twig', [
            'pronostic' => $pronostic,
            'form' => $form->createView(),
        ]);
      }
      else  {
        throw new AccessDeniedException('Vous ne pouvez modifier que vos propres pronostics!');
      }
    }

    /**
     * @Route("/{id}", name="pronostic_delete", methods="DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete(Request $request, Pronostic $pronostic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pronostic->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pronostic);
            $em->flush();
        }

        return $this->redirectToRoute('pronostic_index');
    }
}
