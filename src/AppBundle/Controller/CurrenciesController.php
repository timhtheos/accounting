<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Currencies;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CurrenciesController extends Controller
{
  /**
   * @Route("/currencies", name="currencies")
   */
  public function indexAction()
  {
    $currencies = $this->getDoctrine()
      ->getRepository('AppBundle:Currencies')
      ->findAll();

    return $this->render('currencies/index.html.twig', array(
      'currencies' => $currencies
    ));
  }

  /**
   * @Route("/currency/add", name="currency_add")
   */
  public function addAction(Request $request)
  {
    $currency = new Currencies;

    $params = array('attr' => array(
      'class' => 'form-control',
      'style' => 'margin-bottom: 15px;'
    ));

    $params_weight = $params;
    $params_weight['label'] = 'Weight (optional)';
    $params_weight['choices'] = array(
      0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
      21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38,
      39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50
    );

    $params_submit = $params;
    $params_submit['label'] = 'Add currency';
    $params_submit['attr']['class'] = 'btn btn-primary pull-right';

    $form = $this->createFormBuilder($currency)
      ->add('name', TextType::class, $params)
      ->add('alias', TextType::class, $params)
      ->add('weight', ChoiceType::class, $params_weight)
      ->add('save', SubmitType::class, $params_submit)
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      // Get data.
      $name = $form['name']->getData();
      $weight = $form['weight']->getData();
      $alias = $form['alias']->getData();

      $now = new\DateTime('now');

      $currency->setName($name);
      $currency->setWeight($weight);
      $currency->setAlias($alias);
      $currency->setDateAdded($now);

      $em = $this->getDoctrine()->getManager();

      $em->persist($currency);
      $em->flush();

      $this->addFlash(
        'notice',
        'Currency `' . $name . '`has been added.'
      );

      return $this->redirectToRoute('currencies');
    }

    return $this->render('currencies/add.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/currency/details/{id}", name="currency_details")
   */
  public function detailsAction($id)
  {
    $currency = $this->getDoctrine()
      ->getRepository('AppBundle:Currencies')
      ->find($id);

    return $this->render('currencies/details.html.twig', array(
      'currency' => $currency
    ));
  }

  /**
   * @Route("/currency/delete/{id}", name="currency_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $currency = $em->getRepository('AppBundle:Currencies')->find($id);

    $em->remove($currency);
    $em->flush();

    $this->addFlash(
      'notice',
      'Currency `' . $currency->getName() . '` has been removed.'
    );

    return $this->redirectToRoute('currencies');
  }

  /**
   * @Route("/currency/edit/{id}", name="currency_edit")
   */
  public function editAction($id, Request $request)
  {
    $currency = $this->getDoctrine()
      ->getRepository('AppBundle:Currencies')
      ->find($id);

    $params = array('attr' => array(
      'class' => 'form-control',
      'style' => 'margin-bottom: 15px;'
    ));

    $params_weight = $params;
    $params_weight['label'] = 'Weight (optional)';
    $params_weight['choices'] = array(
      0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
      21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38,
      39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50
    );

    $params_submit = $params;
    $params_submit['label'] = 'Update currency';
    $params_submit['attr']['class'] = 'btn btn-primary pull-right';

    $form = $this->createFormBuilder($currency)
      ->add('name', TextType::class, $params)
      ->add('alias', TextType::class, $params)
      ->add('weight', ChoiceType::class, $params_weight)
      ->add('save', SubmitType::class, $params_submit)
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      // Get data.
      $name = $form['name']->getData();
      $weight = $form['weight']->getData();
      $alias = $form['alias']->getData();

      $em = $this->getDoctrine()->getManager();
      $currency = $em->getRepository('AppBundle:Currencies')->find($id);

      $currency->setName($name);
      $currency->setWeight($weight);
      $currency->setAlias($alias);
      $currency->setDateAdded($currency->getDateAdded());

      $em->flush();

      $this->addFlash(
        'notice',
        'Currency `' . $name . '`has been updated.'
      );

      return $this->redirectToRoute('currencies');
    }

    return $this->render('currencies/edit.html.twig', array(
      'currency' => $currency,
      'form' => $form->createView()
    ));
  }
}
