<?php

namespace OM\AdministrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Task;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends FOSRestController
{
    /**
     * @Rest\Post("/api/task", name="task")
     * @param Request $request
     * @return Response
     */

    public function postTaskAction(Request $request)
    {

        $data = new Task();
        $libelle = $request->get('libelle');
        $priorite = $request->get('priorite');
        $deadline = $request->get('deadline');
        $agent = $request->get('agent');

        $restresult = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')->find($agent);
        $a = json_decode($agent);

        if ($agent != 'null' || $agent != null || !empty($agent)) {

            $lagent = (array)new Task();
            for ($c = 0; $c < count($a); $c++) {
                $tmp = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('OMEspaceUserBundle:User')
                    ->findOneBy(array('username' => $a[$c]));
               // var_dump($tmp);die();
                $data->setAgent($tmp);
            }
        }
        if ($deadline != 'null' || $deadline != null || !empty($deadline)) {

            $timestamp = strtotime(preg_replace('/( \(.*)$/', '', $deadline));
            $dt1 = date('Y-m-d H:i:s \G\M\TP', $timestamp);
            $dt = new \DateTime($dt1);
        }

        $data->setLibelle($libelle);
        $data->setPriorite($priorite);
        $data->setDeadline($dt);
        //$data->setAgent($restresult);


        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view =new View("task added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/api/task", name="_allTasks")
     *
     */
    public function getTaskAction()
    {
        $restresult = $this->getDoctrine()->getRepository('OMAdministrationBundle:Task')->findAll();
        if ($restresult === null) {
            return new View("Pas de task disponible", Response::HTTP_NOT_FOUND);
        }
        $formatted = [];
        foreach ($restresult as $result) {
            $formatted[] = [

                'libelle' => $result->getLibelle(),
                'Priorite' => $result->getPriorite(),
                'deadline' => $result->getDeadline(),
                'agent' => $result->getAgent(),

            ];
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\Put("api/{id}/task")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateStickyAction(Request $request)
    {
        $sticky = new Task();
        $id = $request->get('id');
        $libelle = $request->get('libelle');
        $deadline = $request->get('deadline');
        $priorite = $request->get('priorite');
        //$agent = $request->get('agent');
        $em = $this->getDoctrine()->getManager();
        $task = $this->getDoctrine()->getRepository('OMAdministrationBundle:Task')->find($id);
        if (empty($task)) {
            $view = new View("task not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        elseif(!empty($libelle) ){
            $task->setLibelle($libelle);
            $em->flush();
            $view =new View("task Updated Successfully", Response::HTTP_OK);
            return $this->handleView($view);
        }
        else{
            $view = new View("task cannot be empty", Response::HTTP_NOT_ACCEPTABLE);

            return $this->handleView($view);
        }
    }


    /**
     * @Rest\Delete("api/{id}/task")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $id  = $request->get('id');
        $data = new Task();
        $em = $this->getDoctrine()->getManager();
        $task = $this->getDoctrine()->getRepository('OMAdministrationBundle:Task')->find($id);
        if (empty($task)) {
            $view = new View("task not found", Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }
        else {
            $task->setAgent(null);
            $em->remove($task);
            $em->flush();
        }
        $view = new View("Task deleted successfully", Response::HTTP_OK);
        return $this->handleView($view);
    }





}
