<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Via
 *
 * @ORM\Table(name="via", indexes={@ORM\Index(name="fk_grado", columns={"grade_id"}), @ORM\Index(name="boulder_id", columns={"boulder_id"})})
 * @ORM\Entity(repositoryClass="BackBundle\Repository\ViaRepository")
 */
class Via {

    const DIFFICULT_EASY = 1;
    const DIFFICULT_MEDIUM = 2;
    const DIFFICULT_HARD = 3;
    const DIFFICULT_SUPER = 4;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="orden", type="string", length=4, nullable=true)
     */
    private $order;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=500, nullable=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="draw", type="string", nullable=true, length=5000)
     */
    private $draw;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sit_start", type="boolean", nullable=false)
     */
    private $sitStart;

    /**
     * @var boolean
     *
     * @ORM\Column(name="jump", type="boolean", nullable=false)
     */
    private $jump;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expo", type="boolean", nullable=false)
     */
    private $expo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="featured", type="boolean", nullable=false)
     */
    private $featured;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackBundle\Entity\Boulder
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Boulder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="boulder_id", referencedColumnName="id")
     * })
     */
    private $boulder;

    /**
     * @var \BackBundle\Entity\Grado
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Grado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grade_id", referencedColumnName="id")
     * })
     */
    private $grade;

    /**
     * @ORM\OneToMany(targetEntity="Media", mappedBy="via")
     */
    private $medias;

    /**
     * @var \BackBundle\Entity\Boulder
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Via")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $parent;

    /**
     * @var \BackBundle\Entity\Boulder
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Via")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="start_at_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $startAt;

    /**
     * @var \BackBundle\Entity\Boulder
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Via")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="end_at_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $endAt;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Via
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
     * @param string $order
     *
     * @return Via
     */
    public function setOrder($order) {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return string
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Via
     */
    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Set sitStart
     *
     * @param boolean $sitStart
     *
     * @return Via
     */
    public function setSitStart($sitStart) {
        $this->sitStart = $sitStart;

        return $this;
    }

    /**
     * Get sitStart
     *
     * @return boolean
     */
    public function getSitStart() {
        return $this->sitStart;
    }

    /**
     * Set jump
     *
     * @param boolean $jump
     *
     * @return Via
     */
    public function setJump($jump) {
        $this->jump = $jump;

        return $this;
    }

    /**
     * Get jump
     *
     * @return boolean
     */
    public function getJump() {
        return $this->jump;
    }

    /**
     * Set expo
     *
     * @param boolean $expo
     *
     * @return Via
     */
    public function setExpo($expo) {
        $this->expo = $expo;

        return $this;
    }

    /**
     * Get expo
     *
     * @return boolean
     */
    public function getExpo() {
        return $this->expo;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     *
     * @return Via
     */
    public function setFeatured($featured) {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean
     */
    public function getFeatured() {
        return $this->featured;
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
     * Set boulder
     *
     * @param \BackBundle\Entity\Boulder $boulder
     *
     * @return Via
     */
    public function setBoulder(\BackBundle\Entity\Boulder $boulder = null) {
        $this->boulder = $boulder;

        return $this;
    }

    /**
     * Get boulder
     *
     * @return \BackBundle\Entity\Boulder
     */
    public function getBoulder() {
        return $this->boulder;
    }

    /**
     * Set grade
     *
     * @param \BackBundle\Entity\Grado $grade
     *
     * @return Via
     */
    public function setGrade(\BackBundle\Entity\Grado $grade = null) {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return \BackBundle\Entity\Grado
     */
    public function getGrade() {
        return $this->grade;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add media
     *
     * @param \BackBundle\Entity\Media $media
     *
     * @return Via
     */
    public function addMedia(\BackBundle\Entity\Media $media) {
        $this->medias[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param \BackBundle\Entity\Media $media
     */
    public function removeMedia(\BackBundle\Entity\Media $media) {
        $this->medias->removeElement($media);
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias() {
        return $this->medias;
    }

    public function getRealName() {
        if ($this->getName()) {
            return $this->getName();
        }
        return $this->getRealCode();
    }

    public function getRealCode() {
        $code = "";
        $code = $this->getBoulder()->getSector()->getZona()->getCode();
        $code .= $this->getBoulder()->getSector()->getCode();
        $code .= str_pad($this->getBoulder()->getOrder(), 2, "0", STR_PAD_LEFT);
        $code .= str_pad($this->getOrder(), 2, "0", STR_PAD_LEFT);
        return $code;
    }

    public function __toString() {
        return $this->getRealName();
    }

    public function getMediaImages() {
        $images = array();
        foreach ($this->getMedias() as $media) {
            if ($media->isImage()) {
                $images[] = $media;
            }
        }
        return $images;
    }

    public function getMediaVideos() {
        $videos = array();
        foreach ($this->getMedias() as $media) {
            if ($media->isVideo()) {
                $videos[] = $media;
            }
        }
        return $videos;
    }

    /**
     * Set draw
     *
     * @param string $draw
     *
     * @return Via
     */
    public function setDraw($draw) {
        $this->draw = $draw;

        return $this;
    }

    /**
     * Get draw
     *
     * @return string
     */
    public function getDraw() {
        return $this->draw;
    }

    /**
     * Set parent
     *
     * @param \BackBundle\Entity\Via $parent
     *
     * @return Via
     */
    public function setParent(\BackBundle\Entity\Via $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \BackBundle\Entity\Via
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set startAt
     *
     * @param \BackBundle\Entity\Via $startAt
     *
     * @return Via
     */
    public function setStartAt(\BackBundle\Entity\Via $startAt = null) {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \BackBundle\Entity\Via
     */
    public function getStartAt() {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \BackBundle\Entity\Via $endAt
     *
     * @return Via
     */
    public function setEndAt(\BackBundle\Entity\Via $endAt = null) {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \BackBundle\Entity\Via
     */
    public function getEndAt() {
        return $this->endAt;
    }

    public function getViasSameBoulderNotRelated() {
        $viasSameBoulderNotRelated = array();
        foreach ($this->getBoulder()->getVias() as $via) {
            if ($via->getId() != $this->getId() &&
                    (!$this->getParent() || $via->getId() != $this->getParent()->getId()) 
                    && (!$this->getEndAt() || $via->getId()!=$this->getEndAt()->getId())
                            &&  (!$this->getStartAt() || $via->getId()!=$this->getStartAt()->getId())) {
                $viasSameBoulderNotRelated[] = $via;
            }
        }
        return $viasSameBoulderNotRelated;
    }

}
