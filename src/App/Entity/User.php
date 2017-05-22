<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @author  Marius Adam
 */
class User extends Entity
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $role;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="30")
     *
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="20")
     *
     * @var string
     */
    private $username;
    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $password;
    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="18")
     *
     * @var int
     */
    private $age;
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string
     */
    private $email;
    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     * @Assert\Length(max="255")
     *
     * @var string
     */
    private $webPage;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
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
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getWebPage()
    {
        return $this->webPage;
    }

    /**
     * @param mixed $webPage
     */
    public function setWebPage($webPage)
    {
        $this->webPage = $webPage;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function isAdmin()
    {
        return $this->role !== null && $this->role == self::ROLE_ADMIN;
    }
}
