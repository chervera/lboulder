<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zona
 *
 * @ORM\Table(name="zona")
 * @ORM\Entity
 */
class Zona {

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=false)
     */
    private $order;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=200, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="introduction", type="string", length=500, nullable=false)
     */
    private $introduction;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, nullable=false)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Sector", mappedBy="zona")
     */
    private $sectors;

    public function __construct() {
        $this->sectors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Zona
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Zona
     */
    public function setOrder($order) {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Zona
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Zona
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
     * Set introduction
     *
     * @param string $introduction
     *
     * @return Zona
     */
    public function setIntroduction($introduction) {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string
     */
    public function getIntroduction() {
        return $this->introduction;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Zona
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Zona
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Add sector
     *
     * @param \BackBundle\Entity\Sector $sector
     *
     * @return Zona
     */
    public function addSector(\BackBundle\Entity\Sector $sector) {
        $this->sectors[] = $sector;

        return $this;
    }

    /**
     * Remove sector
     *
     * @param \BackBundle\Entity\Sector $sector
     */
    public function removeSector(\BackBundle\Entity\Sector $sector) {
        $this->sectors->removeElement($sector);
    }

    /**
     * Get sectors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSectors() {
        return $this->sectors;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return $this->getName();
    }

    public function getImgPath() {
        $path = $this->getSlug() . "/";
        if ($this->getImage()) {
            $path .= $this->getImage();
        } else {
            $path .= $this->getSlug() . ".jpg";
        }
        return $path;
    }

    public function getBoulderPoints() {
        $boulderPoints = array();
        foreach ($this->getSectors() as $sector) {
            foreach ($sector->getBoulders() as $boulder) {
                if ($boulder->isGeoposicioned()) {
                    $boulderPoints[] = array(0 => $boulder->getLatitudGPS(), 1 => $boulder->getLongitudGPS(), 2 => $boulder->getOrder());
                }
            }
        }
        return $boulderPoints;
    }

}
