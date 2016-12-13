<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="order")
 */
class Order
{
	/**
	 * @Id
	 * @Column(name="order_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $orderId;

    /**
     * @Column(name="order_customer_id", type="integer", nullable=false)
     */
    private $orderCustomerId;

    /**
     * @Column(name="order_customer_email", type="string", length=150, nullable=false)
     */
    private $orderCustomerEmail;

    /**
     * @Column(name="order_tracking_number", type="string", length=100, nullable=false)
     */
    private $orderTrackingNumber;

    /**
     * @Column(name="order_date", type="datetime", nullable=false)
     */
    private $orderDate;

    /**
     * @Column(name="order_apartment", type="string", length=55, nullable=true)
     */
    private $orderApartment;

    /**
     * @Column(name="order_floor", type="string", length=50, nullable=false)
     */
    private $orderFloor;

    /**
     * @Column(name="order_local_order_id", type="integer", nullable=true)
     */
    private $orderLocalOrderId;
	
	
	/**
	 * @Column(name="order_local_order_desc", type="string", nullable=true)
	 */
	private $orderLocalOrderDesc;




	
	
    /**
     * @Column(name="order_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $orderPrice;

    /**
     * @Column(name="order_price_discount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $orderPriceDiscount;

    /**
     * @Column(name="order_tax_service", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $orderTaxService;

    /**
     * @Column(name="order_price_total", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $orderPriceTotal;

    /**
     *@Column(name="order_schedule", type="boolean", nullable=false)
     */
    private $orderSchedule = '0';

    /**
     * @Column(name="order_schedule_date", type="time", nullable=true)
     */
    private $orderScheduleDate;

    /**
     * @Column(name="order_delivery_date", type="datetime", nullable=true)
     */
    private $orderDeliveryDate;

    /**
     * @Column(name="order_coupon_id", type="integer", nullable=true)
     */
    private $orderCouponId;

    /**
     * @Column(name="order_event_id", type="integer", nullable=false)
     */
    private $orderEventId;

    /**
     * @Column(name="order_status_id", type="integer", nullable=true)
     */
    private $orderStatusId;

    /**
     * @Column(name="order_user_id_delivery", type="integer", nullable=true)
     */
    private $orderUserIdDelivery;
	
	/**
	 * @Column(name="order_zone", type="string", length=30, nullable=true)
	 */
	private $orderZone;
	
	/**
	 * @Column(name="order_cpf", type="string", length=15, nullable=true)
	 */
	private $orderCpf;
	
	
	
	/**
	 * @return mixed
	 */
	public function getOrderId()
	{
		return $this->orderId;
	}
	
	/**
	 * @param mixed $orderId
	 * @return Order
	 */
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderCustomerId()
	{
		return $this->orderCustomerId;
	}
	
