<?php

namespace OM\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OM\AdministrationBundle\Entity\Session;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Meeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class SessionController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/api/session")
     * @param Request $request
     * @Rest\View()
     */
    public function addSessionAction(Request $request){
        $data = new Session();
        $nom = $request->get('nom');
        $timing = $request->get('timing');
        $time = strtotime($timing);
        $newformat = date('Y-m-d',$time);
        $a = new \DateTime($newformat);

        $em = $this->getDoctrine()->getManager();
        $data->setNom($nom);
        $data->setTiming($a);
        $data->setWork(true);
        $em->persist($data);
        $em->flush();
        $view =new View("Meeting Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/api/session", name="_allsession")
     *
     */
    public function getSessionAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Session')->findAll();
        if ($restresult === null) {
            return new View("Pas d session disponible", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    /**
     * @Rest\Get("/api/actsession", name="_actsession")
     *
     */
    public function getactiveSessionAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Session')
            ->find(array('work'=>true));
        if ($restresult === null) {
            return new View("Pas d session disponible", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    /**
     * @Rest\Put("/api/{id}/session")
     * @param Request $request
     * @Rest\View()
     */
    public function updateSessionAction(Request $request){
        $id = $request->get('id');
        $data = $this->getDoctrine()->getRepository('OMAdministrationBundle:Session')
            ->find($id);
        $nom = $request->get('nom');
        $timing = $request->get('timing');
        $time = strtotime($timing);
        $newformat = date('Y-m-d',$time);
        $a = new \DateTime($newformat);
        $work = $request->get('work');
        $em = $this->getDoctrine()->getManager();
        if(!empty($data)){
        $data->setNom($nom);
        $data->setTiming($a);
        if($work=='true')
        $data->setWork(true);
        else
            $data->setWork(false);
        $em->persist($data);
        $em->flush();
        $view =new View("session Added Successfully", Response::HTTP_OK);}else{
            $view =new View("no Added Successfully", Response::HTTP_OK);
        }

        return $this->handleView($view);
    }
}
