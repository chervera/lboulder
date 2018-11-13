<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grado
 *
 * @ORM\Table(name="grado")
 * @ORM\Entity
 */
class Grado {

    const EASY_GRADE = 11;
    const MEDIUM_GRADE = 17;
    const HARD_GRADE = 23;
    const EASY_COLOR = "easy";
    const MEDIUM_COLOR = "meddium";
    const HARD_COLOR = "hard";
    const SUPER_COLOR = "super";

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=10, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Grado
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

    public function isEasy() {
        if ($this->getId() < self::EASY_GRADE) {
            return true;
        }
        return false;
    }

    public function isMedium() {
        if ($this->getId() >= self::EASY_GRADE && $this->getId() < self::MEDIUM_GRADE) {
            return true;
        }
        return false;
    }

    public function isHard() {
        if ($this->getId() >= self::MEDIUM_GRADE && $this->getId() < self::HARD_GRADE) {
            return true;
        }
        return false;
    }

    public function isSuper() {
        if ($this->getId() >= self::HARD_GRADE) {
            return true;
        }
        return false;
    }

    public function getDifficultColor() {
        if ($this->isEasy()) {
            return self::EASY_COLOR;
        }

        if ($this->isMedium()) {
            return self::MEDIUM_COLOR;
        }

        if ($this->isHard()) {
            return self::HARD_COLOR;
        }

        return self::SUPER_COLOR;
    }

}
