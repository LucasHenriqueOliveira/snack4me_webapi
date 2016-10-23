<?php


namespace App\Entity;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @Table(name="customer")
 */
class Customer
{
	
	/**
	 * @Id
	 * @Column(name="customer_id", type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	
    
    private $customerId;

    /**
     * @Column(name="customer_name", type="string", length=150, nullable=true)
     */
    private $customerName;

    /**
     * @Column(name="customer_email", type="string", length=100, nullable=true)
     */
    private $customerEmail;

    /**
     * @Column(name="customer_password", type="string", length=45, nullable=true)
     */
    private $customerPassword;

    /**
     * @Column(name="customer_token", type="string", length=100, nullable=true)
     */
    private $customerToken;

    /**
     * @Column(name="customer_device_id", type="string", length=45, nullable=true)
     */
    private $customerDeviceId;

    /**
     * @Column(name="customer_registration_date", type="datetime", nullable=true)
     */
    private $customerRegistrationDate;

    /**
     * @Column(name="customer_sin_valid", type="string", length=1, nullable=true)
     */
    private $customerSinValid = 'N';

    /**
     * @Column(name="customer_valid_date", type="datetime", nullable=true)
     */
    private $customerValidDate;

    /**
     * @Column(name="customer_phone", type="string", length=20, nullable=true)
     */
    private $customerPhone;

    /**
     * @Column(name="customer_type", type="integer", nullable=true)
     */
    private $customerType = '1';

    /**
     * @Column(name="customer_update_password", type="datetime", nullable=true)
     */
    private $customerUpdatePassword;
	
	/**
	 * @return mixed
	 */
	public function getCustomerId()
	{
		return $this->customerId;
	}
	
	/**
	 * @param mixed $customerId
	 */
	public function setCustomerId($customerId)
	{
		$this->customerId = $customerId;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerName()
	{
		return $this->customerName;
	}
	
	/**
	 * @param mixed $customerName
	 */
	public function setCustomerName($customerName)
	{
		$this->customerName = $customerName;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerEmail()
	{
		return $this->customerEmail;
	}
	
	/**
	 * @param mixed $customerEmail
	 */
	public function setCustomerEmail($customerEmail)
	{
		$this->customerEmail = $customerEmail;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerPassword()
	{
		return $this->customerPassword;
	}
	
	/**
	 * @param mixed $customerPassword
	 */
	public function setCustomerPassword($customerPassword)
	{
		$this->customerPassword = $customerPassword;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerToken()
	{
		return $this->customerToken;
	}
	
	/**
	 * @param mixed $customerToken
	 */
	public function setCustomerToken($customerToken)
	{
		$this->customerToken = $customerToken;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerDeviceId()
	{
		return $this->customerDeviceId;
	}
	
	/**
	 * @param mixed $customerDeviceId
	 */
	public function setCustomerDeviceId($customerDeviceId)
	{
		$this->customerDeviceId = $customerDeviceId;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerRegistrationDate()
	{
		return $this->customerRegistrationDate;
	}
	
	/**
	 * @param mixed $customerRegistrationDate
	 */
	public function setCustomerRegistrationDate($customerRegistrationDate)
	{
		$this->customerRegistrationDate = $customerRegistrationDate;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerSinValid()
	{
		return $this->customerSinValid;
	}
	
	/**
	 * @param mixed $customerSinValid
	 */
	public function setCustomerSinValid($customerSinValid)
	{
		$this->customerSinValid = $customerSinValid;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerValidDate()
	{
		return $this->customerValidDate;
	}
	
	/**
	 * @param mixed $customerValidDate
	 */
	public function setCustomerValidDate($customerValidDate)
	{
		$this->customerValidDate = $customerValidDate;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerPhone()
	{
		return $this->customerPhone;
	}
	
	/**
	 * @param mixed $customerPhone
	 */
	public function setCustomerPhone($customerPhone)
	{
		$this->customerPhone = $customerPhone;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerType()
	{
		return $this->customerType;
	}
	
	/**
	 * @param mixed $customerType
	 */
	public function setCustomerType($customerType)
	{
		$this->customerType = $customerType;
	}
	
	/**
	 * @return mixed
	 */
	public function getCustomerUpdatePassword()
	{
		return $this->customerUpdatePassword;
	}
	
	/**
	 * @param mixed $customerUpdatePassword
	 */
	public function setCustomerUpdatePassword($customerUpdatePassword)
	{
		$this->customerUpdatePassword = $customerUpdatePassword;
	}

	
	
}
