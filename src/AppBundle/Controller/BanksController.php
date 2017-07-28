<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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

  /**
   * @Route("/bank/add", name="bank_add")
   */
  public function addAction(Request $request)
  {
    $bank = new Banks;

    $params = array('attr' => array(
      'class' => 'form-control',
      'style' => 'margin-bottom: 15px;'
    ));

    $params_submit = $params;
    $params_submit['label'] = 'Add bank';
    $params_submit['attr']['class'] = 'btn btn-primary';

    $form = $this->createFormBuilder($bank)
      ->add('name', TextType::class, $params)
      ->add('save', SubmitType::class, $params_submit)
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      // Get data.
      $name = $form['name']->getData();

      $now = new\DateTime('now');

      $bank->setName($name);
      $bank->setDateAdded($now);

      $em = $this->getDoctrine()->getManager();

      $em->persist($bank);
      $em->flush();

      $this->addFlash(
        'notice',
        'Bank added.'
      );

      return $this->redirectToRoute('banks');
    }

    return $this->render('banks/add.html.twig', array(
      'form' => $form->createView()
    ));
  }
}
