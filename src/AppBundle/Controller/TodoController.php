<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo")
     */
    public function indexAction()
    {
        return $this->render('todo/index.html.twig');
    }

    /**
     * @Route("/todo/list", name="todo_list")
     */
    public function listAction()
    {
        return $this->render('todo/list.html.twig');
    }

    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction()
    {
        return $this->render('todo/create.html.twig');
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction()
    {
        return $this->render('todo/edit.html.twig');
    }

    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     */
    public function deleteAction()
    {
        return $this->render('todo/delete.html.twig');
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction()
    {
        return $this->render('todo/details.html.twig');
    }
}
