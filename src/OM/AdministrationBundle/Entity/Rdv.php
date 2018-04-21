<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 30/03/2018
 * Time: 16:12
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="rdv")
 * @ORM\Entity
 */
class Rdv
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
    private $type ;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $daterdv ;
//    /**
//     * @ORM\Column(type="boolean", nullable=true)
//     */
//    private $work ;
    /**
     * @ORM\ManyToOne(targetEntity="OM\EspaceUserBundle\Entity\User",inversedBy="rdvs",cascade={"persist", "merge", "remove"})
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDaterdv()
    {
        return $this->daterdv;
    }

    /**
     * @param mixed $daterdv
     */
    public function setDaterdv($daterdv)
    {
        $this->daterdv = $daterdv;
    }

//    /**
//     * @return mixed
//     */
//    public function getWork()
//    {
//        return $this->work;
//    }
//
//    /**
//     * @param mixed $work
//     */
//    public function setWork($work)
//    {
//        $this->work = $work;
//    }
//


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