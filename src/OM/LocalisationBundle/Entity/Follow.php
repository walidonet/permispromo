<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 29/01/2018
 * Time: 15:31
 */

namespace OM\LocalisationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;


/**
 *
 *
 * User
 * @ORM\Table(name="follow")
 * @ORM\Entity
 */
class Follow
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
 * @ORM\Column(type="datetime")
 */
    private $star;
    /**
     * @ORM\Column(type="datetime")
     */
    private $end;
    /**
     * @OneToOne(targetEntity="OM\AdministrationBundle\Entity\Meeting")
     * @JoinColumn(name="meeting_id", referencedColumnName="id")
     */
    private $meeting;
    /**
     * @ORM\OneToMany(targetEntity="OM\LocalisationBundle\Entity\Circuit", mappedBy="follow")
     */
    private $circuits;

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
    public function getStar()
    {
        return $this->star;
    }

    /**
     * @param mixed $star
     */
    public function setStar($star)
    {
        $this->star = $star;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getCircuits()
    {
        return $this->circuits;
    }

    /**
     * @param mixed $circuits
     */
    public function setCircuits($circuits)
    {
        $this->circuits = $circuits;
    }

    /**
     * @return mixed
     */
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * @param mixed $meeting
     */
    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;
    }
    



}