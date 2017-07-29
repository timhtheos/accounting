<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AccountTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountTypesController extends Controller
{
  /**
   * @Route("/account-types", name="account_types")
   */
  public function indexAction()
  {
    $account_types = $this->getDoctrine()
      ->getRepository('AppBundle:AccountTypes')
      ->findAll();

    return $this->render('account_types/index.html.twig', array(
      'account_types' => $account_types
    ));
  }

  /**
   * @Route("/account-type/add", name="account_type_add")
   */
  public function addAction(Request $request)
  {
    $account_type = new AccountTypes;

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
    $params_submit['label'] = 'Add account type';
    $params_submit['attr']['class'] = 'btn btn-primary pull-right';

    $form = $this->createFormBuilder($account_type)
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

      $account_type->setName($name);
      $account_type->setWeight($weight);
      $account_type->setAlias($alias);
      $account_type->setDateAdded($now);

      $em = $this->getDoctrine()->getManager();

      $em->persist($account_type);
      $em->flush();

      $this->addFlash(
        'notice',
        'Account type `' . $name . '`has been added.'
      );

      return $this->redirectToRoute('account_types');
    }

    return $this->render('account_types/add.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/account_type/details/{id}", name="account_type_details")
   */
  public function detailsAction($id)
  {
    $account_type = $this->getDoctrine()
      ->getRepository('AppBundle:AccountTypes')
      ->find($id);

    return $this->render('account_types/details.html.twig', array(
      'account_type' => $account_type
    ));
  }

  /**
   * @Route("/account_type/delete/{id}", name="account_type_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $account_type = $em->getRepository('AppBundle:AccountTypes')->find($id);

    $em->remove($account_type);
    $em->flush();

    $this->addFlash(
      'notice',
      'Account type `' . $account_type->getName() . '` has been removed.'
    );

    return $this->redirectToRoute('account_types');
  }

  /**
   * @Route("/account_type/edit/{id}", name="account_type_edit")
   */
  public function editAction($id, Request $request)
  {
    $account_type = $this->getDoctrine()
      ->getRepository('AppBundle:AccountTypes')
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
    $params_submit['label'] = 'Update account type';
    $params_submit['attr']['class'] = 'btn btn-primary pull-right';

    $form = $this->createFormBuilder($account_type)
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
      $account_type = $em->getRepository('AppBundle:AccountTypes')->find($id);

      $account_type->setName($name);
      $account_type->setWeight($weight);
      $account_type->setAlias($alias);
      $account_type->setDateAdded($account_type->getDateAdded());

      $em->flush();

      $this->addFlash(
        'notice',
        'Account type `' . $name . '`has been updated.'
      );

      return $this->redirectToRoute('account_types');
    }

    return $this->render('account_types/edit.html.twig', array(
      'account_type' => $account_type,
      'form' => $form->createView()
    ));
  }
}