	/**
	 * @param mixed $orderCustomerId
	 * @return Order
	 */
	public function setOrderCustomerId($orderCustomerId)
	{
		$this->orderCustomerId = $orderCustomerId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderCustomerEmail()
	{
		return $this->orderCustomerEmail;
	}
	
	/**
	 * @param mixed $orderCustomerEmail
	 * @return Order
	 */
	public function setOrderCustomerEmail($orderCustomerEmail)
	{
		$this->orderCustomerEmail = $orderCustomerEmail;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderTrackingNumber()
	{
		return $this->orderTrackingNumber;
	}
	
	/**
	 * @param mixed $orderTrackingNumber
	 * @return Order
	 */
	public function setOrderTrackingNumber($orderTrackingNumber)
	{
		$this->orderTrackingNumber = $orderTrackingNumber;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderDate()
	{
		
		$orderDate = null;
		if(!is_null($this->orderDate )){
			$orderDate = $this->orderDate->setTimeZone(new \DateTimeZone($this->orderZone))->format('d-m-Y H:i:s');
		}
		return $orderDate;
		 
	}
	
	/**
	 * @param mixed $orderDate
	 * @return Order
	 */
	public function setOrderDate($orderDate)
	{
		$this->orderDate = $orderDate;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderApartment()
	{
		return $this->orderApartment;
	}
	
	/**
	 * @param mixed $orderApartment
	 * @return Order
	 */
	public function setOrderApartment($orderApartment)
	{
		$this->orderApartment = $orderApartment;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderFloor()
	{
		return $this->orderFloor;
	}
	
	/**
	 * @param mixed $orderFloor
	 * @return Order
	 */
	public function setOrderFloor($orderFloor)
	{
		$this->orderFloor = $orderFloor;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderLocalOrderId()
	{
		return $this->orderLocalOrderId;
	}
	
	/**
	 * @param mixed $orderLocalOrderId
	 * @return Order
	 */
	public function setOrderLocalOrderId($orderLocalOrderId)
	{
		$this->orderLocalOrderId = $orderLocalOrderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderPrice()
	{
		return $this->orderPrice;
	}
	
	/**
	 * @param mixed $orderPrice
	 * @return Order
	 */
	public function setOrderPrice($orderPrice)
	{
		$this->orderPrice = $orderPrice;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderPriceDiscount()
	{
		return $this->orderPriceDiscount;
	}
	
	/**
	 * @param mixed $orderPriceDiscount
	 * @return Order
	 */
	public function setOrderPriceDiscount($orderPriceDiscount)
	{
		$this->orderPriceDiscount = $orderPriceDiscount;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderTaxService()
	{
		return $this->orderTaxService;
	}
	
	/**
	 * @param mixed $orderTaxService
	 * @return Order
	 */
	public function setOrderTaxService($orderTaxService)
	{
		$this->orderTaxService = $orderTaxService;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderPriceTotal()
	{
		return $this->orderPriceTotal;
	}
	
	/**
	 * @param mixed $orderPriceTotal
	 * @return Order
	 */
	public function setOrderPriceTotal($orderPriceTotal)
	{
		$this->orderPriceTotal = $orderPriceTotal;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderSchedule()
	{
		return $this->orderSchedule;
	}
	
	/**
	 * @param mixed $orderSchedule
	 * @return Order
	 */
	public function setOrderSchedule($orderSchedule)
	{
		$this->orderSchedule = $orderSchedule;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderScheduleDate()
	{
		return $this->orderScheduleDate;
	}
	
	/**
	 * @param mixed $orderScheduleDate
	 * @return Order
	 */
	public function setOrderScheduleDate($orderScheduleDate)
	{
		$this->orderScheduleDate = $orderScheduleDate;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderDeliveryDate()
	{
		return $this->orderDeliveryDate;
	}
	
	/**
	 * @param mixed $orderDeliveryDate
	 * @return Order
	 */
	public function setOrderDeliveryDate($orderDeliveryDate)
	{
		$this->orderDeliveryDate = $orderDeliveryDate;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderCouponId()
	{
		return $this->orderCouponId;
	}
	
	/**
	 * @param mixed $orderCouponId
	 * @return Order
	 */
	public function setOrderCouponId($orderCouponId)
	{
		$this->orderCouponId = $orderCouponId;
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
	 * @return Order
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
	 * @return Order
	 */
	public function setOrderStatusId($orderStatusId)
	{
		$this->orderStatusId = $orderStatusId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderUserIdDelivery()
	{
		return $this->orderUserIdDelivery;
	}
	
	/**
	 * @param mixed $orderUserIdDelivery
	 * @return Order
	 */
	public function setOrderUserIdDelivery($orderUserIdDelivery)
	{
		$this->orderUserIdDelivery = $orderUserIdDelivery;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderZone()
	{
		return $this->orderZone;
	}
	
	/**
	 * @param mixed $orderZone
	 * @return Order
	 */
	public function setOrderZone($orderZone)
	{
		$this->orderZone = $orderZone;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderLocalOrderDesc()
	{
		return $this->orderLocalOrderDesc;
	}
	
	/**
	 * @param mixed $orderLocalOrderDesc
	 * @return Order
	 */
	public function setOrderLocalOrderDesc($orderLocalOrderDesc)
	{
		$this->orderLocalOrderDesc = $orderLocalOrderDesc;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOrderCpf()
	{
		return $this->orderCpf;
	}
	
	/**
	 * @param mixed $orderCpf
	 * @return Order
	 */
	public function setOrderCpf($orderCpf)
	{
		$this->orderCpf = $orderCpf;
		return $this;
	}
	
	 

    
}
