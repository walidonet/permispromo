<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 17/02/2018
 * Time: 12:23
 */
namespace OM\EspaceUserBundle\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
class DemoController extends FOSRestController
{

    /**
     * @Rest\Get("/test")
     * @param Request $request
     * @Rest\View()
     */
    public function getDemosAction()
    {
        var_dump('hello');
    }



}