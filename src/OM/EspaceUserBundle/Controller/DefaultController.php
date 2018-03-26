<?php

namespace OM\EspaceUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OMEspaceUserBundle:Default:index.html.twig');
    }
}
