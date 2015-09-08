<?php
namespace Raman\Model;

use Doctrine\ORM\Mapping\Annotation;

class Raman_Model_General
{
	/**
	 * Doctrine Resource From Application.ini
	 */
	protected $doctrine;
	
	/**
	 * Doctrine Connection To Community With Database
	 * @var \Doctrine\DBAL\Connection
	 */
	protected $dbConn;
	
	/**
	 * Doctrine Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entity;
	
	/**
	 * Authentication Session Instance
	 * @var \Zend_Session_Namespace
	 */
	protected $authSes;
			
	
	public function __construct()
	{		
		$this->doctrine = \Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('doctrine');
		$this->dbConn 	= $this->doctrine->getConnection();
		$this->entity 	= $this->doctrine->getEntityManager();
		$this->authSes 	= new \Zend_Session_Namespace('authentication');		
	}

	/**
	 *
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
	    if (!$this->entity->isOpen()) {
	        $this->entity = $this->entity->create(
	            $this->entity->getConnection(),
	            $this->entity->getConfiguration()
	        );
	    }
	     
	    return $this->entity;
	}
}