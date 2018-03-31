<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\PaymentMode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PmodeController extends FOSRestController
{

    /**
     * @Rest\Post("/api/pmode/{id}", name="pmode")
     * @param Request $request
     * @return Response
     */

    public function postPmodeAction(Request $request, $id)
    {


        $data = new PaymentMode();
        $libele = $request->get('libele');

        $data->setLibele($libele);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("payement mode Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/pmode", name="_allpmode")
     *
     */
    public function getPmodeAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentMode')->findAll();
        if ($restresult === null) {
            return new View("Pas de payement mode disponible", Response::HTTP_NOT_FOUND);
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
     * @Rest\Put("api/{id}/pmode")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updatePmodeAction($id,Request $request)
    {
        $data = new PaymentMode();
        $libele = $request->get('libele');
        $em = $this->getDoctrine()->getManager();
        $pmode = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentMode')->find($id);
        if (empty($pmode)) {
            $view = new View("payement mode not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($libele) ){
            $pmode->setLibele($libele);
            $em->flush();
            $view =new View("payement mode Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Libele cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/pmode")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new PaymentMode();
        $em = $this->getDoctrine()->getManager();
        $pmode = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentMode')->find($id);
        if (empty($pmodality)) {
            $view = new View("payement mode not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($pmode);
            $em->flush();
        }
        $view = new View("Payement mode deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("api/pmode/{id}")
     * @param $id
     * @return View|object|PaymentMode
     */
    public function getPmodalityByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentMode')->find($id);
        if ($singleresult === null) {
            return new View("Payement mode not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }



}
