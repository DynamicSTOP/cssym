<?php

namespace WebApp\Entity;

use DoctrineExtensions\NestedSet\Node;
use WebApp\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="categories")
 */
class Category implements Node
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
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $createdAt;


    /**
     * @ManyToOne(targetEntity="User", inversedBy="createdTopics")
     **/
    protected $createdBy;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $title;

    /**
     * @ManyToOne(targetEntity="UserRole")
     * @JoinColumn(name="roleToCreateTopics_id", referencedColumnName="id")
     **/
    private $roleToCreateTopics;

    /**
     * @ManyToOne(targetEntity="UserRole")
     * @JoinColumn(name="roleToViewTopics_id", referencedColumnName="id")
     **/
    private $roleToViewTopics;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $sticky;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $locked;


    function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->locked = false;
        $this->sticky = false;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function __toString()
    {
        return $this->title;
    }
}
