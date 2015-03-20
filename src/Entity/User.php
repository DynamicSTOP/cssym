<?php

namespace WebApp\Entity;

use WebApp\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{

    const SUPERADMIN = "SUPERADMIN";
    const ADMIN = "ADMIN";
    const USER = "USER";

    //steam 2 weeks
    const MIN_REQUIRED_HOURS_2WEEKS = 5;
    //steam lifetime
    const MIN_REQUIRED_HOURS_LIFETIME = 1000;
    //server 2 weeks
    const MIN_REQUIRED_HOURS_2WEEKS_SERVER = 5;

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
     * @ManyToOne(targetEntity="UserRole")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     **/
    protected $role;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $lastLoginDate;

    /**
     * $var string
     * @Column(type="string",length=40, nullable=true)
     */
    protected $cookie;

    /**
     * $var string
     * @Column(type="string",length=200, nullable=true)
     */
    protected $avatar;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * @Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $lastCheckDate;

    /**
     * @Column(type="integer", nullable=true)
     * @var integer
     */
    protected $checkCounter;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $vacBanned;

    /**
     * @oneToMany(targetEntity="UserAdminRequest",mappedBy="user")
     * @var UserAdminRequest[]
     **/
    private $adminRequests = null;

    /**
     * @oneToMany(targetEntity="UserMapRequest",mappedBy="user")
     * @var UserMapRequest[]
     **/
    private $mapRequests = null;

    /**
     * @oneToMany(targetEntity="Topic",mappedBy="createdBy")
     * @var Topic[]
     **/
    private $createdTopics = null;

    const maxCheckCount = 2;

    public function __construct($steamId = "")
    {
        $this->created = new \DateTime();
        $this->lastLoginDate = new \DateTime();
        $this->lastCheckDate = new \DateTime("yesterday");
        $this->steamId = $steamId;
        $this->adminRequests = new ArrayCollection();
        $this->mapRequests = new ArrayCollection();
        $this->createdTopics = new ArrayCollection();
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
     * @return UserRole
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set vacBanned
     *
     * @param boolean $vacBanned
     * @return User
     */
    public function setVacBanned($vacBanned)
    {
        $this->vacBanned = $vacBanned;

        return $this;
    }

    /**
     * Get vacBanned
     *
     * @return boolean
     */
    public function getVacBanned()
    {
        return $this->vacBanned;
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

    /**
     * Set lastCheckDate
     *
     * @param \DateTime $lastCheckDate
     * @return User
     */
    public function setLastCheckDate($lastCheckDate)
    {
        $this->lastCheckDate = $lastCheckDate;

        return $this;
    }

    /**
     * Get lastCheckDate
     *
     * @return \DateTime
     */
    public function getLastCheckDate()
    {
        return $this->lastCheckDate;
    }

    /**
     * Set checkCounter
     *
     * @param integer $checkCounter
     * @return User
     */
    public function setCheckCounter($checkCounter)
    {
        $this->checkCounter = $checkCounter;

        return $this;
    }

    /**
     * Get checkCounter
     *
     * @return integer
     */
    public function getCheckCounter()
    {
        return $this->checkCounter;
    }

    public function getAdminRequests()
    {
        return $this->adminRequests;
    }

    public function addAdminRequest($adminRequest)
    {
        return $this->adminRequests[] = $adminRequest;
    }


    public function getMapRequests()
    {
        return $this->mapRequests;
    }

    public function addMapRequest($mapRequest)
    {
        return $this->mapRequests[] = $mapRequest;
    }

    public function getCreatedTopics()
    {
        return $this->createdTopics;
    }

    public function addCreatedTopic($topic)
    {
        return $this->createdTopics[] = $topic;
    }

    /**
     * updates info based on steam public info
     */
    public function updateFromSteam()
    {
        $doc = simplexml_load_file('http://steamcommunity.com/profiles/' . $this->steamId . '/?xml=1');
        if (!empty($doc)) {
            try {
                if ($this->steamId != $doc->steamID64)
                    throw new \Exception(" steam id dosen't match. Expected {$this->steamId} and got '{$doc->steamID64->__toString()}'");
                $this->name = $doc->steamID;
                $this->avatar = $doc->avatarIcon;
                $this->vacBanned = (int)$doc->vacBanned;

            } catch (\Exception $e) {
                error_log("Oops! Something is wrong in User Entity: " . $e->getMessage());
            }
        }
    }

    public function isTooManyChecks()
    {
        return $this->lastCheckDate->diff(new \DateTime())->days == 0 && $this->checkCounter > self::maxCheckCount;
    }

    /**
     * @param bool $updateCounter
     * @return UserAdminRequest or False
     */
    public function checkForAdmin($updateCounter = true)
    {
        $this->lastCheckDate = new \DateTime();

        if ($updateCounter)
            $this->checkCounter++;

        if ($this->getVacBanned())
            return false;

        //user could catch a VAC ban after last login
        $this->updateFromSteam();
        if ($this->getVacBanned())
            return false;

        $adminRequest = new UserAdminRequest();
        $adminRequest->setUser($this);

        $url = "http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key={$_SERVER['STEAM_APIKEY']}&steamid={$this->steamId}&format=json";

        $data = file_get_contents($url);
        if (empty($data) || $data === FALSE) {
            //this shouldn't happen and it's not user fault so i should remove attempt
            $this->checkCounter--;
            //TODO may be i should place it in some kinda of cron job later?
            return false;
        }

        $json = json_decode($data);
        if (empty($json) || $json === FALSE) {
            //and again check for bad data
            $this->checkCounter--;
            //TODO may be i should place it in some kinda of cron job later?
            return false;
        }

        if (!isset($json->response->games))
            return $adminRequest;

        // appid is 730, let's search for it!
        foreach ($json->response->games as $game) {
            if (intval($game->appid) == 730) {
                //steam return values in minutes btw
                //TODO check playtime on our server! but this one is good too ^^
                if (intval($game->playtime_2weeks) >= 60 * self::MIN_REQUIRED_HOURS_2WEEKS && intval($game->playtime_forever) >= 60 * self::MIN_REQUIRED_HOURS_LIFETIME) {
                    $adminRequest->setValidated(true);
                } else {
                    $adminRequest->setOpened(false);
                }
            }
        }

        return $adminRequest;
    }


    public function checkAccess($requestedRoleName)
    {

    }
}