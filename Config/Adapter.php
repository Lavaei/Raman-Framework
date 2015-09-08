<?php
namespace Raman\Config;

use Raman\Doctrine\Raman_Doctrine_Adapter;

/**
 * An interface to get or set configs from database
 * @author Mostafa Lavaei
 * @version 0.1
 * @copyright Ramansoft
 */
class Raman_Config_Adapter extends Raman_Doctrine_Adapter
{        
    protected function init()
    {
        $this->setEntity(new \Application\Entity\Configs);        
    }
    
    /**
     * Get configs by profile's name
     * @param unknown $profileName
     */
    public function getByProfileName($profileName='default')
    {
        $queryBuilder   = $this->getQueryBuilder();
        $entityName     = get_class($this->entity);
        $alias          = '_' . $this->alias;           
        
        
        return $queryBuilder->select($alias, 'siteLanguage', 'siteTemplate')
        ->from($entityName, $alias)
        ->join("$alias.siteLanguage", 'siteLanguage')
        ->join("$alias.siteTemplate", 'siteTemplate')
        ->getQuery()
        ->setCacheable(\Zend_Registry::get('cacheDataEnable'))
        ->useResultCache(\Zend_Registry::get('cacheDataEnable'))
        ->useQueryCache(\Zend_Registry::get('cacheDataEnable'))
        ->setResultCacheLifetime(\Zend_Registry::get('cacheDataLifeTime'))
        ->setQueryCacheLifetime(\Zend_Registry::get('cacheDataLifeTime'))
        ->getOneOrNullResult();
    }
}