<?php



namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="type_product")
 */
class TypeProduct
{
	/**
	 * @Id
	 * @Column(name="type_product_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
    private $typeProductId;

    /**
     * @Column(name="type_product_name_pt", type="string", length=100, nullable=true)
     */
    private $typeProductNamePt;

    /**
     * @Column(name="type_product_name_en", type="string", length=100, nullable=true)
     */
    private $typeProductNameEn;

    /**
     * @Column(name="type_product_name_es", type="string", length=100, nullable=true)
     */
    private $typeProductNameEs;

    /**
     * @Column(name="type_product_product_id", type="integer", nullable=true)
     */
    private $typeProductProductId;

    /**
     * @Column(name="type_product_active", type="boolean", nullable=true)
     */
    private $typeProductActive = '1';


    /**
     * Get typeProductId
     *
     * @return integer
     */
    public function getTypeProductId()
    {
        return $this->typeProductId;
    }

    /**
     * Set typeProductNamePt
     *
     * @param string $typeProductNamePt
     *
     * @return TypeProduct
     */
    public function setTypeProductNamePt($typeProductNamePt)
    {
        $this->typeProductNamePt = $typeProductNamePt;

        return $this;
    }

    /**
     * Get typeProductNamePt
     *
     * @return string
     */
    public function getTypeProductNamePt()
    {
        return $this->typeProductNamePt;
    }

    /**
     * Set typeProductNameEn
     *
     * @param string $typeProductNameEn
     *
     * @return TypeProduct
     */
    public function setTypeProductNameEn($typeProductNameEn)
    {
        $this->typeProductNameEn = $typeProductNameEn;

        return $this;
    }

    /**
     * Get typeProductNameEn
     *
     * @return string
     */
    public function getTypeProductNameEn()
    {
        return $this->typeProductNameEn;
    }

    /**
     * Set typeProductNameEs
     *
     * @param string $typeProductNameEs
     *
     * @return TypeProduct
     */
    public function setTypeProductNameEs($typeProductNameEs)
    {
        $this->typeProductNameEs = $typeProductNameEs;

        return $this;
    }

    /**
     * Get typeProductNameEs
     *
     * @return string
     */
    public function getTypeProductNameEs()
    {
        return $this->typeProductNameEs;
    }

    /**
     * Set typeProductProductId
     *
     * @param integer $typeProductProductId
     *
     * @return TypeProduct
     */
    public function setTypeProductProductId($typeProductProductId)
    {
        $this->typeProductProductId = $typeProductProductId;

        return $this;
    }

    /**
     * Get typeProductProductId
     *
     * @return integer
     */
    public function getTypeProductProductId()
    {
        return $this->typeProductProductId;
    }

    /**
     * Set typeProductActive
     *
     * @param boolean $typeProductActive
     *
     * @return TypeProduct
     */
    public function setTypeProductActive($typeProductActive)
    {
        $this->typeProductActive = $typeProductActive;

        return $this;
    }

    /**
     * Get typeProductActive
     *
     * @return boolean
     */
    public function getTypeProductActive()
    {
        return $this->typeProductActive;
    }
	
	
	/**
	 * @param TypeProduct $obj
	 * @return mixed
	 */
	public static function toArray(Array $obj)
	{
		$datas = array();
		foreach ($obj as $o){
			$data['type_product_id']  = $o->getTypeProductId();
			$data['type_product_name_pt']  = $o->getTypeProductNamePt();
			$data['type_product_name_en']  = $o->getTypeProductNameEn();
			$data['type_product_name_es']  = $o->getTypeProductNameEs();
			$data['type_product_product_id']  = $o->getTypeProductProductId();
			$data['type_product_active']  = $o->getTypeProductActive();
			 
			
			$datas[] = $data;
			
		}
		
		return  $datas;
	}
	
}
