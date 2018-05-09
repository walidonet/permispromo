<?php

namespace OM\LocalisationBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Meeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FollowController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/api/follow", name="_allfollow")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMLocalisationBundle:Follow')->findAll();
        if ($restresult === null) {
            return new View("there are no follow exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;

    }
    /**
     * @Rest\Get("/api/followbymeeting/{id}", name="_followbymeeting")
     */
    public function getfolowbymeetingAction(Request $request)
    {   $id =$request->get('id');
        $meeting = $this->getDoctrine()->getRepository('OMAdministrationBundle:Meeting')
            ->find($id);
        $restresult = $this->getDoctrine()->getRepository('OMLocalisationBundle:Follow')
            ->findBymeeting($meeting);
        if ($restresult === null) {
            return new View("there are no follow exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;

    }
    /**
     * @Rest\Get("/tt", name="_allfollow")
     */
    public function gettAction()
    {
        for($c=0;$c<20000000;$c++){
            //var_dump($c);
        }

       var_dump('kmél');die();

    }
}
