<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media", indexes={@ORM\Index(name="fk_vias", columns={"via_id"})})
 * @ORM\Entity
 */
class Media {

    const TYPE_IMAGE = 1;
    const TYPE_VIDEO = 2;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=false)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="embed", type="string", length=4000, nullable=true)
     */
    private $embed;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackBundle\Entity\Via
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Via")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="via_id", referencedColumnName="id")
     * })
     */
    private $via;

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Media
     */
    public function setAlt($alt) {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt() {
        return $this->alt;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Media
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set embed
     *
     * @param string $embed
     *
     * @return Media
     */
    public function setEmbed($embed) {
        $this->embed = $embed;

        return $this;
    }

    /**
     * Get embed
     *
     * @return string
     */
    public function getEmbed() {
        return $this->embed;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Media
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set via
     *
     * @param \BackBundle\Entity\Via $via
     *
     * @return Media
     */
    public function setVia(\BackBundle\Entity\Via $via = null) {
        $this->via = $via;

        return $this;
    }

    /**
     * Get via
     *
     * @return \BackBundle\Entity\Via
     */
    public function getVia() {
        return $this->via;
    }

    public function isImage() {
        if ($this->getType() == self::TYPE_IMAGE) {
            return true;
        }

        return false;
    }
    
    public function isVideo() {
        if ($this->getType() == self::TYPE_VIDEO) {
            return true;
        }

        return false;
    }

}
