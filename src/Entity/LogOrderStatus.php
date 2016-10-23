<?php


/**
 * @Entity
 * @Table(name="log_order_status")
 */
class LogOrderStatus
{
	
	/**
	 * @Id
	 * @Column(name="log_order_status_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
	
    private $logOrderStatusId;

    /**
	 * @Column(name="order_id", type="integer", nullable=true)
     */
    private $orderId;

    /**
     * @Column(name="order_event_id", type="integer", nullable=true)
     */
    private $orderEventId;

    /**
     * @Column(name="order_status_id", type="integer", nullable=true)
     */
    private $orderStatusId;

    /**
     * @Column(name="log_order_status_date", type="datetime", nullable=true)
     */
    private $logOrderStatusDate;
	
	/**
	 * @return mixed
	 */
	public function getLogOrderStatusId()
	{
		return $this->logOrderStatusId;
	}
	
	/**
	 * @param mixed $logOrderStatusId
	 * @return LogOrderStatus
	 */
	public function setLogOrderStatusId($logOrderStatusId)
	{
		$this->logOrderStatusId = $logOrderStatusId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderId()
	{
		return $this->orderId;
	}
	
	/**
	 * @param mixed $orderId
	 * @return LogOrderStatus
	 */
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderEventId()
	{
		return $this->orderEventId;
	}
	
	/**
	 * @param mixed $orderEventId
	 * @return LogOrderStatus
	 */
	public function setOrderEventId($orderEventId)
	{
		$this->orderEventId = $orderEventId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderStatusId()
	{
		return $this->orderStatusId;
	}
	
	/**
	 * @param mixed $orderStatusId
	 * @return LogOrderStatus
	 */
	public function setOrderStatusId($orderStatusId)
	{
		$this->orderStatusId = $orderStatusId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getLogOrderStatusDate()
	{
		return $this->logOrderStatusDate;
	}
	
	/**
	 * @param mixed $logOrderStatusDate
	 * @return LogOrderStatus
	 */
	public function setLogOrderStatusDate($logOrderStatusDate)
	{
		$this->logOrderStatusDate = $logOrderStatusDate;
		return $this;
	}

	
	
}
