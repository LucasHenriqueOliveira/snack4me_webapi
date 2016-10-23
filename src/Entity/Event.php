<?php



namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="event")
 */
class Event
{
	/**
	 * @Id
	 * @Column(name="event_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
     
    private $eventId;

    /**
     * @Column(name="event_name", type="string", length=45, nullable=false)
     */
    private $eventName;

    /**
     * @Column(name="event_image", type="string", length=45, nullable=true)
     */
    private $eventImage;

    /**
     * @Column(name="event_city_id", type="integer", nullable=false)
     */
    private $eventCityId;

    /**
     * @Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @Column(name="event_tax_service", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $eventTaxService;

    /**
     * @Column(name="event_user_id", type="integer", nullable=false)
     */
    private $eventUserId;

    /**
	 * @Column(name="event_sin_active", type="boolean", nullable=false)
     */
    private $eventSinActive = '1';
	
	/**
	 * @return mixed
	 */
	public function getEventId()
	{
		return $this->eventId;
	}
	
	/**
	 * @param mixed $eventId
	 */
	public function setEventId($eventId)
	{
		$this->eventId = $eventId;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventName()
	{
		return $this->eventName;
	}
	
	/**
	 * @param mixed $eventName
	 */
	public function setEventName($eventName)
	{
		$this->eventName = $eventName;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventImage()
	{
		return $this->eventImage;
	}
	
	/**
	 * @param mixed $eventImage
	 */
	public function setEventImage($eventImage)
	{
		$this->eventImage = $eventImage;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventCityId()
	{
		return $this->eventCityId;
	}
	
	/**
	 * @param mixed $eventCityId
	 */
	public function setEventCityId($eventCityId)
	{
		$this->eventCityId = $eventCityId;
	}
	
	/**
	 * @return mixed
	 */
	public function getLatitude()
	{
		return $this->latitude;
	}
	
	/**
	 * @param mixed $latitude
	 */
	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
	}
	
	/**
	 * @return mixed
	 */
	public function getLongitude()
	{
		return $this->longitude;
	}
	
	/**
	 * @param mixed $longitude
	 */
	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventTaxService()
	{
		return $this->eventTaxService;
	}
	
	/**
	 * @param mixed $eventTaxService
	 */
	public function setEventTaxService($eventTaxService)
	{
		$this->eventTaxService = $eventTaxService;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventUserId()
	{
		return $this->eventUserId;
	}
	
	/**
	 * @param mixed $eventUserId
	 */
	public function setEventUserId($eventUserId)
	{
		$this->eventUserId = $eventUserId;
	}
	
	/**
	 * @return mixed
	 */
	public function getEventSinActive()
	{
		return $this->eventSinActive;
	}
	
	/**
	 * @param mixed $eventSinActive
	 */
	public function setEventSinActive($eventSinActive)
	{
		$this->eventSinActive = $eventSinActive;
	}

	
}
