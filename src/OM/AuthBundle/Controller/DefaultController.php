<?php

namespace OM\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OMAuthBundle:Default:index.html.twig');
    }
}
