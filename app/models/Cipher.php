<?php

/*
    简单加密解密类
*/

class Cipher 
{
    private $securekey, $iv;

    function __construct($textkey = 'AES/ECB/PKCS5Padding/very-secret-key') 
    {
        $this->securekey = hash('sha256',$textkey,TRUE);
        $this->iv = mcrypt_create_iv(32, MCRYPT_RAND);
    }

    /* 加密 */
    function encrypt($input) 
    {
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $input, MCRYPT_MODE_ECB, $this->iv));
    }

    /* 解密 */
    function decrypt($input) 
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, base64_decode($input), MCRYPT_MODE_ECB, $this->iv));
    }
    
}