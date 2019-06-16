<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     *
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="senderid", type="integer")
     *
     *@Assert\Type("integer")
     */
    private $senderid;

    /**
     * @var int
     *
     * @ORM\Column(name="invitedid", type="integer")
     *
     *@Assert\Type("integer")
     */
    private $invitedid;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", options={"comment":"0:default, 1:accepted, 2:cancelled,3:deleted","default":0})
     *
     *@Assert\Choice({0, 1, 2, 3})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="invitation")
     * @ORM\JoinColumn(name="senderid", referencedColumnName="id")
     *
     *
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="invitation")
     * @ORM\JoinColumn(name="invitedid", referencedColumnName="id")
     *
     *
     */
    private $invited;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set senderid
     *
     * @param integer $senderid
     *
     * @return Invitation
     */
    public function setSenderid($senderid)
    {
        $this->senderid = $senderid;

        return $this;
    }

    /**
     * Get senderid
     *
     * @return int
     */
    public function getSenderid()
    {
        return $this->senderid;
    }

    /**
     * Set invitedid
     *
     * @param integer $invitedid
     *
     * @return Invitation
     */
    public function setInvitedid($invitedid)
    {
        $this->invitedid = $invitedid;

        return $this;
    }

    /**
     * Get invitedid
     *
     * @return int
     */
    public function getInvitedid()
    {
        return $this->invitedid;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Invitation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    //Relationship table
    public function getSender()
    {
        return $this->sender;
    }
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function getInvited()
    {
        return $this->invited;
    }
    public function setInvited($invited)
    {
        $this->invited = $invited;
    }
}

