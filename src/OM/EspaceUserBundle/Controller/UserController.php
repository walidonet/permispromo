<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 20/02/2018
 * Time: 12:01
 */

namespace OM\EspaceUserBundle\Controller;
use FOS\RestBundle\View\View;
use OM\EspaceUserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{



//---------------------------------- Affectation d'un client à un moniteur -------------------------------------------- //

    /**
     * @Rest\Put("/api/{id}/affect")
     * @param $id
     * @param Request $request
     * @return View
     */
    public function AffectAction($id,Request $request)
    {
        $data = new User();
        $moniteur_id = $request->get('monitor');
        $moniteur = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($moniteur_id);

        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($moniteur) ){
            $user->setMonitor($moniteur);
            $sn->flush();
            return new View("Affectation effectuée avec succès", Response::HTTP_OK);
        }

        else return new View("Aucun agent choisi", Response::HTTP_NOT_ACCEPTABLE);
    }


}