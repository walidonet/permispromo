<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\PaymentModality;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PmodalityController extends FOSRestController
{

    /**
     * @Rest\Post("/api/pmodality", name="pmodality")
     * @param Request $request
     * @return Response
     */

    public function postPmodalityAction(Request $request)
    {


        $data = new PaymentModality();
        $libele = $request->get('libele');

        $data->setLibele($libele);
        $data->setWork(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("payement modality Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/pmodality", name="_allpayementmodality")
     *
     */
    public function getPmodalityAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->findAll();
        if ($restresult === null) {
            return new View("Pas de payement modality disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [

                'libele' => $result->getLibele(),

            ];
        }

        return $restresult;
    }

    /**
     * @Rest\Put("api/{id}/pmodality", name ="_upmoda")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updatePmodalityAction($id,Request $request)
    {
        $data = new PaymentModality();
        $libele = $request->get('libele');
        $work = $request->get('work');
        $em = $this->getDoctrine()->getManager();
        $pmodality = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($id);
        if (empty($pmodality)) {
            $view = new View("payement modality not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($libele) ){
            $pmodality->setLibele($libele);
            if($work=='true'){
                $pmodality->setWork(true);
            }
            else{
                $pmodality->setWork(false);
            }
            $em->flush();
            $view =new View("payement modality Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Libele cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/pmodality")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new PaymentModality();
        $em = $this->getDoctrine()->getManager();
        $pmodality = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($id);
        if (empty($pmodality)) {
            $view = new View("payement modality not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($pmodality);
            $em->flush();
        }
        $view = new View("Payement modality deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/pmodalityactive")
     *
     */
    public function getPmodalityactiveAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->findAll();
        if ($restresult === null) {
            return new View("Pas de modalité de paiement disponible", Response::HTTP_NOT_FOUND);
        }
        //var_dump($restresult);die();
        $formatted = [];
        foreach ($restresult as $result) {
            if($result->getWork()) {
                $formatted[] = [
                    'id' => $result->getId(),
                    'libele' => $result->getLibele(),


                ];
            }
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/pmodalityonoff")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function onoffAction($id,Request $request)
    {
        $data = new PaymentModality();
        $em = $this->getDoctrine()->getManager();
        $pmodality = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($id);
        if (empty($pmodality)) {
            $view = new View("payment modality not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($pmodality) ){
            if($pmodality->getWork())
                $pmodality->setWork(false);
            else
                $pmodality->setWork(true);
            $em->flush();
            $view =new View("payment modality Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("payment modality cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Get("api/pmodality/{id}")
     * @param $id
     * @return View|object|PaymentModality
     */
    public function getPmodalityByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($id);
        if ($singleresult === null) {
            return new View("Payement modality not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("api/modalityon")
     * @return View|object|PaymentModality
     */
    public function getOnModalityByIdAction()
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->findBy(array('work'=> true));
        if ($singleresult === null) {
            return new View("modality not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }



}
