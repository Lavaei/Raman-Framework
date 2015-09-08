<?php
namespace Raman\Doctrine;

/**
 * An interface to simplifiy Doctrine's syntax by providing Zend_Db_Table's functions.
 * By using this class you improve the integrity of your web application
 * @author Mostafa Lavaei
 * @version 0.2
 * @copyright Ramansoft
 */
class Raman_Doctrine_Adapter 
{
	/**
	 * Entity object
	 * @var Raman_Doctrine_Entity
	 * @see Raman_Doctrine_Entity
	 */
	protected $entity;
	
	/**
	 * The alias for entity
	 * @var string
	 */
	protected $alias;
	
	
	/**
	 * An instance of Doctrine
	 * @var \Bisna\Doctrine\Container
	 */
	protected $doctrine;
	
	
	/**
	 * Doctrine's Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;
	
	
	/**
	 * Doctrine's Query Builder
	 * @var \Doctrine\ORM\QueryBuilder
	 */
	protected $queryBuilder;
	
	
	public function __construct(array $configs=array())
	{
	    
	    /*
	     * set properties by given configurations
	     */
		foreach($configs as $name => $value)
		{
		    switch($name)
		    { 
		        case 'entity':
		          if($value instanceof Raman_Doctrine_Entity)
		              $this->entity = $value;
	              else 	 
                      throw new \Exception("Invalid Entity object: '$value' is not an instance of Raman\Doctrine\Raman_Doctrine_Entity");	                  
		          break;		        
		            
	            case 'doctrine':
	                if($value instanceof \Bisna\Doctrine\Container)
	                    $this->doctrine = $value;
	                else
	                   throw new \Exception("Invalid Doctrine object: '$value' is not an instance of Bisna\Doctrine\Container");
	               break;
	                
                case 'entityManager':
                    if($value instanceof \Doctrine\ORM\EntityManager)
                        $this->entityManager = $value;
                    else
                        throw new \Exception("Invalid Doctrine Entity Manager object: '$value' is not an instance of Doctrine\ORM\EntityManager");
                    break;
                    
                    
                case 'queryBuilder':
                    if($value instanceof \Doctrine\ORM\QueryBuilder)
                        $this->queryBuilder = $value;
                    else
                        throw new \Exception("Invalid Doctrine Query Builder object: '$value' is not an instance of Doctrine\ORM\QueryBuilder");
                    break;
		        
		        default:
		            $this->$name = $value;
		    }			
		}
		
		
		if(!isset($this->alias))
		    $this->alias = strtolower(array_pop(explode("\\", get_class($this->entity))));
		
		/*
		 * set doctrine if not currently set
		 */
		if(!isset($this->doctrine))
		    $this->doctrine = \Zend_Registry::get('doctrine');
		
		
		/*
		 * set entity manager if not currently set
		 */
		if(!isset($this->entityManager))
		    $this->entityManager = $this->doctrine->getEntityManager();
		
		
		/*
		 * set query builder if not currently set
		 */
		if(!isset($this->queryBuilder))
		    $this->queryBuilder = $this->entityManager->createQueryBuilder();
					
		
		
		/*
		 * call init()
		 */
		$this->init();
	}	
	
	
	/**
	 * If you want to have some initialize statements in your extended class, overwrite this function
	 */
	protected function init()
	{
	    
	}
	
	
	/**
	 * Set Entity object
	 * @param Raman_Doctrine_Entity $entity
	 * @return \Raman\Doctrine\Raman_Doctrine_Adapter
	 * @see Raman_Doctrine_Entity
	 */
	public function setEntity($entity)
	{
	    $this->entity  = $entity;			
	    $this->alias = strtolower(array_pop(explode("\\", get_class($this->entity))));
		
		return $this;
	}
	
	
	/**
	 * Get Entity object
	 * @return Raman_Doctrine_Entity
	 * @see Raman_Doctrine_Entity
	 */
	public function getEntity()
	{
		return $this->entity;
	}
	
	
	/**
	 * Set Doctrine object
	 * @param \Bisna\Doctrine\Container $doctrine
	 * @return \Raman\Doctrine\Raman_Doctrine_Adapter
	 * @see \Bisna\Doctrine\Container
	 */
	public function setDoctrine($doctrine)
	{
	    $this->doctrine = $doctrine;
	    
	    return $this;
	}
	
	
	/**
	 * Get Doctrine object
	 * @return \Bisna\Doctrine\Container
	 * @see \Bisna\Doctrine\Container
	 */
	public function getDoctrine()
	{
	    return $this->doctrine;
	}
	
	
	/**
	 * Set entityManager with given value
	 * @param \Doctrine\ORM\EntityManager $entityManager If null given set entity manager with present Doctrine object
	 * @return Raman_Doctrine_Adapter
	 * @see \Doctrine\ORM\EntityManager
	 * @see Raman_Doctrine_Adapter
	 */
	public function setEntityManager($entityManager=null)
	{
	    if(is_null($entityManager))
	    {
	        if(isset($this->doctrine))
	            $this->entityManager = $this->doctrine->getEntityManager();
	        else
	            throw new \Exception("The Doctrine object has not set.");
	    }
	    else 
	    {
	        if($entityManager instanceof \Doctrine\ORM\EntityManager)
	            $this->entityManager = $this->doctrine->getEntityManager();
	        else
	            throw new \Exception("The given value for Entity Manager object is not an instance of Doctrine\ORM\EntityManager .");
	    }	    	    
	    
	    return $this;
	}
	
