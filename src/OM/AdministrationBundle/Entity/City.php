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
    /**
     * @ORM\ManyToMany(targetEntity="OM\EspaceUserBundle\Entity\User",inversedBy="sources",cascade={"persist", "merge", "remove"})
     */
    private $prospect;
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