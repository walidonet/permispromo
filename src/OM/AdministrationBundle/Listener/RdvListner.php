<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 12/05/2018
 * Time: 22:37
 */

namespace OM\AdministrationBundle\Listener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Validator\Constraints\Date;

class RdvListner
{
    public function onKernelRequest (GetResponseEvent $event)
    {
        $now = new \DateTime('now');
        try {
            $interval = new \DateInterval('P0Y0DT1H0M');
        } catch (\Exception $e) {
        }

        $em = $this->getDoctrine()->getManager();



    }

}