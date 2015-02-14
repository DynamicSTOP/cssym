<?php

namespace WebApp\Entity;

use WebApp\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=15)
     */
    protected $lastIp;


    /**
     * @var string
     * @Column(type="string", length=30, unique=true)
     */
    protected $steamId;

    /**
     * @var string
     * @Column(type="string", length=20)
     */
    protected $role;

    /**
     * @Column(type="datetime")
     * @var DateTime
     * @Column(type="string", length=15)
     */
    protected $lastLoginDate;

    /**
     * $var string
     * @Column(type="string",length=40, unique=true)
     */
    protected $cookie;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $created;

    public function __construct($steamId=""){
        $this->created = new \DateTime();
        $this->lastLoginDate = new \DateTime();
        $this->role = "USER";
        $this->steamId=$steamId;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     * @return User
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set lastLoginDate
     *
     * @param \DateTime $lastLoginDate
     * @return User
     */
    public function setLastLoginDate($lastLoginDate)
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    /**
     * Get lastLoginDate
     *
     * @return \DateTime
     */
    public function getLastLoginDate()
    {
        return $this->lastLoginDate;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }


    /**
     * Set steamId
     *
     * @param string $steamId
     * @return User
     */
    public function setSteamId($steamId)
    {
        $this->steamId = $steamId;

        return $this;
    }

    /**
     * Get steamId
     *
     * @return string
     */
    public function getSteamId()
    {
        return $this->steamId;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set cookie
     *
     * @param string $cookie
     * @return User
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    /**
     * Get cookie
     *
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }
}