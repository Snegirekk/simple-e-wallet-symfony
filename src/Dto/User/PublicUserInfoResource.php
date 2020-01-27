<?php

namespace App\Dto\User;

class PublicUserInfoResource
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return PublicUserInfoResource
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
     * @return PublicUserInfoResource
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
}