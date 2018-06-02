<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 29/01/2018
 * Time: 15:53
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

/**
 *
 *
 * User
 * @ORM\Table(name="folder")
 * @ORM\Entity
 */
class Folder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $tranche = "";
    /**
     * @ORM\Column(type="string")
     */
    private $etat = "";

    /**
     * @ORM\ManyToOne(targetEntity="OM\EspaceUserBundle\Entity\User",inversedBy="folder")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
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
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
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

    /**
     * @return mixed
     */
    public function getTranche()
    {
        return $this->tranche;
    }

    /**
     * @param mixed $tranche
     */
    public function setTranche($tranche)
    {
        $this->tranche = $tranche;
    }

}