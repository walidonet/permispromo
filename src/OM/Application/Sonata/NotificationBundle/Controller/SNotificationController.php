<?php

namespace OM\Application\Sonata\NotificationBundle\Controller;

use Glooby\TaskBundle\Task\TaskInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Glooby\TaskBundle\Annotation\Schedule;

class SNotificationController extends FOSRestController implements TaskInterface
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    public function run(array $params = [])
    {

        return 'wFs';
    }
}
