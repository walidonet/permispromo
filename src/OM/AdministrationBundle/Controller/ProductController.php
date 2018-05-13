<?php

namespace OM\AdministrationBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Rest\Get("/api/product", name="_allproducts")
     *
     */
    public function getProductAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')->findAll();
        if ($restresult === null) {
            return new View("Pas de produits disponibles", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [

                'libelle' => $result->getLibelle(),
                'work'=> $result->getWork(),
                'mode' => $result->getMode(),
                'modality'=> $result->getModality(),
                'offre'=> $result->getOffre(),
                'contract'=> $result->getContract(),

            ];
        }

        return $restresult;
        //return new JsonResponse($formatted);
    }


    /**
     * @Rest\Post("/api/product", name="product")
     * @param Request $request
     * @return Response
     */

    public function postProductAction(Request $request)
    {

        $data = new Product();
        $libelle = $request->get('libelle');
        $work = $request->get('work');
        $idmode = $request->get('mode');
        $idmodality = $request->get('modality');
        $idoffre = $request->get('offre');
        $idcontract = $request->get('contract');

        $em= $this->getDoctrine()->getManager();

        $mode = $em->getRepository('OMAdministrationBundle:PaymentMode')->find($idmode);
        $modality = $em->getRepository('OMAdministrationBundle:PaymentModality')->find($idmodality);
        $offre = $em->getRepository('OMAdministrationBundle:Offre')->find($idoffre);
        $contract = $em->getRepository('OMAdministrationBundle:Contract')->find($idcontract);




        $data->setLibelle($libelle);
        if($work=="true"){
            $data->setWork(true);
        }else{
            $data->setWork(false);
        }
        $data->setMode($mode);
        $data->setModality($modality);
        $data->setOffre($offre);
        $data->setContract($contract);

        $em->persist($data);
        $em->flush();
        $view =new View("product Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }


    /**
     * @Rest\Put("api/{id}/product")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateAction($id,Request $request)
    {
        $data = new Product();
        $libelle = $request->get('libelle');
        $work = $request->get('work');
        $mode = $request->get('mode');
        $modality = $request->get('modality');
        $offre = $request->get('offre');
        $contract = $request->get('contract');


        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')->find($id);
        $modee = $this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentMode')->find($mode);
        $offree = $this->getDoctrine()->getRepository('OMAdministrationBundle:Offre')->find($offre);
        $modalitye =$this->getDoctrine()->getRepository('OMAdministrationBundle:PaymentModality')->find($modality);
        $contracte = $this->getDoctrine()->getRepository('OMAdministrationBundle:Contract')->find($contract);
        if (empty($product)) {
            $view = new View("Product not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($product) ){
            $data->setLibelle($libelle);
            if($work=="true"){
                $data->setWork(true);
            }else{
                $data->setWork(false);
            }
            $data->setMode($modee);
            $data->setModality($modalitye);
            $data->setOffre($offree);
            $data->setContract($contracte);
            $em->persist($data);
            $em->flush();
            $view =new View("Product Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Product cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Put("api/{id}/productonoff")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function onoffProductAction($id,Request $request)
    {
        $data = new Product();
        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')->find($id);
        if (empty($product)) {
            $view = new View("Product not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        } elseif (!empty($product)) {
            if ($product->getWork())
                $product->setWork(false);
            else
                $product->setWork(true);
            $em->flush();
            $view = new View("Product Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        } else {
            $view = new View("Product cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }


        /**
         * @Rest\Delete("api/{id}/product")
         * @param $id
         * @return Response
         */
        public function deleteAction($id)
    {
        $data = new Product();
        $em = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')->find($id);
        if (empty($product)) {
            $view = new View("product not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($product);
            $em->flush();
        }
        $view = new View("product deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("api/product/{id}")
     * @param $id
     * @return View|object|Product
     */
    public function getProductByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')->find($id);
        if ($singleresult === null) {
            return new View("product not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Get("api/producton")
     * @return View|object|Product
     */
    public function getOnProductByIdAction()
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')->findBy(array('work'=> true));
        if ($singleresult === null) {
            return new View("product not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }







}
