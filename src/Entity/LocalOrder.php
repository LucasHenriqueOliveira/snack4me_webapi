<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="local_order")
 */

 
class LocalOrder
{
	
	/**
	 * @Id
	 * @Column(name="local_order_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
    
    private $localOrderId;

    /**
     * @Column(name="local_order_name_pt", type="string", length=50, nullable=true)
     */
    private $localOrderNamePt;

    /**
     * @Column(name="local_order_name_en", type="string", length=50, nullable=true)
     */
    private $localOrderNameEn;

    /**
     * @Column(name="local_order_name_es", type="string", length=50, nullable=true)
     */
    private $localOrderNameEs;

    /**
     * @Column(name="local_order_event_id", type="integer", nullable=true)
     */
    private $localOrderEventId;

    /**
     * @Column(name="local_order_active", type="boolean", nullable=true)
     */
    private $localOrderActive = '1';
	
	/**
	 * @return mixed
	 */
	public function getLocalOrderId()
	{
		return $this->localOrderId;
	}
	
	/**
	 * @param mixed $localOrderId
	 * @return LocalOrder
	 */
	public function setLocalOrderId($localOrderId)
	{
		$this->localOrderId = $localOrderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocalOrderNamePt()
	{
		return $this->localOrderNamePt;
	}
	
	/**
	 * @param mixed $localOrderNamePt
	 * @return LocalOrder
	 */
	public function setLocalOrderNamePt($localOrderNamePt)
	{
		$this->localOrderNamePt = $localOrderNamePt;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocalOrderNameEn()
	{
		return $this->localOrderNameEn;
	}
	
	/**
	 * @param mixed $localOrderNameEn
	 * @return LocalOrder
	 */
	public function setLocalOrderNameEn($localOrderNameEn)
	{
		$this->localOrderNameEn = $localOrderNameEn;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocalOrderNameEs()
	{
		return $this->localOrderNameEs;
	}
	
	/**
	 * @param mixed $localOrderNameEs
	 * @return LocalOrder
	 */
	public function setLocalOrderNameEs($localOrderNameEs)
	{
		$this->localOrderNameEs = $localOrderNameEs;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocalOrderEventId()
	{
		return $this->localOrderEventId;
	}
	
	/**
	 * @param mixed $localOrderEventId
	 * @return LocalOrder
	 */
	public function setLocalOrderEventId($localOrderEventId)
	{
		$this->localOrderEventId = $localOrderEventId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocalOrderActive()
	{
		return $this->localOrderActive;
	}
	
	/**
	 * @param mixed $localOrderActive
	 * @return LocalOrder
	 */
	public function setLocalOrderActive($localOrderActive)
	{
		$this->localOrderActive = $localOrderActive;
		return $this;
	}
	
	 
	
}
