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
    private $raquets;

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
}