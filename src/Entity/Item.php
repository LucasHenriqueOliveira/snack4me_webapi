<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="item")
 */

class Item
{
	/**
	 * @Id
	 * @Column(name="item_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
    private $itemId;

    /**
     * @Column(name="item_order_id", type="integer", nullable=false)
     */
    private $itemOrderId;

    /**
     * @Column(name="item_product_id", type="integer", nullable=false)
     */
    private $itemProductId;

    /**
     * @Column(name="item_price_unit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPriceUnit;

    /**
     * @Column(name="item_quantity", type="integer", nullable=false)
     */
    private $itemQuantity;

    /**
     * @Column(name="item_price_total", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPriceTotal;
	
	/**
	 * @return mixed
	 */
	public function getItemId()
	{
		return $this->itemId;
	}
	
	/**
	 * @param mixed $itemId
	 * @return Item
	 */
	public function setItemId($itemId)
	{
		$this->itemId = $itemId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemOrderId()
	{
		return $this->itemOrderId;
	}
	
	/**
	 * @param mixed $itemOrderId
	 * @return Item
	 */
	public function setItemOrderId($itemOrderId)
	{
		$this->itemOrderId = $itemOrderId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemProductId()
	{
		return $this->itemProductId;
	}
	
	/**
	 * @param mixed $itemProductId
	 * @return Item
	 */
	public function setItemProductId($itemProductId)
	{
		$this->itemProductId = $itemProductId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemPriceUnit()
	{
		return $this->itemPriceUnit;
	}
	
	/**
	 * @param mixed $itemPriceUnit
	 * @return Item
	 */
	public function setItemPriceUnit($itemPriceUnit)
	{
		$this->itemPriceUnit = $itemPriceUnit;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemQuantity()
	{
		return $this->itemQuantity;
	}
	
	/**
	 * @param mixed $itemQuantity
	 * @return Item
	 */
	public function setItemQuantity($itemQuantity)
	{
		$this->itemQuantity = $itemQuantity;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemPriceTotal()
	{
		return $this->itemPriceTotal;
	}
	
	/**
	 * @param mixed $itemPriceTotal
	 * @return Item
	 */
	public function setItemPriceTotal($itemPriceTotal)
	{
		$this->itemPriceTotal = $itemPriceTotal;
		return $this;
	}


}
