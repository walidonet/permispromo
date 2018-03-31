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
     * @Rest\Post("/api/pmodality/{id}", name="pmodality")
     * @param Request $request
     * @return Response
     */

    public function postPmodalityAction(Request $request, $id)
    {


        $data = new PaymentModality();
        $libele = $request->get('libele');

        $data->setLibele($libele);

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

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/pmodality")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updatePmodalityAction($id,Request $request)
    {
        $data = new PaymentModality();
        $libele = $request->get('libele');
        $em = $this->getDoctrine()->getManager();
        $pmodality = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($id);
        if (empty($pmodality)) {
            $view = new View("payement modality not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($libele) ){
            $pmodality->setLibele($libele);
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



}
