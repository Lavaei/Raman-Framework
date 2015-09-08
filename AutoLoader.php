<?php
namespace Raman;

use Raman\Config\Raman_Config_Consts;
use Raman\Config\Raman_Config_Configs;
use Raman\Config\Raman_Config_Adapter;

class AutoLoader
{
	/**
	 * 
	 * @var \Zend_Application_Bootstrap_Bootstrap
	 */
	protected $_bootstrap;
	
	
	protected $_siteConfigs;
	
	/**
	 * @param \Zend_Application_Bootstrap_Bootstrap $bootstrap
	 */
	public function __construct($bootstrap)
	{
		$this->_bootstrap 	= $bootstrap;	
	}
	
	public function init()
	{							
		mb_internal_encoding("UTF-8");
		date_default_timezone_set('UTC');
		
		$this->addAutoLoader();
		$this->includePaths();
		$this->bootDoctrine();
		$this->bootView();
		$this->configure();
		$this->initView();
		$this->initRoutes();
		$this->initSecurity();		
		$this->initFrontControllerOutput();	
		
	}	
	
	/**
	 * Add Raman Autoloader
	 * Add Vendor Autoloader
	 */
	protected function addAutoLoader()
	{								
		include_once 'Raman/AutoLoader.php';

		spl_autoload_register('\Raman\autoload');					
	}			
	
	protected function includePaths()
	{
		// Vendor
		ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR);		
		
