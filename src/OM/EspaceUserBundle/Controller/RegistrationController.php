<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 26/01/2018
 * Time: 14:01
 */

namespace OM\EspaceUserBundle\Controller;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
/*****/

use OM\AdministrationBundle\Entity\Folder;
use OM\AdministrationBundle\Entity\Tag;
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
     * @param RouterInterface $router
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container)
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
       // $confrdv = $request->get('confrdv');
        $phone = $request->get('phone');
        $phone2 = $request->get('phone2');
        $adress = $request->get('adress');
        $adress2 = $request->get('adress2');
        $calltype = $request->get('calltype');
        $fb = $request->get('fb');
        $insta = $request->get('insta');
        $network = $request->get('network');
        $offre = $request->get('offre');
        $note = $request->get('note');
        $confrdv = $request->get('confrdv');
        $confirmation = $request->get('confirmation');
        $rdvfin = $request->get('rdvfin');
        $rdvdep = $request->get('rdvdep');
        $paiementmode = $request->get('paiementmode');
        $paiement = $request->get('paiement');
        $starcount = $request->get('starsCount');
        /***/
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $tags = $request->get('tags');
        $agent = $request->get('agent');
        $useragent = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($agent);

        /***/


        $user = $userManager->createUser();
        $a=json_decode($tags);
        $ltag =  (array) new Tag();
        for($c=0;$c<count($a);$c++){
            $tmp = $this->get('doctrine.orm.entity_manager')
                ->getRepository('OMAdministrationBundle:Tag')
                ->findOneBynom($a[$c]);

            array_push($ltag,$tmp);
            $user->setTags($tmp);

        }
        //$user->setTags($ltag);
       //var_dump($password['first_options']);die();
        //$user->setUsername($username);
       // $user->setEmail($email);

        $user->setUsername($phone);
        $user->setAgent($useragent);
        //$user->setTags($tags);
        //$user->setEmail($tags);
        $user->setEmail($phone."@gmail.com");
        $user->setEnabled(true);
        $user->setPassword($phone);
        $user->setPlainPassword($phone);
        $user->setStarcount($starcount);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);

        $user->setPaiement($paiement);
        $user->setPaiementmode($paiementmode);
        $user->setRdvfin(new \DateTime($rdvfin));
        $user->setRdvfin(new \DateTime($rdvfin));
        $user->setRdvdep(new \DateTime($rdvdep));
        if($confirmation== null|| $confirmation == 'false'){
            $user->setConfirmation(0);
        }
        else{
            $user->setConfirmation(1);
        }
        $user->setConfrdv(new \DateTime($confrdv));
        $user->setOffre($offre);
        if($network== '' || $network == 'false'){
            $user->setNetwork(0);
        }else {
            $user->setNetwork(1);
        }
        if($insta== ''|| $insta == 'false'){
            $user->setInsta(0);
        }else {
            $user->setInsta(1);
        }
        if($fb== ''|| $fb == 'false'){
            $user->setFb(0);
        }
        else {
            $user->setFb(1);
        }
        $user->setCalltype($calltype);
        $user->setNote($note);
        $user->setAdress2($adress2);
        $user->setAdress($adress);
        $user->setPhone2($phone2);
        $user->setPhone($phone);
        /***/
        //$user->setRoles(array($roles));

        $user->setRoles(array('ROLE_PROSPECT'));
        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User" );
        return $response;

    }



    public function updaterAction(Request $request)
    {

        $userManager = $this->get('fos_user.user_manager');
        //$user = $userManager->createUser();
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($request->get('id'));
      //  var_dump($request->get('id'));die();
       // var_dump($user->getEmail());die();
        // $confrdv = $request->get('confrdv');
        $phone = $request->get('phone');
        $phone2 = $request->get('phone2');
        $adress = $request->get('adress');
        $adress2 = $request->get('adress2');
        $offre = $request->get('offre');
        $note = $request->get('note');
        $rdvdep = $request->get('rdvdep');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
//var_dump($firstname);die();

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setRdvdep(new \DateTime($rdvdep));
        $user->setOffre($offre);
        $user->setNote($note);
        $user->setAdress2($adress2);
        $user->setAdress($adress);
        $user->setPhone2($phone2);
        $user->setPhone($phone);
        $user->setRoles(array('ROLE_PROSPECT'));
        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User" );
        return $response;

    }
    /***/
    /**
     *
     * @Route("/signup", name="user_register")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function registerworkerAction(Request $request)
    {


        $userManager = $this->get('fos_user.user_manager');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $password = $request->get('password');
        $roles=$request->get('role');
        $user = $userManager->createUser();
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPassword($password);
        $user->setPlainPassword($password);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);



        $user->setRoles(array($roles));
        $userManager->updateUser($user, true);


        $response = new JsonResponse();
        $response->setData("User" );
        return $response;

    }


}