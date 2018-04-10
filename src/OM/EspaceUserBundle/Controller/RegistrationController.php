<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 26/01/2018
 * Time: 14:01
 */

namespace OM\EspaceUserBundle\Controller;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
/*****/

use FOS\RestBundle\Controller\Annotations as Rest;

use OM\AdministrationBundle\Entity\Folder;
use OM\AdministrationBundle\Entity\Note;
use OM\AdministrationBundle\Entity\Rdv;
use OM\AdministrationBundle\Entity\Source;
use OM\AdministrationBundle\Entity\Tag;
use OM\EspaceUserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Controller managing the registration.

 */
class RegistrationController extends BaseController
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public $container;

    /**
     * AfterLoginFailureRedirection constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     *
     * @Route("/signup", name="user_register")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request)
    {


        $userManager = $this->get('fos_user.user_manager');


        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $phone = $request->get('phone');
        $phone2 = $request->get('phone2');
        $starcount = $request->get('starsCount');
        $adress = $request->get('adress');
        $adress2 = $request->get('adress2');
        $calltype = $request->get('calltype');
        $note = $request->get('note');
        //date
        $confirmation = $request->get('confirmation'); //date confirmation
        $rdvdep = $request->get('rdvdep'); //daterdv
        $rdvfin = $request->get('$rdvfin'); //ouver jus
        /*var_dump($confirmation);
        var_dump($rdvfin);
        var_dump($rdvdep);die();*/
        // confir
        $confrdv = $request->get('confrdv'); //bouton conf

        $agent = $request->get('agent');
        $useragent = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($agent);
        $em = $this->getDoctrine()->getManager();

        $noteuser = new Note();
        $noteuser->setWork(1);
        $noteuser->setNom($note);

        $noteuser->setTiming(new \DateTime('now'));


        $rdvfinrdv = new Rdv();

        if ($rdvfin != 'null' || $rdvfin == null || empty($rdvfin)) {
            $timestamp = strtotime(preg_replace('/( \(.*)$/', '', $rdvfin));
            $dt1 = date('Y-m-d H:i:s \G\M\TP', $timestamp);
            $dt = new \DateTime($dt1);
            $rdvfinrdv->setDaterdv($dt);

            $rdvfinrdv->setType(2);
            $rdvfinrdv->setDaterdv($dt);
        }
        $rdvdeprdv = new Rdv();
        if ($rdvdep != 'null' || $rdvdep == null || empty($rdvdep)) {

            $timestamp = strtotime(preg_replace('/( \(.*)$/', '', $rdvdep));
            $dt1 = date('Y-m-d H:i:s \G\M\TP', $timestamp);
            $dt = new \DateTime($dt1);
            $rdvdeprdv->setDaterdv($dt);

            $rdvdeprdv->setType(1);
            $rdvdeprdv->setDaterdv($dt);
        }
        $confirmationrdv = new Rdv();
        if ($confirmation != 'null' || $confirmation == null || empty($confirmation)) {

            $timestamp = strtotime(preg_replace('/( \(.*)$/', '', $confirmation));
            $dt1 = date('Y-m-d H:i:s \G\M\TP', $timestamp);
            $dt = new \DateTime($dt1);
            $confirmationrdv->setDaterdv($dt);

            $confirmationrdv->setType(3);
            $confirmationrdv->setDaterdv($dt);
        }


        $tags = $request->get('tags');
        $sources = $request->get('fb');


        $user = $userManager->createUser();


        $paymentmode = $request->get('paiementmode');
        $pmode = $em->getRepository('OMAdministrationBundle:PaymentMode')
            ->find($paymentmode);

        $paymentmodality = $request->get('paiement');
        $pmoda = $em->getRepository('OMAdministrationBundle:PaymentModality')
            ->find($paymentmodality);

        $offre = $request->get('offre');
        $offreuser = $em->getRepository('OMAdministrationBundle:Offre')
            ->find($offre);


        $a = json_decode($tags);
        // var_dump($a);
        //var_dump($tags);die();
        if ($tags == 'null' || $tags == null || empty($tags)) {
        $ltag = (array)new Tag();
        for ($c = 0; $c < count($a); $c++) {

            $tmp = $this->get('doctrine.orm.entity_manager')
                ->getRepository('OMAdministrationBundle:Tag')
                ->findOneBynom($a[$c]);
            array_push($ltag, $tmp);
            $user->setTags($tmp);
        }
    }
        // dump($user->getTags());die();


        $b = json_decode($sources);
        $source = (array)new Source();
        //for($count=0;$count<count($b);$c++){
        $tmp = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMAdministrationBundle:Source')
            ->findOneBy(array('libele' => $sources));

        //array_push($source,$tmp);
        $user->setSources($tmp);
        // }

        //$user->setSources($sources);


        $user->setUsername($phone);
        $user->setEmail($phone . "@gmail.com");
        $user->setEnabled(true);
        $user->setPassword($phone);
        $user->setPlainPassword($phone);

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);
        $user->setPhone2($phone2);
        $user->setStarcount($starcount);
        $user->setAdress($adress);
        $user->setAdress2($adress2);
        $user->setCalltype($calltype);
        if ($confrdv == 'true')
            $user->setConfrdv(true);
        else
            $user->setConfrdv(false);
        $user->setAgent($useragent);
        $user->setPaymentmodality($pmoda);
        $user->setPaymentmode($pmode);
        $user->setOffre($offreuser);
        $user->setRoles(array('ROLE_PROSPECT'));
        if($confirmation!='null' || $confirmation == null || empty( $confirmation)) {
            $confirmationrdv->setProspect($user);
            $em->persist($confirmationrdv);
            $em->flush();
        }
        if($rdvdep!='null' || $rdvdep == null || empty( $rdvdep)) {
            $rdvdeprdv->setProspect($user);
            $em->persist($rdvdeprdv);
            $em->flush();
        }
        if($rdvfin!="null" || $rdvfin == null || empty( $rdvfin)) {
            $rdvfinrdv->setProspect($user);
            $em->persist($rdvfinrdv);
            $em->flush();
        }
        $noteuser->setProspect($user);
        $noteuser->setClient($useragent);
        $em->persist($noteuser);
        $em->flush();
        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User");
        return $response;

    }

