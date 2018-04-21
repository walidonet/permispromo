<?php

namespace OM\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Offre;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GouverneraController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/api/gov", name="_allgov")
     *
     */
    public function getOffreAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Gouvernera')->findAll();
        if ($restresult === null) {
            return new View("Pas d city disponible", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}
