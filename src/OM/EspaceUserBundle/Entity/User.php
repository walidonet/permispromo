<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 26/01/2018
 * Time: 11:42
 */
namespace OM\EspaceUserBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use OM\AdministrationBundle\Entity\Tag;
/**
 *
 *
 * User
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $firstname = "";
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $lastname = "";
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $idcard = "";
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $phone = "";
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $phone2 = "";
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $starcount ;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $adress = "";
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $adress2 = "";
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $calltype = "";
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $confirmation;
    /**
     * @ORM\Column(type="blob",nullable=true)
     */
    private $picture;
    /**
     * @ORM\OneToMany(targetEntity="OM\AdministrationBundle\Entity\Meeting", mappedBy="client")
     */
    private $meetings;
    /**
     * @ORM\ManyToOne(targetEntity="OM\EspaceUserBundle\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(name="monitor_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $monitor;
    /**
     * @ORM\ManyToOne(targetEntity="OM\EspaceUserBundle\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agent;
    /**
     * @ORM\OneToMany(targetEntity="OM\EspaceUserBundle\Entity\User", mappedBy="monitor")
     */
    private $clients;
    /**
     * @ORM\OneToMany(targetEntity="OM\EspaceUserBundle\Entity\User", mappedBy="agent")
     */
    private $prospects;
    /**
     * @ORM\ManyToMany(targetEntity="OM\AdministrationBundle\Entity\Tag",inversedBy="prospect",cascade={"persist"})
     */
    private $tags;
    /**
     * @ORM\ManyToMany(targetEntity="OM\AdministrationBundle\Entity\Source",inversedBy="prospect",cascade={"persist"})
     */
    private $sources;

    /**
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\PaymentMode", inversedBy="prospects")
     * @ORM\JoinColumn(name="paymentmode_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paymentmode;
    /**
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\PaymentModality", inversedBy="prospects")
     * @ORM\JoinColumn(name="paymentmodality_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paymentmodality;
    /**
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\Offre", inversedBy="prospects")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $offre;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getIdcard()
    {
        return $this->idcard;
    }

    /**
     * @param mixed $idcard
     */
    public function setIdcard($idcard)
    {
        $this->idcard = $idcard;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getMeetings()
    {
        return $this->meetings;
    }

    /**
     * @param mixed $meetings
     */
    public function setMeetings($meetings)
    {
        $this->meetings = $meetings;
    }

    /**
     * @return mixed
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param mixed $clients
     */
    public function setClients($clients)
    {
        $this->clients = $clients;
    }

    /**
     * @return mixed
     */
    public function getMonitor()
    {
        return $this->monitor;
    }

    /**
     * @param mixed $monitor
     */
    public function setMonitor($monitor)
    {
        $this->monitor = $monitor;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * @return mixed
     */
    public function getPaiementmode()
    {
        return $this->paiementmode;
    }

    /**
     * @param mixed $paiementmode
     */
    public function setPaiementmode($paiementmode)
    {
        $this->paiementmode = $paiementmode;
    }

    /**
     * @return mixed
     */
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * @param mixed $adress2
     */
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;
    }

    /**
     * @return mixed
     */
    public function getCalltype()
    {
        return $this->calltype;
    }

    /**
     * @param mixed $calltype
     */
    public function setCalltype($calltype)
    {
        $this->calltype = $calltype;
    }

    /**
     * @return mixed
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * @param mixed $confirmation
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;
    }

    /**
     * @return mixed
     */
    public function getConfrdv()
    {
        return $this->confrdv;
    }

    /**
     * @param mixed $confrdv
     */
    public function setConfrdv($confrdv)
    {
        $this->confrdv = $confrdv;
    }

    /**
     * @return mixed
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * @param mixed $phone2
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    /**
     * @return mixed
     */
    public function getStarcount()
    {
        return $this->starcount;
    }

    /**
     * @param mixed $starcount
     */
    public function setStarcount($starcount)
    {
        $this->starcount = $starcount;
    }



    /**
     * @return mixed
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * @param mixed $offre
     */
    public function setOffre($offre)
    {
        $this->offre = $offre;
    }

    /**
     * @return mixed
     */
    public function getFb()
    {
        return $this->fb;
    }

    /**
     * @param mixed $fb
     */
    public function setFb($fb)
    {
        $this->fb = $fb;
    }

    /**
     * @return mixed
     */
    public function getInsta()
    {
        return $this->insta;
    }

    /**
     * @param mixed $insta
     */
    public function setInsta($insta)
    {
        $this->insta = $insta;
    }

    /**
     * @return mixed
     */


    /**
     * @return mixed
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param mixed $network
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    }

    /**
     * @return mixed
     */
    public function getRdvdep()
    {
        return $this->rdvdep;
    }

    /**
     * @param mixed $rdvdep
     */
    public function setRdvdep($rdvdep)
    {
        $this->rdvdep = $rdvdep;
    }

    /**
     * @return mixed
     */
    public function getRdvfin()
    {
        return $this->rdvfin;
    }

    /**
     * @param mixed $rdvfin
     */
    public function setRdvfin($rdvfin)
    {
        $this->rdvfin = $rdvfin;
    }

    /**
     * @return mixed
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param mixed $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }

    /**
     * @return mixed
     */
    public function getProspects()
    {
        return $this->prospects;
    }

    /**
     * @param mixed $prospects
     */
    public function setProspects($prospects)
    {
        $this->prospects = $prospects;
    }

    /**
     * @return mixed
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * @param mixed $sources
     */
    public function setSources($sources)
    {
        $this->sources[] = $sources;
    }



    /**
     * @return mixed
     */
    public function getPaymentmode()
    {
        return $this->paymentmode;
    }

    /**
     * @param mixed $paymentmode
     */
    public function setPaymentmode($paymentmode)
    {
        $this->paymentmode = $paymentmode;
    }

    /**
     * @return mixed
     */
    public function getPaymentmodality()
    {
        return $this->paymentmodality;
    }

    /**
     * @param mixed $paymentmodality
     */
    public function setPaymentmodality($paymentmodality)
    {
        $this->paymentmodality = $paymentmodality;
    }










}