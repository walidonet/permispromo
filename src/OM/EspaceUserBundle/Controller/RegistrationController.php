<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 26/01/2018
 * Time: 14:01
 */

namespace OM\EspaceUserBundle\Controller;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
/*****/

use OM\AdministrationBundle\Entity\Folder;
use OM\AdministrationBundle\Entity\Source;
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



        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $phone = $request->get('phone');
        $phone2 = $request->get('phone2');
        $starcount = $request->get('starsCount');
        $adress = $request->get('adress');
        $adress2 = $request->get('adress2');
        $calltype = $request->get('calltype');
        $confirmation = $request->get('confirmation');

        $agent = $request->get('agent');
        $useragent = $this->get('doctrine.orm.entity_manager')
            ->getRepository('OMEspaceUserBundle:User')
            ->find($agent);

        $tags = $request->get('tags');
        $sources = $request->get('sources');

        $user = $userManager->createUser();

        $em = $this->getDoctrine()->getManager();


        $paymentmode = $request->get('paymentmode');
        $pmode = $em->getRepository('OMAdministrationBundle:PaymentMode')
            ->find($paymentmode);

        $paymentmodality = $request->get('paymentmodality');
        $pmode = $em->getRepository('OMAdministrationBundle:PaymentModality')
            ->find($paymentmodality);

        $offre = $request->get('offre');
        $offreuser = $em->getRepository('OMAdministrationBundle:Offre')
            ->find($offre);









        $a=json_decode($tags);
        $ltag =  (array) new Tag();
        for($c=0;$c<count($a);$c++){
            $tmp = $this->get('doctrine.orm.entity_manager')
                ->getRepository('OMAdministrationBundle:Tag')
                ->findOneBynom($a[$c]);

            array_push($ltag,$tmp);
            $user->setTags($tmp);
        }

        $b=json_decode($sources);
        $source =  (array) new Source();
        for($count=0;$count<count($b);$c++){
            $tmp = $this->get('doctrine.orm.entity_manager')
                ->getRepository('OMAdministrationBundle:Source')
                ->findOneBy(array('libele'=>$b[$c]));

            array_push($source,$tmp);
            $user->setSources($tmp);
        }

        $user->setUsername($phone);
        $user->setEmail($phone."@gmail.com");
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
        $user->setConfirmation($confirmation);
        $user->setAgent($useragent);
        $user->setPaiement($paymentmodality);
        $user->setPaiementmode($pmode);
        $user->setOffre($offre);
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