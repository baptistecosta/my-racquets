<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
class RacquetBase
{
    /**
     * In grams
     *
     * @var int
     *
     * @ORM\Column(name="static_weight", type="integer")
     */
    protected $staticWeight;

    /**
     * In centimeters
     *
     * @var int
     *
     * @ORM\Column(name="head_size", type="integer")
     */
    protected $headSize;

    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="decimal", precision=4, scale=1)
     */
    protected $balance;

    /**
     * @var float
     *
     * @ORM\Column(name="length", type="decimal", precision=4, scale=1)
     */
    protected $length;

    /**
     * @var int
     *
     * @ORM\Column(name="stiffness", type="integer")
     */
    protected $stiffness;

    /**
     * @var float
     *
     * @ORM\Column(name="beam_width", type="decimal", precision=4, scale=1)
     */
    protected $beamWidth;

    /**
     * @var int
     *
     * @ORM\Column(name="swing_weight", type="integer", nullable=true)
     */
    protected $swingWeight;

    /**
     * @var int
     *
     * @ORM\Column(name="twist_weight", type="integer", nullable=true)
     */
    protected $twistWeight;

    /**
     * @var int
     *
     * @ORM\Column(name="recoil_weight", type="integer", nullable=true)
     */
    protected $recoilWeight;

    /**
     * @var float
     *
     * @ORM\Column(name="distance_to_top_string", type="decimal", precision=4, scale=1, nullable=true)
     */
    protected $distanceToTopString;

    /**
     * @var int
     *
     * @ORM\Column(name="release_year", type="integer", nullable=true)
     */
    protected $releaseYear;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", inversedBy="racquets")
     * @ORM\JoinColumn(name="brand_id")
     */
    protected $brand;

    /**
     * @var StringingPattern
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StringingPattern", inversedBy="raquets")
     * @ORM\JoinColumn(name="stringing_pattern_id")
     */
    protected $stringingPattern;

    /**
     * @return int
     */
    public function getStaticWeight()
    {
        return $this->staticWeight;
    }

    /**
     * @param int $staticWeight
     * @return $this
     */
    public function setStaticWeight($staticWeight)
    {
        $this->staticWeight = $staticWeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeadSize()
    {
        return $this->headSize;
    }

    /**
     * @param int $headSize
     * @return $this
     */
    public function setHeadSize($headSize)
    {
        $this->headSize = $headSize;

        return $this;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     * @return $this
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param float $length
     * @return $this
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return int
     */
    public function getStiffness()
    {
        return $this->stiffness;
    }

    /**
     * @param int $stiffness
     * @return $this
     */
    public function setStiffness($stiffness)
    {
        $this->stiffness = $stiffness;

        return $this;
    }

    /**
     * @return float
     */
    public function getBeamWidth()
    {
        return $this->beamWidth;
    }

    /**
     * @param float $beamWidth
     * @return $this
     */
    public function setBeamWidth($beamWidth)
    {
        $this->beamWidth = $beamWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function getSwingWeight()
    {
        return $this->swingWeight;
    }

    /**
     * @param int $swingWeight
     * @return $this
     */
    public function setSwingWeight($swingWeight)
    {
        $this->swingWeight = $swingWeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getTwistWeight()
    {
        return $this->twistWeight;
    }

    /**
     * @param int $twistWeight
     * @return $this
     */
    public function setTwistWeight($twistWeight)
    {
        $this->twistWeight = $twistWeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getRecoilWeight()
    {
        return $this->recoilWeight;
    }

    /**
     * @param int $recoilWeight
     * @return $this
     */
    public function setRecoilWeight($recoilWeight)
    {
        $this->recoilWeight = $recoilWeight;

        return $this;
    }

    /**
     * @return float
     */
    public function getDistanceToTopString()
    {
        return $this->distanceToTopString;
    }

    /**
     * @param float $distanceToTopString
     * @return $this
     */
    public function setDistanceToTopString($distanceToTopString)
    {
        $this->distanceToTopString = $distanceToTopString;

        return $this;
    }

    /**
     * @return int
     */
    public function getReleaseYear()
    {
        return $this->releaseYear;
    }

    /**
     * @param int $releaseYear
     * @return $this
     */
    public function setReleaseYear($releaseYear)
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return $this
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return StringingPattern
     */
    public function getStringingPattern()
    {
        return $this->stringingPattern;
    }

    /**
     * @param StringingPattern $stringingPattern
     * @return $this
     */
    public function setStringingPattern(StringingPattern $stringingPattern)
    {
        $this->stringingPattern = $stringingPattern;

        return $this;
    }
}
