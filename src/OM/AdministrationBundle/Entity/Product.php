<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 09/05/2018
 * Time: 17:30
 */

namespace OM\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $libelle ;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $work ;

    /**
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\PaymentMode",inversedBy="mode", cascade={"persist","merge", "remove"})
     */
    private $mode;

    /**
     *
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\PaymentModality",inversedBy="modality", cascade={"persist", "remove"})
     */
    private $modality;


    /**
     *
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\Offre", inversedBy="offre",cascade={"persist", "remove"})
     */
    private $offre;

    /**
     *
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\Contract", inversedBy="contract",cascade={"persist", "remove"})
     */
    private $contract;
    /**
     * @ORM\ManyToMany(targetEntity="OM\EspaceUserBundle\Entity\User",inversedBy="sources",cascade={"persist", "merge", "remove"})
     */
    private $client;

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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
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

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getModality()
    {
        return $this->modality;
    }

    /**
     * @param mixed $modality
     */
    public function setModality($modality)
    {
        $this->modality = $modality;
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
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @param mixed $contract
     */
    public function setContract($contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }






}