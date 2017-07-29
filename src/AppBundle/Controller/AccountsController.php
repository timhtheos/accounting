<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Accounts;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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

  /**
   * @Route("/account/add", name="account_add")
   */
  public function addAction(Request $request)
  {
    $account = new Accounts;

    $params = array('attr' => array(
      'class' => 'form-control',
      'style' => 'margin-bottom: 15px;'
    ));

    $params_submit = $params;
    $params_submit['label'] = 'Add account';
    $params_submit['attr']['class'] = 'btn btn-primary';

    $form = $this->createFormBuilder($account)
      ->add('name', TextType::class, $params)
      ->add('bank', TextType::class, $params)
      ->add('type', TextType::class, $params)
      ->add('currency', TextType::class, $params)
      ->add('weight', TextType::class, $params)
      ->add('save', SubmitType::class, $params_submit)
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      // Get data.
      $name = $form['name']->getData();
      $bank = $form['bank']->getData();
      $type = $form['type']->getData();
      $currency = $form['currency']->getData();
      $weight = $form['weight']->getData();
      $currency = $form['currency']->getData();

      $now = new\DateTime('now');

      $account->setName($name);
      $account->setBank($bank);
      $account->setType($type);
      $account->setCurrency($currency);
      $account->setWeight($weight);
      $account->setDateAdded($now);

      $em = $this->getDoctrine()->getManager();

      $em->persist($account);
      $em->flush();

      $this->addFlash(
        'notice',
        'Account added.'
      );

      return $this->redirectToRoute('accounts');
    }

    return $this->render('accounts/add.html.twig', array(
      'form' => $form->createView()
    ));
  }
}
