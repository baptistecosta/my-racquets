<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="racquet_model")
 */
class RacquetModel extends RacquetBase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Racquet[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Racquet", mappedBy="model")
     */
    protected $racquets;

    /**
     * RacquetModel constructor
     */
    public function __construct()
    {
        $this->racquets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Racquet[]|ArrayCollection
     */
    public function getRacquets()
    {
        return $this->racquets;
    }
}