	/**
	 * Get entityManager's value
	 * @return \Doctrine\ORM\EntityManager
	 * @see \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
	    return $this->entityManager;
	}
	
	/**
	 * Get queryBuilder's value
	 * @return \Doctrine\ORM\QueryBuilder
	 * @see \Doctrine\ORM\QueryBuilder
	 */
	public function getQueryBuilder()
	{
	    return $this->queryBuilder;
	}
	
	
	/**
	 * Insert multi-rows at once
	 * @param array $rows The rows for insert
	 * @return array The primary keys of inserted rows
	 */
	public function insert(array $rows)
	{
	    /*
	     * initial values
	     */
	    $entityClass   = get_class($this->entity);
	    $entities      = array();
	    $return        = array();
	    $count         = 0;
	    
	    
	    /*
	     * insert all rows
	     */
	    foreach($rows as $row)
	    {
	        $entities[] = new $entityClass($row);	   
	        $count++;
	        
	        $this->entityManager->persist($entities[$count-1]);
	    }
	
	    /*
	     * commit
	     */
	    $this->entityManager->flush();
	    
	    
	    /*
	     * get primary-keys
	     */
	    foreach($entities as $entity)
	        $return[] = $entity->get('id');
	    
	    
	    /*
	     * return primary-keys in array
	     */
	    return $return;
	}
	
	
	/**
	 * Update multi-rows at once where clauses has been satisfied
	 * @param array $data The new column's values
	 * @param array $where Build WHERE clauses
	 * @return integer number of updated rows
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function update(array $data, array $where)
	{
	   /*
	    * get entities
	    */ 
	   $entities = $this->getRowsBy($where);
	   
