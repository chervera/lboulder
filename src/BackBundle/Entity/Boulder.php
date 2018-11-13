<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Boulder
 *
 * @ORM\Table(name="boulder", indexes={@ORM\Index(name="sector_id", columns={"sector_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Boulder {

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
     * @ORM\Column(name="image", type="string", length=200, nullable=true)
     */
    private $image;

    /**
     * 
     * @Vich\UploadableField(mapping="boulder_image", fileNameProperty="image")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="latitud_gps", type="string", length=50, nullable=true)
     */
    private $latitudGPS;

    /**
     * @var string
     *
     * @ORM\Column(name="longitud_gps", type="string", length=50, nullable=true)
     */
    private $longitudGPS;

    public function setLatLng($latlng) {
        $this->setLatitudGPS($latlng['lat']);
        $this->setLongitudGPS($latlng['lng']);
        return $this;
    }

    public function getLatLng() {
        return array('lat' => $this->getLatitudGPS(), 'lng' => $this->getLongitudGPS());
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackBundle\Entity\Sector
     *
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Sector")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sector_id", referencedColumnName="id")
     * })
     */
    private $sector;

    /**
     * @ORM\OneToMany(targetEntity="Via", mappedBy="boulder")
     */
    private $vias;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Boulder
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
     * @return Boulder
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
     * @return Boulder
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
     * @return Boulder
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set sector
     *
     * @param \BackBundle\Entity\Sector $sector
     *
     * @return Boulder
     */
    public function setSector(\BackBundle\Entity\Sector $sector = null) {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \BackBundle\Entity\Sector
     */
    public function getSector() {
        return $this->sector;
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->vias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add via
     *
     * @param \BackBundle\Entity\Via $via
     *
     * @return Boulder
     */
    public function addVia(\BackBundle\Entity\Via $via) {
        $this->vias[] = $via;

        return $this;
    }

    /**
     * Remove via
     *
     * @param \BackBundle\Entity\Via $via
     */
    public function removeVia(\BackBundle\Entity\Via $via) {
        $this->vias->removeElement($via);
    }

    /**
     * Get vias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVias() {
        return $this->vias;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getImageDirectoryPath() {
        $path = $this->getSector()->getZona()->getSlug() . "/" . $this->getSector()->getSlug() . "/";
        return $path;
    }

    public function getImageFullPath() {
        return $this->getImageDirectoryPath() . $this->getImage();
    }

    public function getNumberRoutesByDificult($difficult) {
        $counter = 0;
        foreach ($this->getVias() as $via) {
            if ($difficult == Via::DIFFICULT_EASY && $via->getGrade()->isEasy()) {
                $counter += 1;
            }
            if ($difficult == Via::DIFFICULT_MEDIUM && $via->getGrade()->isMedium()) {
                $counter += 1;
            }
            if ($difficult == Via::DIFFICULT_HARD && $via->getGrade()->isHard()) {
                $counter += 1;
            }
            if ($difficult == Via::DIFFICULT_SUPER && $via->getGrade()->isSuper()) {
                $counter += 1;
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

    public function getImgPath() {
        $path = $this->getSector()->getZona()->getSlug() . "/" . $this->getSector()->getSlug() . "/";
        if ($this->getImage()) {
            $path .= $this->getImage();
        } else {
            $path .= $this->getSlug() . ".jpg";
        }
        return $path;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Boulder
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set latitudGPS
     *
     * @param string $latitudGPS
     *
     * @return Boulder
     */
    public function setLatitudGPS($latitudGPS) {
        $this->latitudGPS = $latitudGPS;

        return $this;
    }

    /**
     * Get latitudGPS
     *
     * @return string
     */
    public function getLatitudGPS() {
        return $this->latitudGPS;
    }

    /**
     * Set longitudGPS
     *
     * @param string $longitudGPS
     *
     * @return Boulder
     */
    public function setLongitudGPS($longitudGPS) {
        $this->longitudGPS = $longitudGPS;

        return $this;
    }

    /**
     * Get longitudGPS
     *
     * @return string
     */
    public function getLongitudGPS() {
        return $this->longitudGPS;
    }

    public function isGeoposicioned() {
        if ($this->getLatitudGPS() && $this->getLongitudGPS()) {
            return true;
        }
        return false;
    }

}
