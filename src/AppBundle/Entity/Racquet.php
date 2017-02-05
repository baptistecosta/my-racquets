<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="racquet")
 */
class Racquet extends RacquetBase
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
     * @var RacquetModel
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RacquetModel", inversedBy="racquets")
     * @ORM\JoinColumn(name="model_id")
     */
    protected $model;

    /**
     * @var RacquetString
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RacquetString", inversedBy="raquets")
     * @ORM\JoinColumn(name="strings_id")
     */
    protected $string;

    /**
     * @var Dampener
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dampener", inversedBy="raquets")
     * @ORM\JoinColumn(name="dampener_id")
     */
    protected $dampener;

    /**
     * @var OverGrip
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OverGrip", inversedBy="racquets")
     * @ORM\JoinColumn(name="over_grip_id")
     */
    protected $overGrip;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="racquets")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    protected $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return RacquetModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param RacquetModel $model
     * @return $this
     */
    public function setModel(RacquetModel $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return RacquetString
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @param RacquetString $string
     * @return $this
     */
    public function setString(RacquetString $string = null)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @return Dampener
     */
    public function getDampener()
    {
        return $this->dampener;
    }

    /**
     * @return string
     */
    public function getDampenerName()
    {
        return $this->getDampener() ? $this->getDampener()->getName() : '';
    }

    /**
     * @param Dampener $dampener
     * @return $this
     */
    public function setDampener(Dampener $dampener = null)
    {
        $this->dampener = $dampener;

        return $this;
    }

    /**
     * @return OverGrip
     */
    public function getOverGrip()
    {
        return $this->overGrip;
    }

    /**
     * @param OverGrip $overGrip
     * @return $this
     */
    public function setOverGrip(OverGrip $overGrip = null)
    {
        $this->overGrip = $overGrip;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
