<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Contract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/api/contract", name="contract")
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
     * @Rest\Get("/api/contract", name="_allcontract")
     */
    public function getContactAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Contract')->findAll();
        if ($restresult === null) {
            return new View("Pas d contract disponible", Response::HTTP_NOT_FOUND);
        }

        return $restresult;
    }

    /**
     * @Rest\Put("api/{id}/contract")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request)
    {
        $data = new Offre();
        $id = $request->get('id');
        $libele = $request->get('nom');
        $prix = $request->get('value');
        $work= $request->get('work');
        $em = $this->getDoctrine()->getManager();
        $offre = $this->getDoctrine()->getRepository('OMAdministrationBundle:Contract')->find($id);
        if (empty($offre)) {
            $view = new View("Contract not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($offre) ){
            $offre->setNom($libele);
            $offre->setValeur($prix);
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
     * @Rest\Get("api/contract/{id}")
     * @param $id
     * @return View|object|Offre
     */
    public function getOffreByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Contract')->find($id);
        if ($singleresult === null) {
            return new View("offre not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("api/contract")
     * @return View|object|Contract
     */
    public function getOnContractByIdAction()
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Contract')->findBy(array('work'=> true));
        if ($singleresult === null) {
            return new View("contract not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }
}
