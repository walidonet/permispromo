<?php

namespace OM\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends FOSRestController
{
    public function indexAction()
    {
        return $this->render('OMAdministrationBundle:Default:index.html.twig');
    }
    /**
     * @Rest\Get("/dk")
     * @param Request $request
     * @return mixed
     */
    public function getDemosAction()
    {
        var_dump($this->getUser());die();
    }
    /**
     * @Rest\Get("/user")
     * @param Request $request
     * @return mixed
     */
    public function getUserAction()
    {


    }



}
