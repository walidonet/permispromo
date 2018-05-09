<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 29/01/2018
 * Time: 15:50
 */

namespace OM\AdministrationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * User
 * @ORM\Table(name="meeting")
 * @ORM\Entity
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="date" )
     */
    private $day;
    /**
     * @ORM\Column(type="time" )
     */
    private $star;
    /**
     * @ORM\Column(type="time")
     */
    private $end;
    /**
     * @ORM\ManyToOne(targetEntity="OM\EspaceUserBundle\Entity\User", inversedBy="meetings")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
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
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
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