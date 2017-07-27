<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accounts;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountsController extends Controller
{
  /**
   * @Route("/accounts", name="accounts")
   */
  public function indexAction()
  {
    $accounts = $this->getDoctrine()
      ->getRepository('AppBundle:Accounts')
      ->findAll();

    return $this->render('accounts/index.html.twig', array(
      'accounts' => $accounts
    ));
  }
}
