<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="vuser")
 * @readyOnly
 */

class Vuser
{

    /**
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     * @readOnly
     */
    private $id;


    /**
     * @Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;
	
	/**
	 * @Column("active", type="integer", nullable=false)
	 */
	private $active;
	
	/**
	 * @Column("login_default", type="integer", nullable=false)
	 */
	private $loginDefault;
	
	
	/**
	 * @Column("event_id", type="integer", nullable=false)
	 */
	private $eventId;
	
	
	/**
	 * @Column(name="profile", type="string", length=45, nullable=false)
	 */
	private $profile;
	

    /**
     * @Column("profile_id", type="integer", nullable=false)
     */
    private $profileId;
	
	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 * @return Vuser
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param mixed $name
	 * @return Vuser
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * @param mixed $password
	 * @return Vuser
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProfile()
	{
		return $this->profile;
	}
	
	/**
	 * @param mixed $profile
	 * @return Vuser
	 */
	public function setProfile($profile)
	{
		$this->profile = $profile;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProfileId()
	{
		return $this->profileId;
	}
	
	/**
	 * @param mixed $profileId
	 * @return Vuser
	 */
	public function setProfileId($profileId)
	{
		$this->profileId = $profileId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventId()
	{
		return $this->eventId;
	}
	
	/**
	 * @param mixed $eventId
	 * @return Vuser
	 */
	public function setEventId($eventId)
	{
		$this->eventId = $eventId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getActive()
	{
		return $this->active;
	}
	
	/**
	 * @param mixed $active
	 * @return Vuser
	 */
	public function setActive($active)
	{
		$this->active = $active;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLoginDefault()
	{
		return $this->loginDefault;
	}
	
	/**
	 * @param mixed $loginDefault
	 */
	public function setLoginDefault($loginDefault)
	{
		$this->loginDefault = $loginDefault;
	}
	
	
	/**
	 * @param User $obj
	 * @return mixed
	 */
	public static function toArray(Array $obj)
	{
		$users = array();
		foreach ($obj as $o){
			$data['id']  = $o->getId();
			$data['name']  = $o->getName();
			$data['password']  = $o->getPassword();
			$data['profile']  = $o->getProfile();
			$data['event']  = $o->getEventId();
			$data['profile_id']  = $o->getProfileId();
			$data['login_default']  = $o->getLoginDefault();
			  
			$users[] = $data;
			
		}
		
		return  $users;
	}
	
	
	
	
}
