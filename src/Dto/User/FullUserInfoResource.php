<?php

namespace App\Dto\User;

class FullUserInfoResource
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var mixed
     */
    private $username;

    /**
     * @var mixed
     */
    private $pointsAmount;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return FullUserInfoResource
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return FullUserInfoResource
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPointsAmount()
    {
        return $this->pointsAmount;
    }

    /**
     * @param mixed $pointsAmount
     *
     * @return FullUserInfoResource
     */
    public function setPointsAmount($pointsAmount)
    {
        $this->pointsAmount = $pointsAmount;
        return $this;
    }
}