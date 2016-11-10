<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="racquet")
 */
class Racquet
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
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", inversedBy="raquets")
     * @ORM\JoinColumn(name="brand_id")
     */
    private $brand;

    /**
     * In grams
     *
     * @var int
     *
     * @ORM\Column(name="static_weight", type="integer")
     */
    private $staticWeight;

    /**
     * In centimeters
     *
     * @var int
     *
     * @ORM\Column(name="head_size", type="integer")
     */
    private $headSize;

    /**
     * @var StringingPattern
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StringingPattern", inversedBy="raquets")
     * @ORM\JoinColumn(name="stringing_pattern_id")
     */
    private $stringingPattern;

    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="decimal", precision=4, scale=1)
     */
    private $balance;

    /**
     * @var RacquetString
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RacquetString", inversedBy="raquets")
     * @ORM\JoinColumn(name="strings_id")
     */
    private $string;

    /**
     * @var Dampener
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dampener", inversedBy="raquets")
     * @ORM\JoinColumn(name="dampener_id")
     */
    private $dampener;

    /**
     * @var OverGrip
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OverGrip", inversedBy="raquets")
     * @ORM\JoinColumn(name="over_grip_id")
     */
    private $overGrip;

    /**
     * @var float
     *
     * @ORM\Column(name="distance_to_top_string", type="decimal", precision=4, scale=1)
     */
    private $distanceToTopString;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="racquets")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private $user;
}