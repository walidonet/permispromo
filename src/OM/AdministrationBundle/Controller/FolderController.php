<?php

namespace OM\AdministrationBundle\Controller;

use OM\AdministrationBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OM\AdministrationBundle\Entity\Meeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FolderController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/api/up")
     * @param Request $request
     * @Rest\View()
     */
    public function upAction(Request $request){
        $file = $request->files->get('File');
        //$a = new FileUploader($this->getParameter('brochures_directory'));
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('brochures_directory'), $fileName);
        return $fileName;
    }
    /**
     * @Rest\Post("/api/folder")
     * @param Request $request
     * @Rest\View()
     */
    public function uaddfolderAction(Request $request){
        $data = new Folder();
        $etat = $request->get('etat');
        $image1 = $request->get('image1');
        $image2 = $request->get('image2');
        $image3 = $request->get('image3');
        $offre = $request->get('offre');
        $client = $request->get('user');
        $prod = $request->get('offre');
        $apprenti = $this->getDoctrine()->getRepository('OMEspaceUserBundle:User')
            ->find($client);
        $produit = $this->getDoctrine()->getRepository('OMAdministrationBundle:Product')
            ->find($prod);
        $em = $this->getDoctrine()->getManager();
        $apprenti->setProduct($produit);
        $apprenti->setImage3($image3);
        $apprenti->setImage2($image2);
        $apprenti->setImage1($image1);
        $em->merge($apprenti);
        $em->flush();
        $data->setEtat($etat);
        $data->setClient($apprenti);
        $data->setClient($apprenti);
        $data->setTranche(1);
        $em->persist($data);
        $em->flush();
        $view =new View("Meeting Added Successfully", Response::HTTP_OK);

        return $this->handleView($view);
    }
}
