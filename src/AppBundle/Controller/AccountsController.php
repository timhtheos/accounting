<?php

namespace AppBundle\Controller;

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
    return $this->render('accounts/index.html.twig');
  }
}
