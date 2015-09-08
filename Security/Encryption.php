<?php
namespace Raman\Security;

/**
 * Raman Secure Encryption
 *
 * @author Mostafa Lavaei <lavaei@ramansoft.co>
 * @version 1.0
 */

class Raman_Security_Encryption
{	
	protected $hash 	= 'SHA256';
	protected $password;
	protected $salt;
	
	/**
	 * @param array $configs You can set hash, password and salt if you need
	 */
	public function __construct($configs=array())
	{
		if(array_key_exists('hash', $configs))
			$this->hash 	= $configs['hash'];
		
		if(array_key_exists('salt', $configs))
			$this->salt 	= $configs['salt'];
		else 
			$this->salt 	= date("(M)*(-d#^):(y+h@si)", time() - rand(1000, 1000000));
		

		if(array_key_exists('password', $configs))
			$this->password 	= $configs['password'];
		else
			$this->password 	= date("(M)*(-d#^):(y+h@si)", 2713711821370);		
	}
	
	/**
	 * Encrypt the plaintext using hash and salt
	 * @param string $plainText
	 * @return boolean|string
	 */
	public function encrypt($plainText)
	{
			
		$key = hash($this->hash, $this->salt . $this->password, true);

		srand();
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		
		if(strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22)
			return false;
		
		$cypherText = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plainText . md5($plainText), MCRYPT_MODE_CBC, $iv));
		
		
		return $iv_base64 . $cypherText;
	}
	
	/**
	 * Decrypt the cyphertext using hash and salt
	 * @param string $plainText
	 * @return boolean|string
	 */
	public function decrypt ($cypherText)
	{
		
		if(strlen($cypherText) < 22)
			return false;

		$key = hash($this->hash, $this->salt . $this->password, true);

		$iv = base64_decode(substr($cypherText, 0, 22) . '==');

		$cypherText = substr($cypherText, 22);

		$plainText = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($cypherText), MCRYPT_MODE_CBC, $iv), "\0\4");

		$hash = substr($plainText, -32);

		$plainText = substr($plainText,0, -32);
		
		if(md5($plainText) != $hash)
			return false;
	
		return $plainText;
	}
	
	public function hash($plainText)
	{
		return  md5(md5("(M)*(-d#^):(y+h@si)") . $plainText);		
	}
}