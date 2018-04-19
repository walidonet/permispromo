<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 14/04/2018
 * Time: 18:24
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="gouvernera")
 * @ORM\Entity
 */
class Gouvernera
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
     * @ORM\OneToMany(targetEntity="OM\AdministrationBundle\Entity\City", mappedBy="gouvernera")
     */
    private $citys;

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
    public function getCitys()
    {
        return $this->citys;
    }

    /**
     * @param mixed $citys
     */
    public function setCitys($citys)
    {
        $this->citys = $citys;
    }


}