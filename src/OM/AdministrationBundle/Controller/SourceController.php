<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Source;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SourceController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Rest\Post("/api/source/{id}", name="source")
     * @param Request $request
     * @return Response
     */

    public function postTagAction(Request $request, $id)
    {


        $data = new Source();
        $libele = $request->get('libele');
        $prospect = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($id);




        $data->setLibele($libele);
        $data->setProspect($prospect);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("Source Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }
}