//fct
    public function updaterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($request->get('id'));

        $phone = $request->get('phone');
        $starcount = $request->get('starcount');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $phone2 = $request->get('phone2');
        $adress = $request->get('adress');
        $adress2 = $request->get('adress2');
        $offre = $request->get('offre');
        $paymentmodality = $request->get('paymentmodality');
        $calltype = $request->get('calltype');
        $paymentmode = $request->get('paymentmode');
        //var_dump($paymentmode);die();
        $pmode = $em->getRepository('OMAdministrationBundle:PaymentMode')
            ->find($paymentmode);


        $pmoda = $em->getRepository('OMAdministrationBundle:PaymentModality')
            ->find($paymentmodality);

        $offreuser = $em->getRepository('OMAdministrationBundle:Offre')
            ->find($offre);


        $user->setUsername($phone);
        $user->setStarcount($starcount);
        $user->setEmail($phone . "@gmail.com");
        $user->setEnabled(true);
        $user->setPassword($phone);
        $user->setPlainPassword($phone);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);
        $user->setPhone2($phone2);
        $user->setAdress($adress);
        $user->setAdress2($adress2);
        $user->setCalltype($calltype);
        $user->setPaymentmodality($pmoda);
        $user->setPaymentmode($pmode);
        $user->setOffre($offreuser);

        $userManager->updateUser($user, true);
        $response = new JsonResponse();
        $response->setData("User");
        return $response;
    }


    public function converterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($request->get('id'));

        $email = $request->get('email');
        $password1 = $request->get('password');
        $password2 = $request->get('plainPassword');


        $user->setEmail($email);
        $user->setPassword($password1);
        $user->setPlainPassword($password2);
        $user->setRoles(array('ROLE_CLIENT'));

        $userManager->updateUser($user, true);
        $response = new JsonResponse();
        $response->setData("User");
        return $response;


    }



    //---------------------------------- add worker or supervisor -------------------------------------------- //

    public function addWorkerAction(Request $request)
    {


        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $username = $request->get('username');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $phone = $request->get('phone');
        $adress = $request->get('adress');
        $email = $request->get('email');
        $password1 = $request->get('password');
        $password2 = $request->get('plainPassword');
        $roles = $request->get('roles');

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPassword($password1);
        $user->setPlainPassword($password2);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);
        $user->setAdress($adress);
        if ($roles == '1')
            $user->setRoles(array('ROLE_SUPERVISOR'));
        else
            $user->setRoles(array('ROLE_WORKER'));



        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User");
        return $response;

    }

    //---------------------------------- add Monitor -------------------------------------------- //


    public function addMonitorAction(Request $request)
    {


        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $username = $request->get('username');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $phone = $request->get('phone');
        $adress = $request->get('adress');
        $email = $request->get('email');
        $password1 = $request->get('password');
        $password2 = $request->get('plainPassword');

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_MONITOR'));
        $user->setPassword($password1);
        $user->setPlainPassword($password2);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);
        $user->setAdress($adress);
        $user->setRoles(array('ROLE_MONITOR'));

        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User");
        return $response;

    }





    //---------------------------------- add client -------------------------------------------- //


    public function addClientAction(Request $request)
    {


        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $username = $request->get('username');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $phone = $request->get('phone');
        $adress = $request->get('adress');
        $email = $request->get('email');
        $password1 = $request->get('password');
        $password2 = $request->get('plainPassword');

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPassword($password1);
        $user->setPlainPassword($password2);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);
        $user->setAdress($adress);
        $user->setRoles(array('ROLE_CLIENT'));

        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User");
        return $response;

    }






}