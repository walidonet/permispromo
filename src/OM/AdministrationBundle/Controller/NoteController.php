<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Note;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends FOSRestController
{

    /**
     * @Rest\Post("/api/note/{id}", name="note")
     * @param Request $request
     * @return Response
     */

    public function postNoteAction(Request $request, $id)
    {


        $data = new Note();
        $nom = $request->get('nom');
        $prospect = $request->get('prospect');

        $data->setNom($nom);
        $data->setProspect($prospect);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("Note Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/note", name="_allNotes")
     *
     */
    public function getNoteAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Note')->findAll();
        if ($restresult === null) {
            return new View("Pas de note disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [

                'nom' => $result->getNom(),
                'timing' => $result->getTiming(),
                'prospect'=> $result->getProspect(),

            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/note")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateNoteAction($id,Request $request)
    {
        $note = new Note();
        $nom = $request->get('nom');
        $prospect = $request->get('prospect');
        $em = $this->getDoctrine()->getManager();
        $note = $this->getDoctrine()->getRepository('OMAdministrationBundle:Note')->find($id);
        if (empty($note)) {
            $view = new View("note not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($nom) && !empty($prospect)){
            $note->setNom($nom);
            $em->flush();
            $view =new View("note Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("nom cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/note")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new Note();
        $em = $this->getDoctrine()->getManager();
        $note = $this->getDoctrine()->getRepository('OMAdministrationBundle:Note')->find($id);
        if (empty($note)) {
            $view = new View("note not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($note);
            $em->flush();
        }
        $view = new View("Note deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Put("api/{id}/Noteonoff")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function onoffAction($id,Request $request)
    {
        $data = new Note();
        $em = $this->getDoctrine()->getManager();
        $note = $this->getDoctrine()->getRepository('OMAdministrationBundle:Note')->find($id);
        if (empty($note)) {
            $view = new View("Note not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($note) ){
            if($note->getWork())
                $note->setWork(false);
            else
                $note->setWork(true);
            $em->flush();
            $view =new View("Note Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Note cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }




    /**
     * @Rest\Get("api/note/{id}")
     * @param $id
     * @return View|object|Note
     */
    public function getSourceByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Note')->find($id);
        if ($singleresult === null) {
            return new View("note not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }


}
