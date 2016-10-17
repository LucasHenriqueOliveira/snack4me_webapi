<?php



namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="category")
 */
class Category
{
	/**
	 * @Id
	 * @Column(name="category_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
    private $categoryId;

    /**
     * @Column(name="category_name_pt", type="string", length=45, nullable=false)
     */
    private $categoryNamePt;

    /**
     * @Column(name="category_name_en", type="string", length=45, nullable=false)
     */
    private $categoryNameEn;

    /**
     * @Column(name="category_name_es", type="string", length=45, nullable=false)
     */
    private $categoryNameEs;
	
	/**
	 * @return mixed
	 */
	public function getCategoryId()
	{
		return $this->categoryId;
	}
	
	/**
	 * @param mixed $categoryId
	 * @return Category
	 */
	public function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCategoryNamePt()
	{
		return $this->categoryNamePt;
	}
	
	/**
	 * @param mixed $categoryNamePt
	 * @return Category
	 */
	public function setCategoryNamePt($categoryNamePt)
	{
		$this->categoryNamePt = $categoryNamePt;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCategoryNameEn()
	{
		return $this->categoryNameEn;
	}
	
	/**
	 * @param mixed $categoryNameEn
	 * @return Category
	 */
	public function setCategoryNameEn($categoryNameEn)
	{
		$this->categoryNameEn = $categoryNameEn;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getCategoryNameEs()
	{
		return $this->categoryNameEs;
	}
	
	/**
	 * @param mixed $categoryNameEs
	 * @return Category
	 */
	public function setCategoryNameEs($categoryNameEs)
	{
		$this->categoryNameEs = $categoryNameEs;
		return $this;
	}
	
	
	
	/**
	 * @param Category $obj
	 * @return mixed
	 */
	public static function toArray(Array $obj)
	{
		$datas = array();
		foreach ($obj as $o){
			$data['id']  = $o->getCategoryId();
			$data['categoryNamePt']  = $o->getCategoryNamePt();
			$data['categoryNameEn']  = $o->getCategoryNameEn();
			$data['categoryNameEs']  = $o->getCategoryNameEs();
			 	
			$datas[] = $data;
			
		}
		
		return  $datas;
	}
	
}
