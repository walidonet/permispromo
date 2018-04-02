<?php

namespace OM\AdministrationBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Offre;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OffreController extends FOSRestController
{
    /**
     * @Rest\Post("/api/offre", name="offre")
     * @param Request $request
     * @return Response
     */

    public function postOffreAction(Request $request)
    {

        $data = new Offre();
        $libele = $request->get('libele');
        $prix = $request->get('prix');
        $work = $request->get('work');


        $data->setLibele($libele);
        $data->setPrix($prix);
        if($work=="true"){
            $data->setWork(true);
        }else{
            $data->setWork(false);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("Offre Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/offre", name="_alloffres")
     *
     */
    public function getOffreAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->findAll();
        if ($restresult === null) {
            return new View("Pas d offre disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [
                'id'=>$result->getId(),
                'libele' => $result->getLibele(),
                'prix' => $result->getPrix(),
                'work' => $result->getWork(),

            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/offre")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateAction($id,Request $request)
    {
        $data = new Offre();
        $libele = $request->get('libele');
        $prix = $request->get('prix');
        $work= $request->get('work');
        $em = $this->getDoctrine()->getManager();
        $offre = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->find($id);
        if (empty($offre)) {
            $view = new View("Offre not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($offre) ){
            $offre->setLibele($libele);
            $offre->setColor($prix);
            if($work=="true")
                $offre->setWork(true);
            else
                $offre->setWork(false);

            $em->flush();
            $view =new View("Offre Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Offre cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Get("/api/offreactive")
     *
     */
    public function getOffreactiveAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->findAll();
        if ($restresult === null) {
            return new View("Pas d offre disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            if($result->getWork()) {
                $formatted[] = [
                    'id'=>$result->getId(),
                    'libele' => $result->getLibele(),
                    'prix' => $result->getPrix(),
                    'work' => $result->getWork(),

                ];
            }
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/offreonoff")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function onoffAction($id,Request $request)
    {
        $data = new Offre();
        $em = $this->getDoctrine()->getManager();
        $offre = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->find($id);
        if (empty($offre)) {
            $view = new View("Offre not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($offre) ){
            if($offre->getWork())
                $offre->setWork(false);
            else
                $offre->setWork(true);
            $em->flush();
            $view =new View("Offre Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Offre cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/offre")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new Offre();
        $em = $this->getDoctrine()->getManager();
        $offre = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->find($id);
        if (empty($offre)) {
            $view = new View("offre not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($offre);
            $em->flush();
        }
        $view = new View("offre deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("api/offre/{id}")
     * @param $id
     * @return View|object|Offre
     */
    public function getOffreByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->find($id);
        if ($singleresult === null) {
            return new View("offre not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

}
