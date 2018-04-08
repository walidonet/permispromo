<?php

namespace OM\AuthBundle\Controller;

use OM\AdministrationBundle\Entity\Folder;
use OM\EspaceUserBundle\Controller\RegistrationController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends FOSRestController
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public $container;

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/ss/{token}")
     * @param Request $request
     * @return View
     */
    public function getSessionAction(Request $request)
    {
        $id = $request->get('token');
        $userid = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMAuthBundle:RefreshToken')
            ->findOneBytoken($id);
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($userid->getUser()->getId());
        return $user;
        //return $user->getId();
    }
    /**
     * @Rest\Post("/api/add")
     * @param Request $request
     * @return View
     */
    public function testAction(Request $request)
    {


        $reg = new RegistrationController( $this->container);
        $reg->registerAction($request);

    }
    /**
     * @Rest\Post("/worker/add")
     * @param Request $request
     * @return View
     */
    public function registerworkerAction(Request $request)
    {


        $reg = new RegistrationController( $this->container);
        $reg->registerworkerAction($request);

    }
    /**
     * @Rest\Put("/api/change/{id}")
     * @param Request $request
     * @return View
     */
    public function changeAction(Request $request)
    {


        $reg = new RegistrationController( $this->container);
        $reg->updaterAction($request);

    }

    /**
     * @Rest\Get("/api/prospect")
     */
    public function getAllproespectAction()
    {
        //var_dump('hello death');die();
        $userid = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->findAll();
        $a=count($userid);
        $pro=array();

        for($i=0;$i<$a;$i++){

           // if($userid[$i]->getRoles()==array('ROLE_PROSPECT')){
            if($userid[$i]->getRoles()[0]=='ROLE_PROSPECT'){
                array_push($pro,$userid[$i]);
            }
        }
        return $pro;
    }
    /**
     * @Rest\Get("/api/myprospect/{id}")
     */
    public function getMyproespectAction(Request $request)
    {
        $id = $request->get('id');
        $userid = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->findAll();
        //return $userid;

        $a=count($userid);
        $pro=array();

        for($i=0;$i<$a;$i++){

            // if($userid[$i]->getRoles()==array('ROLE_PROSPECT')){
            if($userid[$i]->getRoles()[0]=='ROLE_PROSPECT' && $userid[$i]->getAgent()->getId()==$id ){
                array_push($pro,$userid[$i]);
            }
        }
        return $pro;
    }
    /**
     * @Rest\Get("/api/prospect/{id}", name="getpros")
     * @return View
     */
    public function getProespectbyIdAction(Request $request)
    {
        $userid = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($request->get('id'));

        return $userid;
    }
    /**
     * @Rest\Get("/api/agent")
     */
    public function getAllagenttAction()
    {
        //var_dump('hello death');die();
        $userid = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->findAll();
        $a=count($userid);
        $pro=array();

        for($i=0;$i<$a;$i++){

            // if($userid[$i]->getRoles()==array('ROLE_PROSPECT')){
            if($userid[$i]->getRoles()[0]=='ROLE_WORKER'){
                array_push($pro,$userid[$i]);
            }
        }
        return $pro;
    }



}
