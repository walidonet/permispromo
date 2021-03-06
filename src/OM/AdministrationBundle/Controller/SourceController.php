<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Source;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SourceController extends FOSRestController
{


    /**
     * @Rest\Post("/api/source", name="source")
     * @param Request $request
     * @return Response
     */

    public function postTagAction(Request $request)
    {


        $data = new Source();
        $libele = $request->get('libele');

        $data->setLibele($libele);
        $data->setWork(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("Source Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }



    /**
     * @Rest\Get("/api/source", name="_allsources")
     *
     */
    public function getSourceAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Source')->findAll();
        if ($restresult === null) {
            return new View("Pas de source disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        /*foreach ($restresult as $result) {
            $formatted[] = [

                'libele' => $result->getLibele(),

            ];
        }

        return new JsonResponse($formatted);*/
        return $restresult;
    }

    /**
     * @Rest\Put("api/{id}/source")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateSourceAction($id,Request $request)
    {
        $data = new Source();
        $libele = $request->get('libele');
        $work = $request->get('work');
        if($work == "true"){
            $working = true;
        }
        else{
            $working = false;
        }
        $em = $this->getDoctrine()->getManager();
        $source = $this->getDoctrine()->getRepository('OMAdministrationBundle:Source')->find($id);
        if (empty($source)) {
            $view = new View("Source not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($libele) ){
            $source->setLibele($libele);
            $source->setWork($working);
            $em->flush();
            $view =new View("source Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Libele cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/source")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new Source();
        $em = $this->getDoctrine()->getManager();
        $source = $this->getDoctrine()->getRepository('OMAdministrationBundle:Source')->find($id);
        if (empty($source)) {
            $view = new View("source not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($source);
            $em->flush();
        }
        $view = new View("Source deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/sourceactive")
     *
     */
    public function getSourceactiveAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Source')->findAll();
        if ($restresult === null) {
            return new View("Pas de source activé disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            if($result->getWork()) {
                $formatted[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),
                    'work' => $result->getWork(),

                ];
            }
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/sourceonoff")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function onoffAction($id,Request $request)
    {
        $data = new Source();
        $em = $this->getDoctrine()->getManager();
        $source = $this->getDoctrine()->getRepository('OMAdministrationBundle:Source')->find($id);
        if (empty($source)) {
            $view = new View("Source not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($source) ){
            if($source->getWork())
                $source->setWork(false);
            else
                $source->setWork(true);
            $em->flush();
            $view =new View("Source Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("source cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }




    /**
     * @Rest\Get("api/source/{id}")
     * @param $id
     * @return View|object|Source
     */
    public function getSourceByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Source')->find($id);
        if ($singleresult === null) {
            return new View("source not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

}
