<?php

namespace OM\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Meeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/api/meeting", name="offre")
     * @param Request $request
     * @return Response
     */
    public function postMeetingAction(Request $request)
    {

        $data = new Meeting();
        $day = $request->get('day');
        $star = $request->get('star');
        $end = $request->get('end');
        $client = $request->get('client');
        $apprenti = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')
            ->find($client);
        $data->setDay($day);
        $data->setStar($star);
        $data->setEnd($end);
        $data->setClient($apprenti);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("Meeting Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/api/meeting", name="_alloffres")
     *
     */
    public function getMeetingAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Meeting')->findAll();
        if ($restresult === null) {
            return new View("Pas d offre disponible", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    /**
     * @Rest\Put("api/{id}/meeting")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $data = $this->getDoctrine()->getRepository('OMAdministrationBundle:Meeting')->find($id);
        $day = $request->get('day');
        $star = $request->get('star');
        $end = $request->get('end');
        $client = $request->get('client');
        $apprenti = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')
            ->find($client);

        /**/

        if (empty($data)) {
            $view = new View("Meeting not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($data) ){
            $data->setDay($day);
            $data->setStar($star);
            $data->setEnd($end);
            $data->setClient($apprenti);
            $em->flush();
            $view =new View("Meeting Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Meeting cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }
    /**
     * @Rest\Delete("api/{id}/meeting")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $meeting = $this->getDoctrine()->getRepository('OMAdministrationBundle:Meeting')->find($id);
        if (empty($meeting)) {
            $view = new View("meeting not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($meeting);
            $em->flush();
        }
        $view = new View("meeting deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/api/meeting/{id}", name="_all")
     *
     */
    public function getMeetingbyclientAction(Request $request ){

        $id = $request->get('id');
        $apprenti = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')
            ->find($id);
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Meeting')
            ->findby(array('client'=> $apprenti));
        if ($restresult === null) {
            return new View("Pas d offre disponible", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}