		// Add Entity to include path
		ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'Entity' . DIRECTORY_SEPARATOR);
	
		// Add Models to include path
		ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APPLICATION_PATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR);
	
		// Add Forms to include path
		ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APPLICATION_PATH . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR);
	}
	
	
	protected function bootDoctrine()
	{
	    /* Using Doctrine with Bisna */
	    
	    $this->_bootstrap->bootstrap('doctrine');
	    $doctrine 	= $this->_bootstrap->getResource('doctrine');
	    
	    
	    $config = new \Doctrine\ORM\Configuration();
	    $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ApcCache());
	    $config->setResultCacheImpl(new \Doctrine\Common\Cache\ApcCache());
	    $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ApcCache());
	    
	    
	    \Zend_Registry::set('doctrine'         , $doctrine);
	    \Zend_Registry::set('cacheDataEnable'  , true);
	    \Zend_Registry::set('cacheDataType'    , 'APC');
	    \Zend_Registry::set('cacheDataLifeTime', 3600);
	}
	
	protected function bootView()
	{
	    if(!\Zend_Registry::isRegistered('view'))
	    {
	        $view = new \Zend_View();
	       \Zend_Registry::set('view', $view);
	    }
	}
	
	protected function configure()
	{
	    $configsXml 	= file_get_contents(APPLICATION_PATH . '/configs/configs.xml');
	    $dom 			= new \Zend_Dom_Query($configsXml);
	       
	    $dbUsername 	= $dom->query("Database Username")->current()->nodeValue;
	    $dbPassword 	= $dom->query("Database Password")->current()->nodeValue;
	    $dbName 		= $dom->query("Database Name")->current()->nodeValue;
	    $dbServer 		= $dom->query("Database Server")->current()->nodeValue;
	    
	    $doctrine              = \Zend_Registry::get('doctrine');
	
	    $ramanConfigAdapter    = new Raman_Config_Adapter();
	    $ramanConfigConfigs    = new Raman_Config_Configs();
	    	
	    $this->_siteConfigs               = $ramanConfigAdapter->getByProfileName();	    
	    		    
	    $ramanConfigConfigs->configDatabase($dbUsername, $dbPassword, $dbName, $dbServer);
	    $ramanConfigConfigs->configDataCaching($this->_siteConfigs->get('cacheDataEnable'), $this->_siteConfigs->get('cacheDataType'), $this->_siteConfigs->get('cacheDataLifeTime'));
	    $ramanConfigConfigs->configDefaultProtocol('http');
	    $ramanConfigConfigs->configRootUrl(DEFAULT_PROTOCOL . '://' . $this->_siteConfigs->get('domain'));
	    $ramanConfigConfigs->configSecureRootUrl(DEFAULT_PROTOCOL . 's://' . $this->_siteConfigs->get('domain'));
	    $ramanConfigConfigs->configSiteTitle($this->_siteConfigs->get('siteTitle'), $this->_siteConfigs->get('siteSeperator'));
	    $ramanConfigConfigs->configTemplate($this->_siteConfigs->get('siteTemplate')->get('id'), $this->_siteConfigs->get('siteTemplate')->get('name'));
	    $ramanConfigConfigs->configLanguage($this->_siteConfigs->get('siteLanguage')->get('id'), $this->_siteConfigs->get('siteLanguage')->get('shortName'), $this->_siteConfigs->get('siteLanguage')->get('fullName'));
	    $ramanConfigConfigs->configPiwik($this->_siteConfigs->get('piwikServer'), $this->_siteConfigs->get('piwikSiteID'));
	    $ramanConfigConfigs->configDescription($this->_siteConfigs->get('siteDescription'));
	    $ramanConfigConfigs->configSiteAuthors("Mostafa Lavaei <lavaei@ramansoft.co>");
	    $ramanConfigConfigs->configKeywords($this->_siteConfigs->get('siteKeywords'));	    	    

	}
	
	protected function initView()
	{
	    $siteMetaTags  = array();
	    $siteStyles    = array();
	    $siteScripts   = array();
	    
		$view = \Zend_Registry::get('view');
		$view->setEncoding('UTF-8');
		$view->doctype('XHTML1_STRICT');			
		
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
	
		$view->headLink()->appendStylesheet(ROOT_URL . 'libPlugins/bootstrap/css/bootstrap.min.css')
		->appendStylesheet(ROOT_URL . 'libPlugins/bootstrap/css/bootstrap-theme.min.css')
		->appendStylesheet(ROOT_URL . 'libPlugins/bootstrap-dialog/css/bootstrap-dialog.min.css')
		->appendStylesheet(ROOT_URL . 'libCss/Raman/Form-Responsive.css');				
	
		$view->headScript()->appendFile(ROOT_URL . 'libJs/jquery-1.11.1.min.js')
		->appendFile(ROOT_URL . 'libPlugins/bootstrap/js/bootstrap.min.js')
		->appendFile(ROOT_URL . 'libPlugins/bootstrap-dialog/js/bootstrap-dialog.min.js');		
			
		
		if($this->_siteConfigs)
		{
		    if($this->_siteConfigs ->get('siteMetaTags'))
		      $siteMetaTags = json_decode($this->_siteConfigs->get('siteMetaTags'));
		    
		    if($this->_siteConfigs ->get('siteStyles'))
		      $siteStyles   = json_decode($this->_siteConfigs->get('siteStyles'));
		    
		    if($this->_siteConfigs ->get('siteScripts'))
		      $siteScripts  = json_decode($this->_siteConfigs->get('siteScripts'));
		    
		    
		    foreach ($siteMetaTags as $name=>$value)
		    {
		        $view->headMeta()->appendHttpEquiv($name, $value);
		    }
		    
		    foreach($siteStyles as $style)
		    {
		        $view->headLink()->appendStylesheet(str_replace("<ROOT_URL>", ROOT_URL, $style));
		    }
		    
		    foreach($siteScripts as $script)
		    {
		        $view->headScript()->appendFile(str_replace("<ROOT_URL>", ROOT_URL, $script));
		    }
		}
	
		\Zend_Registry::set('view', $view);
	}
	
	protected function initRoutes()
	{
		$front = \Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		 
		/*
		 * Route Ajax Requests
		*/
		$router->addRoute('ajaxHandler', new \Zend_Controller_Router_Route('/:controller/ajax/:request/', array(
				'controller' 	=> ':controller',
				'action' 		=> 'ajax'
		)));
		 
		$router->addRoute('ajaxHandlerModules', new \Zend_Controller_Router_Route('/:module/:controller/ajax/:request/', array(
				'module' 		=> ':module',
				'controller' 	=> ':controller',
				'action' 		=> 'ajax'
		)));
	}
	
	protected function initSecurity()
	{	    
		new \Raman\Security\Raman_Security_Xss($this->_bootstrap);
		new \Raman\Security\Raman_Security_Csrf();
	}
	
			
	
	protected function initFrontControllerOutput()
	{
		$this->_bootstrap->bootstrap('FrontController');
		$frontController = $this->_bootstrap->getResource('FrontController');
		
		$response = new \Zend_Controller_Response_Http;
		$response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
		$frontController->setResponse($response);
		
		return $frontController;
	}
	
}

function autoload($className)
{
	$extensions 	= array(".php");//acceptable extentions
	$includePaths 	= explode(PATH_SEPARATOR, get_include_path());//include paths
	$exNameSpace 	= explode('\\', $className);//explode class name
	$pureClassName 	= $exNameSpace[sizeof($exNameSpace) - 1];// get class name witout its namespace
	$relativePath 	= str_replace("_" , DIRECTORY_SEPARATOR, $pureClassName);//the class path from include path

	foreach ($includePaths as $iPaths)
	{
		$absolutePath = $iPaths . DIRECTORY_SEPARATOR . $relativePath;	//absolute class path		
		foreach ($extensions as $ext)
		{
			if (is_readable($absolutePath . $ext))
			{
				require_once $absolutePath . $ext;				
				break;
			}
		}
	}
}