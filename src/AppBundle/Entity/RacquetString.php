<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="racquet_string")
 */
class RacquetString
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var RacquetStringType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RacquetStringType", inversedBy="strings")
     * @ORM\JoinColumn(name="string_type_id")
     */
    private $type;

    /**
     * @var Racquet[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Racquet", mappedBy="string")
     */
    private $raquets;

    /**
     * @return string
     */
    function __toString()
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
     * @return RacquetStringType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param RacquetStringType $type
     * @return $this
     */
    public function setType(RacquetStringType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Racquet[]|ArrayCollection
     */
    public function getRaquets()
    {
        return $this->raquets;
    }

    /**
     * @param Racquet[]|ArrayCollection $raquets
     * @return $this
     */
    public function setRaquets(ArrayCollection $raquets)
    {
        $this->raquets = $raquets;

        return $this;
    }
}
