<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="product")
 */
class Product
{
	/**
	 * @Id
	 * @Column(name="product_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
    private $productId;
	
	/**
	 * @Column(name="product_number", type="string", length=30, nullable=false)
	 */
    private $productNumber;
	
	/**
	 * @Column(name="product_name_pt", type="string", length=100, nullable=false)
	 */
    private $productNamePt;
	
	/**
	 * @Column(name="product_name_en", type="string", length=100, nullable=false)
	 */
    private $productNameEn;
	
	/**
	 * @Column(name="product_name_es", type="string", length=100, nullable=false)
	 */
    private $productNameEs;
	 
    /**
     *
     * @Column(name="product_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $productPrice;

    /**
     * @Column(name="product_image", type="string", length=45, nullable=true)
     */
    private $productImage;

    /**
     * @Column(name="product_desc_pt", type="text", length=65535, nullable=false)
     */
    private $productDescPt;

    /**
     * @Column(name="product_desc_en", type="text", length=65535, nullable=false)
     */
    private $productDescEn;

    /**
     * @Column(name="product_desc_es", type="text", length=65535, nullable=false)
     */
    private $productDescEs;

    /**
	 * @Column(name="product_active", type="boolean", nullable=false)
     */
    private $productActive = '1';

    /**
     * @Column(name="product_hour_initial", type="time", nullable=false)
     */
    private $productHourInitial;

    /**
     * @Column(name="product_hour_final", type="time", nullable=false)
     */
    private $productHourFinal;

    /**
     * @Column(name="product_fast", type="boolean", nullable=false)
     */
    private $productFast = '0';

    /**
     * @Column(name="product_update_date", type="datetime", nullable=false)
     */
    private $productUpdateDate;

    /**
     * @Column(name="product_category_id", type="integer", nullable=true)
     */
    private $productCategoryId;

    /**
     * @Column(name="product_event_id", type="integer", nullable=false)
     */
    private $productEventId;

    /**
     * @Column(name="product_inventory_qtd", type="integer", nullable=false)
     */
    private $productInventoryQtd;

    /**
     * @Column(name="product_inventory_current", type="integer", nullable=false)
     */
    private $productInventoryCurrent;

    /**
     *
     * @Column(name="product_inventory_maximum", type="integer", nullable=false)
     */
    private $productInventoryMaximum;

    /**
     * @Column(name="product_inventory_minimum", type="integer", nullable=false)
     */
    private $productInventoryMinimum;

    /**
     * @Column(name="product_complement", type="boolean", nullable=false)
     */
    private $productComplement = '0';
	
	/**
	 * @Column(name="product_hour_timezone", type="string", length=50, nullable=false)
	 */
	private $productHourTimezone;
	
	 

    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set productNumber
     *
     * @param string $productNumber
     *
     * @return Product
     */
    public function setProductNumber($productNumber)
    {
        $this->productNumber = $productNumber;

        return $this;
    }

    /**
     * Get productNumber
     *
     * @return string
     */
    public function getProductNumber()
    {
        return $this->productNumber;
    }

    /**
     * Set productNamePt
     *
     * @param string $productNamePt
     *
     * @return Product
     */
    public function setProductNamePt($productNamePt)
    {
        $this->productNamePt = $productNamePt;

        return $this;
    }

    /**
     * Get productNamePt
     *
     * @return string
     */
    public function getProductNamePt()
    {
        return $this->productNamePt;
    }

    /**
     * Set productNameEn
     *
     * @param string $productNameEn
     *
     * @return Product
     */
    public function setProductNameEn($productNameEn)
    {
        $this->productNameEn = $productNameEn;

        return $this;
    }

    /**
     * Get productNameEn
     *
     * @return string
     */
    public function getProductNameEn()
    {
        return $this->productNameEn;
    }

    /**
     * Set productNameEs
     *
     * @param string $productNameEs
     *
     * @return Product
     */
    public function setProductNameEs($productNameEs)
    {
        $this->productNameEs = $productNameEs;

        return $this;
    }

    /**
     * Get productNameEs
     *
     * @return string
     */
    public function getProductNameEs()
    {
        return $this->productNameEs;
    }

