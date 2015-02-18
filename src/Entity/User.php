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
     * @var DateTime
     */
    protected $created;

    /**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
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

    public function __construct($steamId=""){
        $this->created = new \DateTime();
        $this->lastLoginDate = new \DateTime();
        $this->lastCheckDate = new \DateTime("yesterday");
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

    /**
     * updates info based on steam public info
     */
    public function updateFromSteam(){
        $doc = simplexml_load_file('http://steamcommunity.com/profiles/'.$this->steamId.'/?xml=1');
        if(!empty($doc)){
            try{
                if($this->steamId!=$doc->steamID64->__toString())
                    throw new \Exception(" steam id dosen't match. Expected {$this->steamId} and got '{$doc->steamID64->__toString()}'");
                $this->name = $doc->steamID->__toString();
                $this->avatar = $doc->avatarIcon->__toString();
                $this->vacBanned = (int)$doc->vacBanned->__toString();

            } catch (\Exception $e){
                error_log("Oops! Something is wrong in User Entity: ".$e->getMessage());
            }
        }
    }

    public function isTooManyChecks(){
        return $this->lastCheckDate->diff(new \DateTime())->days==0 && $this->checkCounter>200;
    }

    /**
     *
     */
    public function checkForAdmin($updateCounter=true){
        $this->lastCheckDate = new \DateTime('-1 day');
        if($updateCounter)
            $this->checkCounter++;

        if($this->getVacBanned())
            return false;
        $this->updateFromSteam();
        //user could catch a VAC ban after last login
        if($this->getVacBanned())
            return false;

        //and here we should use steam web api...

        die();
        $url='https://steamcommunity.com/profiles/'.$this->steamId.'/games/?xml=1';

        $doc = simplexml_load_file($url);

        if(!empty($doc)){
            try{

                foreach($doc->games as $game){
                    var_dump($game);
                }

            }catch(\Exception $e){
                return false;
            }
        }
    }
}