<?php

namespace OM\AdministrationBundle\Controller;

use OM\AdministrationBundle\Entity\Noterdv;
use OM\EspaceUserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $a = count($restresult);
        $pro = array();
        for ($i = 0; $i < $a; $i++) {
            if ($restresult[$i]->hasRole('ROLE_PROSPECT')) {
                array_push($pro, $restresult[$i]);
            }
        }
        $b = count($pro);
        $note = array();
        $tnow = new \DateTime('now');
        $ftnow = $tnow->format("H:i");
        for ($i = 0; $i < $b; $i++) {
            //if()
            $shorttime = $pro[$i]->getRdvdep()->format("H:i");
            $shorttime1 = $pro[$i]->getConfrdv()->format("H:i");
            if ($shorttime - $ftnow == 3 || $shorttime1 - $ftnow == 3) {
                $f = array("tags :" => $pro[$i]->getTags(), "user :" => $pro[$i]->getLastname() . ' ' . $pro[$i]->getFirstname(),
                    "depart" => $pro[$i]->getRdvdep(), "confi" => $pro[$i]->getConfrdv());
                array_push($note, $f);
            }
        }
        return $note;
    }

    /**
     * @Rest\Get("/api/notificationrdv", name="notificationRdv")
     * @param Request $request
     * @return array
     */
    public function RdvNotificationAction(Request $request)
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Rdv')->findAll();
        //dump($restresult); die();

        $temps = new \DateTime('now');
        $now = new \DateTime('now');
        $limite = new \DateTime('now');



        $interval = new \DateInterval('P0Y0DT1H0M');
        $interval2 = new \DateInterval('P0Y3DT0H0M');
        $temps->add($interval);

        $limite->add($interval2);

        /*
        if ($temps > $now){
                    dump('3eh');die();
                }*/

        $response = array();
        foreach ($restresult as $res) {
            if ($res->getDaterdv()<= $limite){
            $prospect = $res->getProspect();
            if ($prospect->hasRole('ROLE_PROSPECT') && ($res->getDaterdv() >= $temps)) {

                $hrdv= $res->getDaterdv()->format('H:i:s');
                if ($res->getType()== 1) {
                    $message = 'Date  RDV  de ' . $prospect->getLastName() . ' ' . $prospect->getFirstName() . ' est à ' . $hrdv;
                }
                elseif ($res->getType()== 2) {
                    $message = 'Date ouvert  ' . $prospect->getLastName() . ' ' . $prospect->getFirstName() . ' est à ' . $hrdv;
                }
                else{
                    $message = 'l heure de confirmation de ' . $prospect->getLastName() . ' ' . $prospect->getFirstName() . ' est à ' . $hrdv;
                }




                array_push($response, $message);
            }
            }

        }
        return $response;
    }


}
