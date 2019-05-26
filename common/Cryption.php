<?
namespace common;
class Cryption
{

	function __construct(){

        $this->method = array(
            'AES-128-CBC',
            'AES-128-CFB',
            'AES-128-CFB1',
            'AES-128-CFB8',
            'AES-128-OFB',
            'AES-192-CBC',
            'AES-192-CFB',
            'AES-192-CFB1',
            'AES-192-CFB8',
            'AES-192-OFB',
            'AES-256-CFB',
            'AES-256-CFB1',
            'AES-256-CFB8',
            'AES-256-OFB'
        );



	}

	function set($type=0,$key){
        $this->type = $this->method[$type];
        $this->key = $key;
	}

	function encrypt($data){

        if($this->type && $this->key) @$result = openssl_encrypt($data,$this->type,$this->key);

		return $result;
	}



	function decrypt($data){

        if($this->type && $this->key) @$result = openssl_decrypt($data,$this->type,$this->key);

		return $result;

	}



}



?>
