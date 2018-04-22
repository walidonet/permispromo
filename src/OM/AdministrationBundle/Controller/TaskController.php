<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use OM\AdministrationBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends FOSRestController
{
    /**
     * @Rest\Post("/api/sticky", name="sticky")
     * @param Request $request
     * @return Response
     */

    public function postStikyAction(Request $request)
    {

        $data = new Task();
        $note = $request->get('note');
        $agent = $request->get('agent');
        $restresult = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($agent);


        $data->setNotes($note);
        $data->setAgent($restresult);


        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("sticky note created Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }
}
