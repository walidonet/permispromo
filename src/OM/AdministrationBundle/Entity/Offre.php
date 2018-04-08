<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 30/03/2018
 * Time: 16:13
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="offre")
 * @ORM\Entity
 */
class Offre
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
    private $libele ;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix ;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $work ;
    /**
     * @ORM\ManyToMany(targetEntity="OM\EspaceUserBundle\Entity\User",inversedBy="sources",cascade={"persist", "merge", "remove"})
     */
    private $prospect;

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
    public function getLibele()
    {
        return $this->libele;
    }

    /**
     * @param mixed $libele
     */
    public function setLibele($libele)
    {
        $this->libele = $libele;
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
    public function getProspect()
    {
        return $this->prospect;
    }

    /**
     * @param mixed $prospect
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect;
    }

}