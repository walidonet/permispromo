<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 27/03/2018
 * Time: 14:36
 */

namespace OM\LocalisationBundle\Controller;

use FOS\RestBundle\View\View;
use OM\LocalisationBundle\Entity\Circuit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;



class CircuitController extends Controller
{

    /**
     * @Rest\Post("/circuit", name="_circuit")
     * @param Request $request
     * @return View
     */

    public function postAction(Request $request)
    {
        //var_dump($request->get('username'));die();

        $circuit = new Circuit();
        $longitude = $request->get('longitude');
        $latitude = $request->get('latitude');


        $circuit->setLongitude($longitude);
        $circuit->setLatitude($latitude);


        //var_dump($data);die();
        $em = $this->getDoctrine()->getManager();
        $em->persist($circuit);
        $em->flush();
        $view = new View("Circuit Added Successfully", Response::HTTP_OK);

        return $view;
    }

    /**
     * @Rest\Get("/circuit", name="_allcircuits")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMLocalisationBundle:Circuit')->findAll();
        if ($restresult === null) {
            return new View("there are no circuits exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;

    }


}