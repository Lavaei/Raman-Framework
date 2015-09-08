<?php
namespace Raman\Translate\Adapter;

/**
 * Translate text with Bing translate.
 * Call when no translation available for given text
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */
class Raman_Translate_Adapter_Bing
{
	/**
	 * Get it from Microsoft.com
	 * @var string
	 * @see https://msdn.microsoft.com/en-us/library/hh454950.aspx
	 */
	protected $clientId 	= 'Raman_Framework';
	
	
	/**
	 * Get it from Microsoft.com
	 * @var string
	 * @see https://msdn.microsoft.com/en-us/library/hh454950.aspx
	 */
	protected $clientSecret = 'zYXK194D1xHyWJhy9z8zJRsbAD8Jbuq88YFOe3rM8Mg=';
	
	
	/**
	 * 
	 * @var string
	 */
	protected $scope 		= 'http://api.microsofttranslator.com';
	
	
	/**
	 * 
	 * @var string
	 */
	protected $grantType 	= 'client_credentials';
	
	
	/**
	 * The access token to use bing translate service
	 * @var string
	 */
	protected $accessToken;
	
	
	public function __construct()
	{
		
	}

	public function translate($text, $from='en', $to='fa')
	{
				
		$this->getAccessToken();
		
		$queryString 	.= "?text=" 	. $text;
		$queryString 	.= "&from=" 	. $from;
		$queryString 	.= "&to=" 		. $to;
		
		$header 		.= "Authorization=Bearer " . $this->accessToken;
		
		$ch 	= curl_init('http://api.microsofttranslator.com/v2/Http.svc/Translate' . $queryString);
		
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization:Bearer ' . $this->accessToken
		));
		
		$response = curl_exec($ch);
		
		curl_close($ch);
		
		return $response;
	}
	
	/**
	 * Set Account Key. you can get a key from Microsoft.com
	 * @see https://msdn.microsoft.com/en-us/library/hh454950.aspx
	 */
	public function setClientId($clientId)
	{
		$this->clientId 	= $clientId;
	}
	
	/**
	 * Set Customer ID. you can get an id from Microsoft.com
	 * @see https://msdn.microsoft.com/en-us/library/hh454950.aspx
	 */
	public function setClientSecret($clientSecret)
	{
		$this->clientSecret = $clientSecret;
	}
	
	
	protected function getAccessToken()
	{
		$postParams .= "client_id=" 		. urlencode($this->clientId);
		$postParams .= "&client_secret=" 	. urlencode($this->clientSecret);
		$postParams .= "&grant_type=" 		. $this->grantType;
		$postParams .= "&scope=" 			. $this->scope;		
		
		$ch 	= curl_init('https://datamarket.accesscontrol.windows.net/v2/OAuth2-13');		
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);				
		
		$response = curl_exec($ch);
		
		curl_close($ch);						
		
		$response 			= json_decode($response);
		
		$this->accessToken 	= $response->access_token;	
	}
}