    /**
     * Set productPrice
     *
     * @param string $productPrice
     *
     * @return Product
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return string
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * Set productImage
     *
     * @param string $productImage
     *
     * @return Product
     */
    public function setProductImage($productImage)
    {
        $this->productImage = $productImage;

        return $this;
    }

    /**
     * Get productImage
     *
     * @return string
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * Set productDescPt
     *
     * @param string $productDescPt
     *
     * @return Product
     */
    public function setProductDescPt($productDescPt)
    {
        $this->productDescPt = $productDescPt;

        return $this;
    }

    /**
     * Get productDescPt
     *
     * @return string
     */
    public function getProductDescPt()
    {
        return $this->productDescPt;
    }

    /**
     * Set productDescEn
     *
     * @param string $productDescEn
     *
     * @return Product
     */
    public function setProductDescEn($productDescEn)
    {
        $this->productDescEn = $productDescEn;

        return $this;
    }

    /**
     * Get productDescEn
     *
     * @return string
     */
    public function getProductDescEn()
    {
        return $this->productDescEn;
    }

    /**
     * Set productDescEs
     *
     * @param string $productDescEs
     *
     * @return Product
     */
    public function setProductDescEs($productDescEs)
    {
        $this->productDescEs = $productDescEs;

        return $this;
    }

    /**
     * Get productDescEs
     *
     * @return string
     */
    public function getProductDescEs()
    {
        return $this->productDescEs;
    }

    /**
     * Set productActive
     *
     * @param boolean $productActive
     *
     * @return Product
     */
    public function setProductActive($productActive)
    {
        $this->productActive = $productActive;

        return $this;
    }

    /**
     * Get productActive
     *
     * @return boolean
     */
    public function getProductActive()
    {
        return $this->productActive;
    }
	
	/**
	 * @return mixed
	 */
	public function getProductHourInitial()
	{
		return $this->productHourInitial->format('H:i');
	}
	
