<?php

namespace OM\AdministrationBundle\Controller;

use OM\AdministrationBundle\Entity\Noterdv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class NotificationController extends FOSRestController
{
    
    /**
     * @Rest\Get("/api/notification", name="note")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function GetmyNotificationAction(Request $request)
    {
        $restresult = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->findAll();
        $a=count($restresult);
        $pro=array();
        for($i=0;$i<$a;$i++){
            if($restresult[$i]->hasRole('ROLE_PROSPECT')){
                array_push($pro,$restresult[$i]);
            }
        }
        $b=count($pro);
        $note=array();
        $tnow=new \DateTime('now');
        $ftnow = $tnow->format("H:i");
        for($i=0;$i<$b;$i++){
            //if()
            $shorttime = $pro[$i]->getRdvdep()->format("H:i");
            $shorttime1 = $pro[$i]->getConfrdv()->format("H:i");
            if($shorttime-$ftnow==3 || $shorttime1-$ftnow==3){
               $f= array("tags :"=>$pro[$i]->getTags(),"user :"=>$pro[$i]->getLastname().' '.$pro[$i]->getFirstname(),
                    "depart"=>$pro[$i]->getRdvdep(),"confi"=>$pro[$i]->getConfrdv());
                array_push($note,$f);
            }
        }
        return $note;
    }

}
