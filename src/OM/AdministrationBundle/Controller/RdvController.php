<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Rdv;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;


class RdvController extends FOSRestController
{

    /**
     * @Rest\Post("/api/rdv/{id}", name="Rdv")
     * @param Request $request
     * @return Response
     */

    public function postRdvAction(Request $request, $id)
    {


        $rdv = new Rdv();
        $type = $request->get('type');
        $daterdv =  new \DateTime($request->get('daterdv'));

        $rdv->setType($type);
        $rdv->setDaterdv($daterdv);

        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $view =new View("Rdv Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/rdv", name="_allrdv")
     *
     */
    public function getSourceAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Rdv')->findAll();
        if ($restresult === null) {
            return new View("Pas de rdv disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [

                'type' => $result->getType(),
                'daterdv' => $result->getDaterdv(),

            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/rdv")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateRdvAction($id,Request $request)
    {
        $type = $request->get('type');
        $daterdv = new \DateTime($request->get('daterdv'));
        $em = $this->getDoctrine()->getManager();
        $rdv = $this->getDoctrine()->getRepository('OMAdministrationBundle:Rdv')->find($id);
        if (empty($rdv)) {
            $view = new View("rdv not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($type) && !empty($daterdv)){
            $rdv->setDaterdv($daterdv);
            $rdv->setType($type);
            $em->flush();
            $view =new View("rdv Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("type or date rendez-vous cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/rdv")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new Rdv();
        $em = $this->getDoctrine()->getManager();
        $rdv = $this->getDoctrine()->getRepository('OMAdministrationBundle:Rdv')->find($id);
        if (empty($rdv)) {
            $view = new View("rdv not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($rdv);
            $em->flush();
        }
        $view = new View("rdv deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("api/rdv/{id}")
     * @param $id
     * @return View|object|Rdv
     */
    public function getRdvByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Rdv')->find($id);
        if ($singleresult === null) {
            return new View("rdv not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }


}