	/**
	 * @param mixed $productHourInitial
	 * @return Product
	 */
	public function setProductHourInitial($productHourInitial)
	{
		$this->productHourInitial = $productHourInitial;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getProductHourFinal()
	{
		return $this->productHourFinal->format('H:i');
	}
	
	/**
	 * @param mixed $productHourFinal
	 * @return Product
	 */
	public function setProductHourFinal($productHourFinal)
	{
		$this->productHourFinal = $productHourFinal;
		return $this;
	}

   

    

    /**
     * Set productFast
     *
     * @param boolean $productFast
     *
     * @return Product
     */
    public function setProductFast($productFast)
    {
        $this->productFast = $productFast;

        return $this;
    }

    /**
     * Get productFast
     *
     * @return boolean
     */
    public function getProductFast()
    {
        return $this->productFast;
    }

    /**
     * Set productUpdateDate
     *
     * @param \DateTime $productUpdateDate
     *
     * @return Product
     */
    public function setProductUpdateDate($productUpdateDate)
    {
        $this->productUpdateDate = $productUpdateDate;

        return $this;
    }

    /**
     * Get productUpdateDate
     *
     * @return \DateTime
     */
    public function getProductUpdateDate()
    {
	
		$productUpdateDate = null;
		if(!is_null($this->productHourTimezone )){
			$productUpdateDate = $this->productUpdateDate->setTimeZone(new \DateTimeZone($this->productHourTimezone))->format('d-m-Y H:i:s');
		}
		return $productUpdateDate;
		 
    }

    /**
     * Set productCategoryId
     *
     * @param integer $productCategoryId
     *
     * @return Product
     */
    public function setProductCategoryId($productCategoryId)
    {
        $this->productCategoryId = $productCategoryId;

        return $this;
    }

    /**
     * Get productCategoryId
     *
     * @return integer
     */
    public function getProductCategoryId()
    {
        return $this->productCategoryId;
    }

    /**
     * Set productEventId
     *
     * @param integer $productEventId
     *
     * @return Product
     */
    public function setProductEventId($productEventId)
    {
        $this->productEventId = $productEventId;

        return $this;
    }

    /**
     * Get productEventId
     *
     * @return integer
     */
    public function getProductEventId()
    {
        return $this->productEventId;
    }

    /**
     * Set productInventoryQtd
     *
     * @param integer $productInventoryQtd
     *
     * @return Product
     */
    public function setProductInventoryQtd($productInventoryQtd)
    {
        $this->productInventoryQtd = $productInventoryQtd;

        return $this;
    }

    /**
     * Get productInventoryQtd
     *
     * @return integer
     */
    public function getProductInventoryQtd()
    {
        return $this->productInventoryQtd;
    }

    /**
     * Set productInventoryCurrent
     *
     * @param integer $productInventoryCurrent
     *
     * @return Product
     */
    public function setProductInventoryCurrent($productInventoryCurrent)
    {
        $this->productInventoryCurrent = $productInventoryCurrent;

        return $this;
    }

    /**
     * Get productInventoryCurrent
     *
     * @return integer
     */
    public function getProductInventoryCurrent()
    {
        return $this->productInventoryCurrent;
    }

    /**
     * Set productInventoryMaximum
     *
     * @param integer $productInventoryMaximum
     *
     * @return Product
     */
    public function setProductInventoryMaximum($productInventoryMaximum)
    {
        $this->productInventoryMaximum = $productInventoryMaximum;

        return $this;
    }

    /**
     * Get productInventoryMaximum
     *
     * @return integer
     */
    public function getProductInventoryMaximum()
    {
        return $this->productInventoryMaximum;
    }

    /**
     * Set productInventoryMinimum
     *
     * @param integer $productInventoryMinimum
     *
     * @return Product
     */
    public function setProductInventoryMinimum($productInventoryMinimum)
    {
        $this->productInventoryMinimum = $productInventoryMinimum;

        return $this;
    }

    /**
     * Get productInventoryMinimum
     *
     * @return integer
     */
    public function getProductInventoryMinimum()
    {
        return $this->productInventoryMinimum;
    }

    /**
     * Set productComplement
     *
     * @param boolean $productComplement
     *
     * @return Product
     */
    public function setProductComplement($productComplement)
    {
        $this->productComplement = $productComplement;

        return $this;
    }

    /**
     * Get productComplement
     *
     * @return boolean
     */
    public function getProductComplement()
    {
        return $this->productComplement;
    }
	
	/**
	 * @return mixed
	 */
	public function getProductHourTimezone()
	{
		return $this->productHourTimezone;
	}
	
	/**
	 * @param mixed $productHourTimezone
	 * @return Product
	 */
	public function setProductHourTimezone($productHourTimezone)
	{
		$this->productHourTimezone = $productHourTimezone;
		return $this;
	}
	
	
	/**
	 * @param Product $obj
	 * @return mixed
	 */
	public static function toArray(Array $obj)
	{
		$datas = array();
		foreach ($obj as $o){
			$data['product_id']  = $o->getProductId();
			$data['product_number']  = $o->getProductNumber();
			$data['product_name_pt']  = $o->getProductNamePt();
			$data['product_name_en']  = $o->getProductNameEn();
			$data['product_name_es']  = $o->getProductNameEs();
			$data['product_price']  = $o->getProductPrice();
			$data['product_image']  = $o->getProductImage();
			$data['product_desc_pt']  = $o->getProductDescPt();
			$data['product_desc_en']  = $o->getProductDescEn();
			$data['product_desc_es']  = $o->getProductDescEs();
			$data['product_active']  = $o->getProductActive();
			$data['product_hour_initial']  = $o->getProductHourInitial();
			$data['product_hour_final']  = $o->getProductHourFinal();
			$data['product_fast']  = $o->getProductFast();
			$data['product_update_date']  = $o->getProductUpdateDate();
			$data['product_category_id']  = $o->getProductCategoryId();
			$data['product_event_id']  = $o->getProductEventId();
			$data['product_inventory_qtd']  = $o->getProductInventoryQtd();
			$data['product_inventory_current']  = $o->getProductInventoryCurrent();
			$data['product_inventory_maximum']  = $o->getProductInventoryMaximum();
			$data['product_inventory_minimum'] = $o->getProductInventoryMinimum();
			$data['product_complement'] = $o->getProductComplement();
			$data['produc_hour_timezone'] = $o->getProductHourTimezone();
			$data['type_product'] = null;
			
			$datas[] = $data;
			
		}
		
		return  $datas;
	}
	
	
	
}
