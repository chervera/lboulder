<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sector
 *
 * @ORM\Table(name="sector", indexes={@ORM\Index(name="fk_zona", columns={"zona_id"})})
 * @ORM\Entity(repositoryClass="BackBundle\Repository\SectorRepository")
 */
class Sector {

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=true)
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
     * @ORM\Column(name="comments", type="string", length=500, nullable=false)
     */
    private $comments;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="map", type="string", length=500, nullable=true)
     */
    private $map;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="latitud_1_gps", type="string", length=50, nullable=true)
     */
    private $latitud1GPS;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud_1_gps", type="string", length=50, nullable=true)
     */
    private $longitud1GPS;

    /**
     * @var string
     *
     * @ORM\Column(name="latitud_2_gps", type="string", length=50, nullable=true)
     */
    private $latitud2GPS;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud_2_gps", type="string", length=50, nullable=true)
     */
    private $longitud2GPS;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackBundle\Entity\Zona
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Zona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zona_id", referencedColumnName="id")
     * })
     */
    private $zona;

    /**
     * @ORM\OneToMany(targetEntity="Boulder", mappedBy="sector")
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $boulders;

    public function __construct() {
        $this->boulders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Sector
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
     * @return Sector
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
     * @return Sector
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
     * @return Sector
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
     * Set comments
     *
     * @param string $comments
     *
     * @return Sector
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Sector
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
     * Set map
     *
     * @param string $map
     *
     * @return Sector
     */
    public function setMap($map) {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return string
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Sector
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set zona
     *
     * @param \BackBundle\Entity\Zona $zona
     *
     * @return Sector
     */
    public function setZona(\BackBundle\Entity\Zona $zona = null) {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return \BackBundle\Entity\Zona
     */
    public function getZona() {
        return $this->zona;
    }

    /**
     * Add boulder
     *
     * @param \BackBundle\Entity\Boulder $boulder
     *
     * @return Sector
     */
    public function addBoulder(\BackBundle\Entity\Boulder $boulder) {
        $this->boulders[] = $boulder;

        return $this;
    }

    /**
     * Remove boulder
     *
     * @param \BackBundle\Entity\Boulder $boulder
     */
    public function removeBoulder(\BackBundle\Entity\Boulder $boulder) {
        $this->boulders->removeElement($boulder);
    }

    /**
     * Get boulders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBoulders() {
        return $this->boulders;
    }

    public function __toString() {
        return $this->getName();
    }

    public function getNumberRoutesByDificult($difficult) {
        $counter = 0;
        if ($difficult == Via::DIFFICULT_EASY) {
            foreach ($this->getBoulders() as $boulder) {
                $counter += $boulder->getNumberEasyRoutes();
            }
        }
        if ($difficult == Via::DIFFICULT_MEDIUM) {
            foreach ($this->getBoulders() as $boulder) {
                $counter += $boulder->getNumberMediumRoutes();
            }
        }
        if ($difficult == Via::DIFFICULT_HARD) {
            foreach ($this->getBoulders() as $boulder) {
                $counter += $boulder->getNumberHardRoutes();
            }
        }
        if ($difficult == Via::DIFFICULT_SUPER) {
            foreach ($this->getBoulders() as $boulder) {
                $counter += $boulder->getNumberSuperRoutes();
            }
        }
        return $counter;
    }

    public function getNumberEasyRoutes() {
        return $this->getNumberRoutesByDificult(Via::DIFFICULT_EASY);
    }

    public function getNumberMediumRoutes() {
        return $this->getNumberRoutesByDificult(Via::DIFFICULT_MEDIUM);
    }

    public function getNumberHardRoutes() {
        return $this->getNumberRoutesByDificult(Via::DIFFICULT_HARD);
    }

    public function getNumberSuperRoutes() {
        return $this->getNumberRoutesByDificult(Via::DIFFICULT_SUPER);
    }

    public function getNumberTotalRoutes() {
        $counter = 0;
        foreach ($this->getBoulders() as $boulder) {
            $counter += count($boulder->getVias());
        }
        return $counter;
    }

    public function getImgPath() {
        $path = $this->getZona()->getSlug() . "/" . $this->getSlug() . "/";
        if ($this->getImage()) {
            $path .= $this->getImage();
        } else {
            $path .= $this->getSlug() . ".jpg";
        }
        return $path;
    }

    public function getFullCode() {
        return $this->getZona()->getCode() . $this->getCode();
    }

    /**
     * Set latitud1GPS
     *
     * @param string $latitud1GPS
     *
     * @return Boulder
     */
    public function setLatitud1GPS($latitud1GPS) {
        $this->latitud1GPS = $latitud1GPS;

        return $this;
    }

    /**
     * Get latitud1GPS
     *
     * @return string
     */
    public function getLatitud1GPS() {
        return $this->latitud1GPS;
    }

    /**
     * Set longitud1GPS
     *
     * @param string $longitud1GPS
     *
     * @return Boulder
     */
    public function setLongitud1GPS($longitud1GPS) {
        $this->longitud1GPS = $longitud1GPS;

        return $this;
    }

    /**
     * Get longitud1GPS
     *
     * @return string
     */
    public function getLongitud1GPS() {
        return $this->longitud1GPS;
    }

    /**
     * Set latitud2GPS
     *
     * @param string $latitud2GPS
     *
     * @return Boulder
     */
    public function setLatitud2GPS($latitud2GPS) {
        $this->latitud2GPS = $latitud2GPS;

        return $this;
    }

    /**
     * Get latitud2GPS
     *
     * @return string
     */
    public function getLatitud2GPS() {
        return $this->latitud2GPS;
    }

    /**
     * Set longitud2GPS
     *
     * @param string $longitud2GPS
     *
     * @return Boulder
     */
    public function setLongitud2GPS($longitud2GPS) {
        $this->longitud2GPS = $longitud2GPS;

        return $this;
    }

    /**
     * Get longitud2GPS
     *
     * @return string
     */
    public function getLongitud2GPS() {
        return $this->longitud2GPS;
    }

    public function setLatLng1($latlng) {
        $this->setLatitud1GPS($latlng['lat']);
        $this->setLongitud1GPS($latlng['lng']);
        return $this;
    }

    public function getLatLng1() {
        return array('lat' => $this->getLatitud1GPS(), 'lng' => $this->getLongitud1GPS());
    }
    
     public function setLatLng2($latlng) {
        $this->setLatitud2GPS($latlng['lat']);
        $this->setLongitud2GPS($latlng['lng']);
        return $this;
    }

    public function getLatLng2() {
        return array('lat' => $this->getLatitud2GPS(), 'lng' => $this->getLongitud2GPS());
    }

    const GEO_ZONES_ONLY_BOULDERS = 1;
    const GEO_ZONES_BOULDERS_PARKING_1 = 2;
    const GEO_ZONES_BOULDERS_PARKING_2 = 3;
    const GEO_ZONES_ALL = 4;

    public function getGeopositionPointsZones($filter = self::GEO_ZONES_ALL) {
        $geopositionPoints = array();

        foreach ($this->getBoulders() as $boulder) {
            if ($boulder->getLatitudGPS() && $boulder->getLongitudGPS()) {
                        $geopositionPoints[] = [$boulder->getLatitudGPS(), $boulder->getLongitudGPS(), $boulder->getOrder()];
            }
        }

        if ($filter == self::GEO_ZONES_ALL || $filter == self::GEO_ZONES_BOULDERS_PARKING_1) {
            if ($this->getLatitud1GPS() && $this->getLongitud1GPS()) {
                $geopositionPoints[] = [$this->getLatitud1GPS(), $this->getLongitud1GPS(), "P1"];
            }
        }

        if ($filter == self::GEO_ZONES_ALL || $filter == self::GEO_ZONES_BOULDERS_PARKING_2) {
            if ($this->getLatitud2GPS() && $this->getLongitud2GPS()) {
                $geopositionPoints[] = [$this->getLatitud2GPS(), $this->getLongitud2GPS(), "P2"];
            }
        }

        return $geopositionPoints;
    }

}
