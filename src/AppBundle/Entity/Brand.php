<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="brand")
 */
class Brand
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Racquet[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Racquet", mappedBy="brand")
     */
    private $racquets;

    /**
     * @var Dampener[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dampener", mappedBy="brand")
     */
    private $dampeners;

    /**
     * @var OverGrip[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OverGrip", mappedBy="brand")
     */
    private $overGrips;

    /**
     * Brand constructor
     */
    public function __construct()
    {
        $this->racquets = new ArrayCollection();
        $this->dampeners = new ArrayCollection();
        $this->overGrips = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Racquet[]|ArrayCollection
     */
    public function getRacquets()
    {
        return $this->racquets;
    }

    /**
     * @param Racquet[]|ArrayCollection $racquets
     * @return $this
     */
    public function setRacquets(ArrayCollection $racquets)
    {
        $this->racquets = $racquets;

        return $this;
    }

    /**
     * @return Dampener[]|ArrayCollection
     */
    public function getDampeners()
    {
        return $this->dampeners;
    }

    /**
     * @param Dampener[]|ArrayCollection $dampeners
     * @return $this
     */
    public function setDampeners(ArrayCollection $dampeners)
    {
        $this->dampeners = $dampeners;

        return $this;
    }

    /**
     * @return OverGrip[]|ArrayCollection
     */
    public function getOverGrips()
    {
        return $this->overGrips;
    }

    /**
     * @param OverGrip[]|ArrayCollection $overGrips
     * @return $this
     */
    public function setOverGrips(ArrayCollection $overGrips)
    {
        $this->overGrips = $overGrips;

        return $this;
    }
}
