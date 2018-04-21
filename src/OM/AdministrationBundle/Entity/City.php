<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 14/04/2018
 * Time: 18:25
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="city")
 * @ORM\Entity
 */
class City
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
    private $nom ;

    private $prospectdom;

    private $prospectpro;
    /**
     * @ORM\ManyToOne(targetEntity="OM\AdministrationBundle\Entity\Gouvernera", inversedBy="citys")
     * @ORM\JoinColumn(name="gouvernera_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $gouvernera;

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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getProspectdom()
    {
        return $this->prospectdom;
    }

    /**
     * @param mixed $prospectdom
     */
    public function setProspectdom($prospectdom)
    {
        $this->prospectdom = $prospectdom;
    }

    /**
     * @return mixed
     */
    public function getProspectpro()
    {
        return $this->prospectpro;
    }

    /**
     * @param mixed $prospectpro
     */
    public function setProspectpro($prospectpro)
    {
        $this->prospectpro = $prospectpro;
    }

    /**
     * @return mixed
     */
    public function getGouvernera()
    {
        return $this->gouvernera;
    }

    /**
     * @param mixed $gouvernera
     */
    public function setGouvernera($gouvernera)
    {
        $this->gouvernera = $gouvernera;
    }



}