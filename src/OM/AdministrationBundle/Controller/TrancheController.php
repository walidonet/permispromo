<?php

namespace OM\AdministrationBundle\Controller;

use OM\AdministrationBundle\Entity\Tranche;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\PaymentModality;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrancheController extends FOSRestController
{
    /**
     * @Rest\Post("/api/tranche", name="tranche")
     * @param Request $request
     * @return Response
     */

    public function postTrancheAction(Request $request)
    {


        $data = new Tranche();
        $prix= $request->get('prix');
        $pmod = $request->get('paymentmodal');
        $pmodal= $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($pmod);

        $data->setPrix($prix);
        $data->setPaymentmodal($pmodal);
        $data->setWork(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("tranche Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/tranche", name="_alltranche")
     *
     */
    public function getPmodalityAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tranche')->findAll();
        if ($restresult === null) {
            return new View("Pas de payement modality disponible", Response::HTTP_NOT_FOUND);
        }


        return $restresult;
    }

    /**
     * @Rest\Put("api/{id}/tranche")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updatePmodalityAction($id,Request $request)
    {
        $id= $request->get('id');
        $tranche= $this->getDoctrine()->getRepository('OMAdministrationBundle:Tranche')->find($id);
        $prix= $request->get('prix');
        $work = $request->get('work');
        $em = $this->getDoctrine()->getManager();
        if (empty($tranche)) {
            $view = new View("tranche not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($tranche) ){
            $tranche->setPrix($prix);
            if($work=='true'){
                $tranche->setWork(true);
            }
            else{
                $tranche->setWork(false);
            }
            $em->flush();
            $view =new View("tranche Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Libele cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }



    /**
     * @Rest\Get("/api/trancheactive")
     *
     */
    public function getPmodalityactiveAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->findAll();
        if ($restresult === null) {
            return new View("Pas de modalité de paiement disponible", Response::HTTP_NOT_FOUND);
        }
        //var_dump($restresult);die();
        $formatted = array();
        foreach ($restresult as $result) {
            if($result->getWork()) {
                array_push($formatted,$result);
            }
        }

        return $formatted;
    }





}
