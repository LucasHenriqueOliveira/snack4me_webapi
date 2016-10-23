<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="coupon")
 */
class Coupon
{
	
	/**
	 * @Id
	 * @Column(name="coupon_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
    
    private $couponId;

    /**
     * @OColumn(name="coupon_number", type="string", length=45, nullable=false)
     */
    private $couponNumber;

    /**
     * @Column(name="coupon_tax", type="float", precision=10, scale=0, nullable=true)
     */
    private $couponTax;

    /**
     * @Column(name="coupon_sin_used", type="string", length=1, nullable=true)
     */
    private $couponSinUsed = 'N';

    /**
     * @Column(name="coupon_event_id", type="integer", nullable=true)
     */
    private $couponEventId;
	
	/**
	 * @return mixed
	 */
	public function getCouponId()
	{
		return $this->couponId;
	}
	
	/**
	 * @param mixed $couponId
	 * @return Coupon
	 */
	public function setCouponId($couponId)
	{
		$this->couponId = $couponId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCouponNumber()
	{
		return $this->couponNumber;
	}
	
	/**
	 * @param mixed $couponNumber
	 * @return Coupon
	 */
	public function setCouponNumber($couponNumber)
	{
		$this->couponNumber = $couponNumber;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCouponTax()
	{
		return $this->couponTax;
	}
	
	/**
	 * @param mixed $couponTax
	 * @return Coupon
	 */
	public function setCouponTax($couponTax)
	{
		$this->couponTax = $couponTax;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCouponSinUsed()
	{
		return $this->couponSinUsed;
	}
	
	/**
	 * @param mixed $couponSinUsed
	 * @return Coupon
	 */
	public function setCouponSinUsed($couponSinUsed)
	{
		$this->couponSinUsed = $couponSinUsed;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCouponEventId()
	{
		return $this->couponEventId;
	}
	
	/**
	 * @param mixed $couponEventId
	 * @return Coupon
	 */
	public function setCouponEventId($couponEventId)
	{
		$this->couponEventId = $couponEventId;
		return $this;
	}

	
	
}
