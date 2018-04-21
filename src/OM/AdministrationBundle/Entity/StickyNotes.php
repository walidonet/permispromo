<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21/04/2018
 * Time: 09:35
 */

namespace OM\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="sticky_notes")
 * @ORM\Entity
 */
class StickyNotes
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
    private $notes ;

    /**
     * @ORM\ManyToOne(targetEntity="OM\EspaceUserBundle\Entity\User",inversedBy="id",cascade={"persist", "merge", "remove"})
     */
    private $agent;

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
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }


    /**
     * @return mixed
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param mixed $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }





}