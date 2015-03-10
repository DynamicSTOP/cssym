<?php
namespace WebApp\Entity;

use WebApp\Entity;
use Doctrine\ORM\Mapping;

/**
* @Entity
* @Table(name="adminRequests")
*/
class UserAdminRequest{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="adminRequests")
     **/
    protected $user;

    /**
     * @Column(type="datetime")
     * @var DateTime
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
    protected $granted;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $validated;

    public function __construct(){
        $this->created = new \DateTime();
        $this->opened=1;
        $this->granted=0;
        $this->validated=0;
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
     * @return UserAdminRequest
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
     * @return UserAdminRequest
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
     * Set granted
     *
     * @param boolean $granted
     * @return UserAdminRequest
     */
    public function setGranted($granted)
    {
        $this->granted = $granted;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return UserAdminRequest
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get granted
     *
     * @return boolean
     */
    public function getGranted()
    {
        return $this->granted;
    }

    /**
     * Set user
     *
     * @param \WebApp\Entity\User $user
     * @return UserAdminRequest
     */
    public function setUser(\WebApp\Entity\User $user = null)
    {
        $this->user = $user;
        $user->addAdminRequest($this);
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