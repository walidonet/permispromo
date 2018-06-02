<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 02/06/2018
 * Time: 03:01
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Table(name="session")
 * @ORM\Entity
 */
class Session
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
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $timing ;
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
     * @return \DateTime
     */
    public function getTiming()
    {
        return $this->timing;
    }

    /**
     * @param \DateTime $timing
     */
    public function setTiming($timing)
    {
        $this->timing = $timing;
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