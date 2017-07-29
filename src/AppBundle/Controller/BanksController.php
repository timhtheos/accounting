<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    $params_weight = $params;
    $params_weight['choices'] = array(
      0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
      21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38,
      39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50
    );

    $params_submit = $params;
    $params_submit['label'] = 'Add bank';
    $params_submit['attr']['class'] = 'btn btn-primary pull-right';

    $form = $this->createFormBuilder($bank)
      ->add('name', TextType::class, $params)
      ->add('weight', ChoiceType::class, $params_weight)
      ->add('alias', TextType::class, $params)
      ->add('save', SubmitType::class, $params_submit)
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      // Get data.
      $name = $form['name']->getData();
      $weight = $form['weight']->getData();
      $alias = $form['alias']->getData();

      $now = new\DateTime('now');

      $bank->setName($name);
      $bank->setWeight($weight);
      $bank->setAlias($alias);
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

  /**
   * @Route("/bank/details/{id}", name="bank_details")
   */
  public function detailsAction($id)
  {
    $bank = $this->getDoctrine()
      ->getRepository('AppBundle:Banks')
      ->find($id);

    return $this->render('banks/details.html.twig', array(
      'bank' => $bank
    ));
  }

  /**
   * @Route("/bank/delete/{id}", name="bank_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $bank = $em->getRepository('AppBundle:Banks')->find($id);

    $em->remove($bank);
    $em->flush();

    $this->addFlash(
      'notice',
      'Bank removed.'
    );

    return $this->redirectToRoute('banks');
  }
}
