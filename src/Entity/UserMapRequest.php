<?php
namespace WebApp\Entity;

use WebApp\Entity;
use Doctrine\ORM\Mapping;

/**
* @Entity
* @Table(name="mapRequests")
*/
class UserMapRequest{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="mapRequests")
     **/
    protected $user;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $opened;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $added;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $mapName;

    /**
     * @var string
     * @Column(type="string", length=256)
     */
    protected $workshopLink;

    public function __construct(){
        $this->created = new \DateTime();
        $this->opened=1;
        $this->added=0;
        $this->workshopLink='';
        $this->mapName='';
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
     * Set created
     *
     * @param \DateTime $created
     * @return UserMapRequest
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
     * Set opened
     *
     * @param boolean $opened
     * @return UserMapRequest
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;

        return $this;
    }

    /**
     * Get opened
     *
     * @return boolean
     */
    public function getOpened()
    {
        return $this->opened;
    }


    /**
     * Get added
     *
     * @return boolean
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set added
     *
     * @param boolean $added
     * @return UserMapRequest
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get workshopLink
     *
     * @return boolean
     */
    public function getWorkshopLink()
    {
        return $this->workshopLink;
    }

    /**
     * Set workshopLink
     *
     * @param string $workshopLink
     * @return UserMapRequest
     */
    public function setWorkshopLink($workshopLink)
    {
        $this->workshopLink = $workshopLink;

        return $this;
    }

    /**
     * Get mapName
     *
     * @return boolean
     */
    public function getMapName()
    {
        return $this->mapName;
    }

    /**
     * Set mapName
     *
     * @param string $mapName
     * @return UserMapRequest
     */
    public function setMapName($mapName)
    {
        $this->mapName = $mapName;

        return $this;
    }

    /**
     * Set user
     *
     * @param \WebApp\Entity\User $user
     * @return UserMapRequest
     */
    public function setUser(\WebApp\Entity\User $user = null)
    {
        $this->user = $user;
        $user->addMapRequest($this);
        return $this;
    }

    /**
     * Get user
     *
     * @return \WebApp\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}