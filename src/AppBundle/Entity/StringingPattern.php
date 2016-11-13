<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="stringing_pattern")
 */
class StringingPattern
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
     * @var int
     *
     * @ORM\Column(name="mains", type="integer")
     */
    private $mains;

    /**
     * @var int
     *
     * @ORM\Column(name="crosses", type="integer")
     */
    private $crosses;

    /**
     * @var Racquet[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Racquet", mappedBy="stringingPattern")
     */
    private $racquets;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMains()
    {
        return $this->mains;
    }

    /**
     * @param int $mains
     * @return $this
     */
    public function setMains($mains)
    {
        $this->mains = $mains;

        return $this;
    }

    /**
     * @return int
     */
    public function getCrosses()
    {
        return $this->crosses;
    }

    /**
     * @param int $crosses
     * @return $this
     */
    public function setCrosses($crosses)
    {
        $this->crosses = $crosses;

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
}
