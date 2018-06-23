<?php

namespace MAGMA\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="MAGMA\AppBundle\Repository\MessageRepository")
 */
class Message {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="string", length=255, nullable=true)
     */
    private $texte;

    /**
     * @ORM\ManyToOne(targetEntity="MAGMA\AppBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="MAGMA\AppBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $destinateur;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Message
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
     * Set texte
     *
     * @param string $texte
     *
     * @return Message
     */
    public function setTexte($texte) {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte() {
        return $this->texte;
    }


    /**
     * Set source
     *
     * @param \MAGMA\AppBundle\Entity\User $source
     *
     * @return Message
     */
    public function setSource(\MAGMA\AppBundle\Entity\User $source = null)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return \MAGMA\AppBundle\Entity\User
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set destinateur
     *
     * @param \MAGMA\AppBundle\Entity\User $destinateur
     *
     * @return Message
     */
    public function setDestinateur(\MAGMA\AppBundle\Entity\User $destinateur = null)
    {
        $this->destinateur = $destinateur;

        return $this;
    }

    /**
     * Get destinateur
     *
     * @return \MAGMA\AppBundle\Entity\User
     */
    public function getDestinateur()
    {
        return $this->destinateur;
    }
}