	   /*
	    * update entities
	    */
	   return $this->updateByEntity($data, $entities);
	}
	
	/**
	 * Update multi-entities at once
	 * @param array $data The new column's values
	 * @param array $entities An array of Raman_Doctrine_Entity
	 * @return integer number of updated rows
	 * @see Raman_Doctrine_Entity
	 */
	public function updateByEntity(array $data, $entities)
	{
	   foreach ($entities as $entity)
	   {
	       /*
	        * update entities
	        */
	       foreach ($data as $key => $value)
	       {
	           $entity->set($key, $value);
	           $this->entityManager->persist($entity);
	       }
	   }
	       
	   /*
	    * commit
	    */
	   $this->entityManager->flush();
	}
	
	/**
	 * Delete multi-rows at once where clauses has been satisfied
	 * @param array $data The new column's values
	 * @param array $where Build WHERE clauses
	 * @return integer number of updated rows
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function delete(array $where)
	{
	    /*
	     * get entities
	     */
	    $entities = $this->getRowsBy($where);
	    
	    /*
	     * delete entities
	     */
	    return $this->deleteByEntity($entities);
	}
	
	
	/**
	 * Delete multi-entities at once
	 * @param array $data The new column's values
	 * @param array $entities An array of Raman_Doctrine_Entity
	 * @return integer number of updated rows
	 * @see Raman_Doctrine_Entity
	 */
	public function deleteByEntity($entities)
	{
	    
	    /*
	     * remove entities
	     */
	    foreach($entities as $entity)
	        $this->entityManager->remove($entity);
	    
	    
	    /*
	     * commit
	     */
	    $this->entityManager->flush();
	    
	}
	

	/**
	 * Get first resutl of current query.
	 * @return \Doctrine\ORM\mixed The first result
	 */
	public function getRow()
	{	    
	    return $this->queryBuilder
	    ->select($this->alias)
	    ->from(get_class($this->entity), $this->alias)
	    ->getQuery()    
	    ->setCacheable(\Zend_Registry::get('cacheDataEnable'))
	    ->useResultCache(\Zend_Registry::get('cacheDataEnable'))
	    ->useQueryCache(\Zend_Registry::get('cacheDataEnable'))
	    ->setResultCacheLifetime(\Zend_Registry::get('cacheDataLifeTime'))
	    ->setQueryCacheLifetime(\Zend_Registry::get('cacheDataLifeTime'))
	    ->getOneOrNullResult();
	}	
	
	/**
	 * Get all results of current query. It's different with getAll()
	 * @return array All results
	 * @see Raman_Doctrine_Adapter::getAll()
	 */
	public function getRows()
	{
	    return $this->queryBuilder
	    ->select($this->alias)
	    ->from(get_class($this->entity), $this->alias)
	    ->getQuery()
	    ->setCacheable(\Zend_Registry::get('cacheDataEnable'))
	    ->useResultCache(\Zend_Registry::get('cacheDataEnable'))
	    ->useQueryCache(\Zend_Registry::get('cacheDataEnable'))
	    ->setResultCacheLifetime(\Zend_Registry::get('cacheDataLifeTime'))
	    ->setQueryCacheLifetime(\Zend_Registry::get('cacheDataLifeTime'))
	    ->getResult();
	}
	
	/**
	 * Get all rows in this table
	 * @return array The entities
	 */
	public function getAll()
	{
	    return $this->entityManager
	    ->getRepository(get_class($this->entity))
	    ->findAll();
	}
	
	
	/**
	 * Get row by it's Primary-Key
	 * @param integer $id The Primary-Key
	 * @return Raman_Doctrine_Entity The entity instance or NULL if the entity can not be found.
	 */
	public function getRowById($id)
	{	    
	    return $this->entityManager
	    ->getRepository(get_class($this->entity))
	    ->find($id);	    
	}
	
	
	/**
	 * Get the first row
	 * @param array $where Build WHERE clauses
	 * @return Raman_Doctrine_Entity The entity instance or NULL if the entity can not be found.
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function getRowBy(array $where)
	{
	   return $this->entityManager
	   ->getRepository(get_class($this->entity))
	   ->findOneBy($where);
	}		
	
	/**	 
	 * Get limited results
	 * @param array $where Build where clauses 
	 * @param array $order The order of results
	 * @param integer $limit The number of results
	 * @param integer $offset The offset of results
	 * @return Raman_Doctrine_Entity Results
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function getLimitedRowsBy(array $where, $limit, $offset, array $order=null)
	{
	    return $this->entityManager
	    ->getRepository(get_class($this->entity))
	    ->findBy($where, $order, $limit, $offset);
	}
	
	
	/**
	 * Get all results
	 * @param array $where Build WHERE clauses
	 * @param array $order The order of results
	 * @return Raman_Doctrine_Entity Results
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function getRowsBy(array $where, array $order=null)
	{
	    return $this->entityManager
	    ->getRepository(get_class($this->entity))
	    ->findBy($where, $order);
	}
		
	
	/**
	 *
	 * @param array $tables The entities' name and maybe their aliases
	 * @return Raman_Doctrine_Adapter
	 */
	public function from(array $tables)
	{
	    foreach($tables as $alias => $from)
	        $this->queryBuilder = $this->queryBuilder->from($from, $alias);
	     
	    return $this;
	}
	
	
	/**
	 * Join current entity with given entity
	 * @param array $join The relationship to join
	 * @param array|string $clauses
	 * @return Raman_Doctrine_Adapter
	 * @see Raman_Doctrine_Adapter::leftJoin()
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function join(array $join, $clauses)
	{
	    foreach ($join as $alias => $property)
	        $this->queryBuilder = $this->queryBuilder->join($property, $alias, 'ON', $this->whereParse($clauses));
	    
	    return $this;
	}
	
	/**
	 * Join current entity with given entity, but it don't add new columns to the result
	 * @param array $join The relationship to join
	 * @param array|string $clauses
	 * @return Raman_Doctrine_Adapter
	 * @see Raman_Doctrine_Adapter::join()
	 * @see Raman_Doctrine_Adapter::whereOr()
	 * @see Raman_Doctrine_Adapter::whereAnd()
	 */
	public function leftJoin(array $join, $clauses)
	{
	    foreach ($join as $alias => $property)
	        $this->queryBuilder = $this->queryBuilder->leftJoin($property, $alias, 'ON', $this->whereParse($clauses));
	    
	    return $this;
	}
	

	/**
	 * Create WHERE query and put AND between clauses
	 * @param array $where
	 * @return array The where clauses. It could be use as input of all functions in this class that have $where or $clause argument
	 */
	public function whereAnd(array $where)
	{
	    $output = array();
	    
	    foreach($where as $key => $value)
	    {
            $output['AND'][] = array(
                $key => $value
            );
	    }
	    
	    return $output;
	}
	
	
	/**
	 * Create WHERE query and put OR between clauses
	 * @param array $where
	 * @return array The where clauses. It could be use as input of all functions in this class that have $where or $clause argument
	 */
	public function whereOr(array $where)
	{
	    $output = array();
	     
	    foreach($where as $key => $value)
	    {
	        $output['OR'][] = array(
	            $key => $value
	        );
	    }
	     
	    return $output;
	}
	
	/**
	 * Parse $where array to SQL format
	 * @param array $where
	 * @return string The WHERE clause in SQL format
	 */
	protected function whereParse(array $where)
	{
	    $output = '';
	    
	    foreach($where as $operand => $clause)
	    {
    	    foreach($clause as $key => $value)
    	    {
    	        if(is_array($value))
    	        {
    	            //$value is an array of SQL `WHERE` clauses
    	    
    	            foreach ($value as $sql)
    	                $output .= " ($sql) $operand";
    	        }
    	        else
    	        {
    	            //$key is column name and $value is it's value
    	    
    	            $output .= " `$key`='$value' $operand";
    	        }
    	         
    	        $output = rtrim($output, "$operand");
    	    }
	    }
	    
	    return $output;
	}
					
}