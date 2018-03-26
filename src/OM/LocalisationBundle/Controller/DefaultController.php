<?php

namespace OM\LocalisationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OMLocalisationBundle:Default:index.html.twig');
    }
}
