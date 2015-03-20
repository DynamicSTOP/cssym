<?php

namespace WebApp\Entity;

use WebApp\Entity;
use Doctrine\ORM\Mapping;
use DoctrineExtensions\NestedSet\Node;

/**
 * @Entity
 * @Table(name="userRoles")
 */
class UserRole implements Node
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
     * @Column(type="string", length=64, unique=true)
     */
    protected $role;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $createdAt;

    function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @Column(type="integer")
     */
    private $lft;

    /**
     * @Column(type="integer")
     */
    private $rgt;


    public function getId()
    {
        return $this->id;
    }

    public function getLeftValue()
    {
        return $this->lft;
    }

    public function setLeftValue($lft)
    {
        $this->lft = $lft;
    }

    public function getRightValue()
    {
        return $this->rgt;
    }

    public function setRightValue($rgt)
    {
        $this->rgt = $rgt;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = trim(strtoupper($role));
    }

    public function __toString()
    {
        return $this->role;
    }
}