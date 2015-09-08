<?php
namespace Raman\Doctrine;

use Raman\Security\Raman_Security_Encryption;

use \Doctrine\Orm\Mapping\MappedSuperclass;
use \Doctrine\ORM\Mapping\Entity; 
use \Doctrine\ORM\Mapping\Table;
use \Doctrine\ORM\Mapping\Id;
use \Doctrine\ORM\Mapping\Column;
use \Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Version;

use \Doctrine\ORM\Mapping\OneToOne;
use \Doctrine\ORM\Mapping\OneToMany;
use \Doctrine\ORM\Mapping\ManyToOne;
use \Doctrine\ORM\Mapping\ManyToMany; 

use \Doctrine\Orm\Mapping\HasLifecycleCallbacks;

use \Doctrine\Orm\Mapping\PrePersist;
use \Doctrine\Orm\Mapping\PreUpdate;
use \Doctrine\Orm\Mapping\PreRemove;
use \Doctrine\Orm\Mapping\PreFlush;

use \Doctrine\Orm\Mapping\PostPersist;
use \Doctrine\Orm\Mapping\PostUpdate;
use \Doctrine\Orm\Mapping\PostRemove;
use \Doctrine\Orm\Mapping\PostFlush;
use \Doctrine\Orm\Mapping\PostLoad;

use \Doctrine\Common\Collections\ArrayCollection;
use \Raman\Doctrine\Raman_Doctrine_Abstract;

/**
 * Doctrin Entities Base Class
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * 
 * @ignore
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 */
class Raman_Doctrine_Entity
{
	/*
	 * ##########################
	 * Delclare Main Properties
	 * ##########################
	 */
	
	/** 
	 * <p>Auto Increamental Primary Key</p>
	 * @Id @Column(type="integer", length=10) 
	 * @GeneratedValue 
	 * @var integer
	 * @ignore
	 */
	protected $id;
	
	
	/** 
	 * This property active Doctrine's Auto Optimistic Locking
	 * @Version @Column(type="datetime") 
	 * @ignore
	 */
	protected $version;
	
	/** 
	 * <p>To Check Integrity</p>
	 * @Column(type="string", length=32, options={"fixed" = true}) 
	 * @ignore
	 */
	protected $HMAC;
	
	
	/*
	 * ##########################
	 * Delclare Helper Properties
	 * ##########################
	 */
	
	/*
	 * ##########################
	 * Delclare Base Functions
	 * ##########################
	 */
		
	
	/**
	 * <p>Call Before Persist</p>
	 * @PrePersist 
	 */
	public function prePersist()
	{
		$this->fixHMAC();
	}
	
	
	/**
	 * <p>Call Before Update</p>
	 * @PreUpdate 
	 */
	public function preUpdate()
	{
		$this->fixHMAC();
	}
	
	/** 
	 * <p>Call Before Remove</p>
	 * @PreRemove 
	 */
	public function preRemove()
	{
	}
	
	/** 
	 * <p>Call Before Select</p>
	 * @PostLoad 
	 */
	public function postLoad()
	{
	}
	
	/*
	 * ##########################
	 * Delclare Helper Functions
	 * ##########################
	 */
	
	/**
	 * <p>Get property by name</p>
	 * @param mixed $property
	 */
	public function get($property)
	{
		return $this->$property;
	}
	
	/**
	 * <p>Set property by name</p>
	 * @param string $property
	 * @param mixed $value
	 */
	public function set($property, $value)
	{
		$this->$property 	= $value;
	}
	
	/**
	 * <p>Add the new value to given property</p>
	 * @param string $property
	 * @param mixed $value
	 */
	public function add($property, $value)
	{
		array_push($this->$property, $value);
	}
	
	/**
	 * Get Table's Primary Key
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set Table's Primary Key. You don't have permission to call this function!
	 * @param integer $id
	 */
	protected function setId($id)
	{
		$this->id = $id;
	}
	
	
	/*
	 * ##########################
	 * Delclare HMAC Functions
	 * ##########################
	 */
	
	/**
	 * Get HMAC with current table values (may not equal to object values)
	 */
	public function getHMAC()
	{
		return $this->HMAC;		
	}
	
	/**
	 * Set HMAC. You don't have permission to call this function!
	 * @param string $HMAC
	 */
	protected function setHMAC($HMAC)
	{
		$this->HMAC = $HMAC;
	}
	
	
	/**
	 * Create HMAC of current object values
	 */
	public function createHMAC()
	{
		/*
		 * concat properties
		 */
		foreach (get_object_vars($this) as $name => $value)
		{
			if($name != 'HMAC' && is_string($value))
				$concat .= $value;
		}

		return md5($concat);
	}
	
	/**
	 * Create HMAC of current object values and set it as HMAC property
	 */
	public function fixHMAC()
	{		
		$this->setHMAC($this->createHMAC());
	}
	
	/**
	 * assert table and object HMACs
	 * @return boolean
	 */
	public function assertHMAC()
	{
		
		foreach (get_object_vars($this) as $name => $value)
		{
			if($name != 'HMAC' && is_string($value))
				$concat .= $value;
						
		}

		return md5($concat) == $this->getHMAC();
	}
	
	
	public function getLastUpdate()
	{
	    return $this->version;
	}
	
}