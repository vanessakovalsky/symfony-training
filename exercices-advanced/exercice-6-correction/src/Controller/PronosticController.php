<?php

namespace App\Controller;

use App\Event\LogEvent;
use App\Entity\Pronostic;
use App\Form\PronosticType;
use App\Service\MailManager;
use Psr\Log\LoggerInterface;
use App\EventListener\LogListener;
use App\Repository\PronosticRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/pronostic")
 */
class PronosticController extends AbstractController
{

  private $logger;
  private $cache;

  public function __construct(LoggerInterface $logger){
    $this->logger = $logger;
    $this->cache = new FilesystemAdapter();

  }
    /**
     * @Route("/", name="pronostic_index", methods="GET")
     */
    public function index(PronosticRepository $pronosticRepository): Response
    {
      // get data from cache :
      $pronostics_cache = $this->cache->getItem('pronostics.list');
      if(!$pronostics_cache->isHit()){
        $pronostics = $pronosticRepository->findAll();
        $pronostics_cache->set($pronostics);
        $this->cache->save($pronostics_cache);
      }

      return $this->render('pronostic/index.html.twig', ['pronostics' => $pronostics_cache->get() ]);
    }

    /**
     * @Route("/new", name="pronostic_new", methods="GET|POST")
     */
    public function new(Request $request, MailManager $mailManager): Response
    {
        $pronostic = new Pronostic();
        $form = $this->createForm(PronosticType::class, $pronostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pronostic);
            $em->flush();
            $mailManager->sendEmail('v.david@kovalibre.com','no-reply@babyfootgame.com','Pronostic ajouté','Un pronostic a été ajouté');
            $message = 'Message dans les logs';
            $logEvent = new LogEvent($message);
            $listener = new LogListener($this->logger);
            $dispatcher->addListener( LogEvent::NAME, array($listener, 'onAppLogevent'));
            $dispatcher->dispatch($logEvent, LogEvent::NAME);
            $this->cache->deleteItem('pronostics.list');

            return $this->redirectToRoute('pronostic_index');
        }

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
     */
    public function edit(Request $request, Pronostic $pronostic): Response
    {
      if($this->getUser()->getId() == $pronostic->getIdUser()->getId())
      {
        $form = $this->createForm(PronosticType::class, $pronostic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->cache->deleteItem('pronostics.list');
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
