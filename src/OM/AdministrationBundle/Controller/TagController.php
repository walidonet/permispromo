<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 19/02/2018
 * Time: 15:44
 */

namespace OM\AdministrationBundle\Controller;

use OM\AdministrationBundle\Entity\Tag;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class TagController extends FOSRestController
{

    //ajout d'un tag
    /**
     * @Rest\Post("/api/tag", name="tag")
     * @param Request $request
     * @return Response
     */

    public function postTagAction(Request $request)
    {

        $data = new Tag();
        $nom = $request->get('nom');
        $color = $request->get('color');
        $work = $request->get('work');


        $data->setNom($nom);
        $data->setColor($color);
        if($work=="true"){
            $data->setWork(true);
        }else{
            $data->setWork(false);
        }

        //var_dump($data);die();
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("Tag Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }



    // Liste des tags

    /**
     * @Rest\Get("/api/tag", name="_alltags")
     *
     */
    public function getTagAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tag')->findAll();
        if ($restresult === null) {
            return new View("Pas de tag disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [
                'id'=>$result->getId(),
                'nom' => $result->getNom(),
                'color' => $result->getColor(),
                'work' => $result->getWork(),

            ];
        }

        return new JsonResponse($formatted);
    }
    /**
     * @Rest\Get("/api/tagactive", name="_alltags")
     *
     */
    public function getTagactiveAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tag')->findAll();
        if ($restresult === null) {
            return new View("Pas de tag disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            if($result->getWork()) {
                $formatted[] = [
                    'id' => $result->getId(),
                    'nom' => $result->getNom(),
                    'color' => $result->getColor(),
                    'work' => $result->getWork(),

                ];
            }
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/tag")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateAction($id,Request $request)
    {
        $data = new Tag();
        $name = $request->get('nom');
        $color = $request->get('color');
        $work= $request->get('work');
        $em = $this->getDoctrine()->getManager();
        $tag = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tag')->find($id);
        if (empty($tag)) {
            $view = new View("Tag not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($tag) ){
            $tag->setNom($name);
            $tag->setColor($color);
            if($work=="true")
            $tag->setWork(true);
            else
                $tag->setWork(false);

            $em->flush();
            $view =new View("Tag Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
        $view = new View("Name cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

         return $this->handleView($view);
        }
    }
    /**
     * @Rest\Put("api/{id}/tagonoff")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function onoffAction($id,Request $request)
    {
        $data = new Tag();
        $em = $this->getDoctrine()->getManager();
        $tag = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tag')->find($id);
        if (empty($tag)) {
            $view = new View("Tag not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($tag) ){
            if($tag->getWork())
            $tag->setWork(false);
            else
            $tag->setWork(true);
            $em->flush();
            $view =new View("Tag Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("Name cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }

    /**
     * @Rest\Delete("api/{id}/tag")
     * @param $id
     * @return Response
     */
    public function deleteAction($id)
    {
        $data = new Tag();
        $em = $this->getDoctrine()->getManager();
        $tag = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tag')->find($id);
        if (empty($tag)) {
            $view = new View("tag not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $em->remove($tag);
            $em->flush();
        }
        $view = new View("deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * @Rest\Get("api/tag/{id}")
     * @param $id
     * @return View|object|Tag
     */
    public function getTagByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Tag')->find($id);
        if ($singleresult === null) {
            return new View("tag not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }


}