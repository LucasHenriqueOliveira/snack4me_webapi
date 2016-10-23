<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="city")
 */
class City
{
    
	/**
	 * @Id
	 * @Column(name="city_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
    private $cityId;

    /**
     * @Column(name="city_name", type="string", length=100, nullable=false)
     */
    private $cityName;
	
	/**
	 * @return mixed
	 */
	public function getCityId()
	{
		return $this->cityId;
	}
	
	/**
	 * @param mixed $cityId
	 * @return City
	 */
	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCityName()
	{
		return $this->cityName;
	}
	
	/**
	 * @param mixed $cityName
	 * @return City
	 */
	public function setCityName($cityName)
	{
		$this->cityName = $cityName;
		return $this;
	}


    
}
