<?php

namespace WebApp\Entity;

use DoctrineExtensions\NestedSet\Node;
use WebApp\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="topics")
 */
class Topic
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
     * @JoinColumn(name="roleToChat_id", referencedColumnName="id")
     **/
    private $roleToChat;

    /**
     * @ManyToOne(targetEntity="UserRole")
     * @JoinColumn(name="roleToView_id", referencedColumnName="id")
     **/
    private $roleToView;

    /**
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $category;

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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}