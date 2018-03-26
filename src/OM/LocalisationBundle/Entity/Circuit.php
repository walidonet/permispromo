<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 29/01/2018
 * Time: 14:28
 */

namespace OM\LocalisationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * User
 * @ORM\Table(name="circuit")
 * @ORM\Entity
 */
class Circuit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    private $longitude = "";
    /**
     * @ORM\Column(type="string")
     */
    private $latitude = "";

    /**
     * @ORM\ManyToOne(targetEntity="OM\LocalisationBundle\Entity\Follow", inversedBy="circuits")
     * @ORM\JoinColumn(name="follow_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $follow;

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
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getFollow()
    {
        return $this->follow;
    }

    /**
     * @param mixed $follow
     */
    public function setFollow($follow)
    {
        $this->follow = $follow;
    }



}