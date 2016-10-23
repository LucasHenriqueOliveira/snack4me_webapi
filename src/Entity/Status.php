<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="status")
 */

class Status
{
	/**
	 * @Id
	 * @Column(name="status_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
	
    private $statusId;

    /**
     * @Column(name="status_name_pt", type="string", length=45, nullable=false)
     */
    private $statusNamePt;

    /**
     * @Column(name="status_name_en", type="string", length=45, nullable=false)
     */
    private $statusNameEn;

    /**
     * @Column(name="status_name_es", type="string", length=45, nullable=false)
     */
    private $statusNameEs;
	
	/**
	 * @return mixed
	 */
	public function getStatusId()
	{
		return $this->statusId;
	}
	
	/**
	 * @param mixed $statusId
	 * @return Status
	 */
	public function setStatusId($statusId)
	{
		$this->statusId = $statusId;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getStatusNamePt()
	{
		return $this->statusNamePt;
	}
	
	/**
	 * @param mixed $statusNamePt
	 * @return Status
	 */
	public function setStatusNamePt($statusNamePt)
	{
		$this->statusNamePt = $statusNamePt;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getStatusNameEn()
	{
		return $this->statusNameEn;
	}
	
	/**
	 * @param mixed $statusNameEn
	 * @return Status
	 */
	public function setStatusNameEn($statusNameEn)
	{
		$this->statusNameEn = $statusNameEn;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getStatusNameEs()
	{
		return $this->statusNameEs;
	}
	
	/**
	 * @param mixed $statusNameEs
	 * @return Status
	 */
	public function setStatusNameEs($statusNameEs)
	{
		$this->statusNameEs = $statusNameEs;
		return $this;
	}

	
}
