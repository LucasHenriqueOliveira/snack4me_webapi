<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="item_type_product")
 */

class ItemTypeProduct
{
	
	/**
	 * @Id
	 * @Column(name="item_type_product_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
   
    private $itemTypeProductId;

    /**
     * @Column(name="item_type_product_desc", type="text", length=65535, nullable=true)
     */
    private $itemTypeProductDesc;

    /**
     * @Column(name="item_type_product_item_id", type="integer", nullable=true)
     */
    private $itemTypeProductItemId;

    /**
     * @Column(name="item_type_product_type_product_id", type="integer", nullable=true)
     */
    private $itemTypeProductTypeProductId;

    /**
     * @Column(name="item_type_product_product_id", type="integer", nullable=false)
     */
    private $itemTypeProductProductId;
	
	/**
	 * @return mixed
	 */
	public function getItemTypeProductId()
	{
		return $this->itemTypeProductId;
	}
	
	/**
	 * @param mixed $itemTypeProductId
	 * @return ItemTypeProduct
	 */
	public function setItemTypeProductId($itemTypeProductId)
	{
		$this->itemTypeProductId = $itemTypeProductId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemTypeProductDesc()
	{
		return $this->itemTypeProductDesc;
	}
	
	/**
	 * @param mixed $itemTypeProductDesc
	 * @return ItemTypeProduct
	 */
	public function setItemTypeProductDesc($itemTypeProductDesc)
	{
		$this->itemTypeProductDesc = $itemTypeProductDesc;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemTypeProductItemId()
	{
		return $this->itemTypeProductItemId;
	}
	
	/**
	 * @param mixed $itemTypeProductItemId
	 * @return ItemTypeProduct
	 */
	public function setItemTypeProductItemId($itemTypeProductItemId)
	{
		$this->itemTypeProductItemId = $itemTypeProductItemId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemTypeProductTypeProductId()
	{
		return $this->itemTypeProductTypeProductId;
	}
	
	/**
	 * @param mixed $itemTypeProductTypeProductId
	 * @return ItemTypeProduct
	 */
	public function setItemTypeProductTypeProductId($itemTypeProductTypeProductId)
	{
		$this->itemTypeProductTypeProductId = $itemTypeProductTypeProductId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getItemTypeProductProductId()
	{
		return $this->itemTypeProductProductId;
	}
	
	/**
	 * @param mixed $itemTypeProductProductId
	 * @return ItemTypeProduct
	 */
	public function setItemTypeProductProductId($itemTypeProductProductId)
	{
		$this->itemTypeProductProductId = $itemTypeProductProductId;
		return $this;
	}


   
}
