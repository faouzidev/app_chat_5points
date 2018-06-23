<?php

namespace MAGMA\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="MAGMA\AppBundle\Repository\NotificationRepository")
 */
class Notification {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user", type="integer", nullable=true)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var equipement
     *
     * @ORM\Column(name="equipement", type="integer", nullable=true)
     */
    private $equipement;
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var float
     *
     * @ORM\Column(name="view", type="float", nullable=true)
     */
    private $view = 0;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return Notification
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Notification
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Notification
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set view
     *
     * @param float $view
     *
     * @return Notification
     */
    public function setView($view) {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return float
     */
    public function getView() {
        return $this->view;
    }


    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set equipement
     *
     * @param integer $equipement
     *
     * @return Notification
     */
    public function setEquipement($equipement)
    {
        $this->equipement = $equipement;

        return $this;
    }

    /**
     * Get equipement
     *
     * @return integer
     */
    public function getEquipement()
    {
        return $this->equipement;
    }
}
