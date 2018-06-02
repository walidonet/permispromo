<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 28/05/2018
 * Time: 16:26
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="tranche")
 * @ORM\Entity
 */
class Tranche
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix ;
    /**
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\PaymentModality",inversedBy="tranches")
     * @ORM\JoinColumn(name="pmod_id", referencedColumnName="id")
     */
    private $paymentmodal;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $work ;

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
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getPaymentmodal()
    {
        return $this->paymentmodal;
    }

    /**
     * @param mixed $paymentmodal
     */
    public function setPaymentmodal($paymentmodal)
    {
        $this->paymentmodal = $paymentmodal;
    }

    /**
     * @return mixed
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @param mixed $work
     */
    public function setWork($work)
    {
        $this->work = $work;
    }



}