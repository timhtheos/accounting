<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BanksController extends Controller
{
  /**
   * @Route("/banks", name="banks")
   */
  public function indexAction()
  {
    $banks = $this->getDoctrine()
      ->getRepository('AppBundle:Banks')
      ->findAll();

    return $this->render('banks/index.html.twig', array(
      'banks' => $banks
    ));
  }
}
