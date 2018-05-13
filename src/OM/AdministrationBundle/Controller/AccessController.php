<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\EspaceUserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AccessController extends FOSRestController
{

    /**
     * @Rest\Get("api/utilisateur/{id}")
     * @param $id
     * @return View|object|User
     */
    public function getutilisateurByIdAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($id);
        if ($singleresult === null) {
            return new View("product not found", Response::HTTP_NOT_FOUND);
        }

        $role =$singleresult->getRoles();

        $role2 = array("ROLE_worker", "ROLE_USER");

        dump($role);die();
        return $singleresult;
    }


    /**
     * @Rest\Put("api/turnoff")
     */
    public function turnUsersOffAction(Request $request)
    {
        $data = new User();
        $users = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->findAll();
        if (empty($users)) {
            return new View("users not found", Response::HTTP_NOT_FOUND);
        }
        else{

            foreach ($users as $user){

                if (($user->getRoles() == array("ROLE_WORKER", "ROLE_USER")) || ($user->getRoles() == array("ROLE_SUPERVISOR","ROLE_USER")) ) {
                    $user->setEnabled(false);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $view =new View("User turned off Successfully", Response::HTTP_OK);

                }

            }
            return $this->handleView($view);

        }

    }

    /**
     * @Rest\Put("api/turnon")
     */
    public function turnUsersOnAction(Request $request)
    {
        $data = new User();
        $users = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->findAll();
        if (empty($users)) {
            return new View("users not found", Response::HTTP_NOT_FOUND);
        }
        else{

            foreach ($users as $user){

                if (($user->getRoles() == array("ROLE_WORKER", "ROLE_USER")) || ($user->getRoles() == array("ROLE_SUPERVISOR","ROLE_USER")) ) {
                    $user->setEnabled(true);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $view =new View("Users turned on Successfully", Response::HTTP_OK);

                }

            }
            return $this->handleView($view);

        }

    }
}
