<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="rate_order")
 */


class RateOrder
{
	
	/**
	 * @Id
	 * @Column(name="rate_order_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
	 
    private $rateOrderId;

    /**
     * @Column(name="rate_order_order_id", type="integer", nullable=true)
     */
    private $rateOrderOrderId;

    /**
     * @Column(name="rate_order_question_1", type="integer", nullable=true)
     */
    private $rateOrderQuestion1;

    /**
     * @Column(name="rate_order_question_2", type="integer", nullable=true)
     */
    private $rateOrderQuestion2;

    /**
     * @Column(name="rate_order_question_3", type="integer", nullable=true)
     */
    private $rateOrderQuestion3;

    /**
     * @Column(name="rate_order_desc", type="text", length=65535, nullable=true)
     */
    private $rateOrderDesc;
	
	/**
	 * @return mixed
	 */
	public function getRateOrderId()
	{
		return $this->rateOrderId;
	}
	
	/**
	 * @param mixed $rateOrderId
	 * @return RateOrder
	 */
	public function setRateOrderId($rateOrderId)
	{
		$this->rateOrderId = $rateOrderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getRateOrderOrderId()
	{
		return $this->rateOrderOrderId;
	}
	
	/**
	 * @param mixed $rateOrderOrderId
	 * @return RateOrder
	 */
	public function setRateOrderOrderId($rateOrderOrderId)
	{
		$this->rateOrderOrderId = $rateOrderOrderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getRateOrderQuestion1()
	{
		return $this->rateOrderQuestion1;
	}
	
	/**
	 * @param mixed $rateOrderQuestion1
	 * @return RateOrder
	 */
	public function setRateOrderQuestion1($rateOrderQuestion1)
	{
		$this->rateOrderQuestion1 = $rateOrderQuestion1;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getRateOrderQuestion2()
	{
		return $this->rateOrderQuestion2;
	}
	
	/**
	 * @param mixed $rateOrderQuestion2
	 * @return RateOrder
	 */
	public function setRateOrderQuestion2($rateOrderQuestion2)
	{
		$this->rateOrderQuestion2 = $rateOrderQuestion2;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getRateOrderQuestion3()
	{
		return $this->rateOrderQuestion3;
	}
	
	/**
	 * @param mixed $rateOrderQuestion3
	 * @return RateOrder
	 */
	public function setRateOrderQuestion3($rateOrderQuestion3)
	{
		$this->rateOrderQuestion3 = $rateOrderQuestion3;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getRateOrderDesc()
	{
		return $this->rateOrderDesc;
	}
	
	/**
	 * @param mixed $rateOrderDesc
	 * @return RateOrder
	 */
	public function setRateOrderDesc($rateOrderDesc)
	{
		$this->rateOrderDesc = $rateOrderDesc;
		return $this;
	}

	
}
