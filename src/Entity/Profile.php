<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="profile")
 */


class Profile
{
	
	/**
	 * @Id
	 * @Column(name="profile_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
    private $profileId;

    /**
     * @Column(name="profile_name", type="string", length=45, nullable=false)
     */
    private $profileName;

    /**
     * @Column(name="profile_active", type="boolean", nullable=false)
     */
    private $profileActive = '1';

    /**
     * @Column(name="profile_dth_activation", type="datetime", nullable=true)
     */
    private $profileDthActivation;

    /**
     * @Column(name="profile_dth_deactivation", type="datetime", nullable=true)
     */
    private $profileDthDeactivation;
	
	/**
	 * @return mixed
	 */
	public function getProfileId()
	{
		return $this->profileId;
	}
	
	/**
	 * @param mixed $profileId
	 * @return Profile
	 */
	public function setProfileId($profileId)
	{
		$this->profileId = $profileId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProfileName()
	{
		return $this->profileName;
	}
	
	/**
	 * @param mixed $profileName
	 * @return Profile
	 */
	public function setProfileName($profileName)
	{
		$this->profileName = $profileName;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProfileActive()
	{
		return $this->profileActive;
	}
	
	/**
	 * @param mixed $profileActive
	 * @return Profile
	 */
	public function setProfileActive($profileActive)
	{
		$this->profileActive = $profileActive;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProfileDthActivation()
	{
		return $this->profileDthActivation;
	}
	
	/**
	 * @param mixed $profileDthActivation
	 * @return Profile
	 */
	public function setProfileDthActivation($profileDthActivation)
	{
		$this->profileDthActivation = $profileDthActivation;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProfileDthDeactivation()
	{
		return $this->profileDthDeactivation;
	}
	
	/**
	 * @param mixed $profileDthDeactivation
	 * @return Profile
	 */
	public function setProfileDthDeactivation($profileDthDeactivation)
	{
		$this->profileDthDeactivation = $profileDthDeactivation;
		return $this;
	}


    
}
