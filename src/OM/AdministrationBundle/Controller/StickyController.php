<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\StickyNotes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class StickyController extends FOSRestController
{
    /**
     * @Rest\Post("/api/sticky", name="sticky")
     * @param Request $request
     * @return Response
     */

    public function postStikyAction(Request $request)
    {

        $data = new StickyNotes();
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


    /**
     * @Rest\Get("/api/sticky", name="_allStickies")
     *
     */
    public function getStickyAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:StickyNotes')->findAll();
        if ($restresult === null) {
            return new View("Pas de sticky disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [

                'note' => $result->getNotes(),
                'agent' => $result->getAgent(),

            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/sticky")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateStickyAction(Request $request)
    {
        $sticky = new StickyNotes();
        $id = $request->get('id');
        $notes = $request->get('notes');
        //$agent = $request->get('agent');
        $em = $this->getDoctrine()->getManager();
        $sticky = $this->getDoctrine()->getRepository('OMAdministrationBundle:StickyNotes')->find($id);
        if (empty($sticky)) {
            $view = new View("sticky not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($notes) ){
            $sticky->setNotes($notes);
            $em->flush();
            $view =new View("sticky Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("notes cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Get("api/sticky/{id}")
     * @param $id
     * @return View|object|StickyNotes
     */
    public function getSourceByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:StickyNotes')->find($id);
        if ($singleresult === null) {
            return new View("Sticky note not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }
    /**
     * @Rest\Get("api/{id}/sticky")
     * @param Request $request
     * @return Response
     */
    public function getmySnoteAction(Request $request)
    {
        $id  = $request->get('id');
        $agent = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($id);
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:StickyNotes')
            ->findBy(array('agent'=>$agent));
        if ($singleresult === null) {
            return new View("Sticky note not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Delete("api/{id}/sticky")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $id  = $request->get('id');
        $data = new StickyNotes();
        $em = $this->getDoctrine()->getManager();
        $note = $this->getDoctrine()->getRepository('OMAdministrationBundle:StickyNotes')->find($id);
        if (empty($note)) {
            $view = new View("Sticky not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $note->setAgent(null);
            $em->remove($note);
            $em->flush();
        }
        $view = new View("Sticky note deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }




}
