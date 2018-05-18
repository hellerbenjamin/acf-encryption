<?php
/* Plugin Name: Encryption
*/

require __DIR__ . '/vendor/autoload.php';
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;


class Encrypt {

	private $key;

	public function __construct() {
		$this->key = $this->load_key();
	}

	private function load_key() {
		$keyAscii = file_get_contents( __DIR__ . '/../../../../private_html/key.txt' );
        return Key::loadFromAsciiSafeString($keyAscii);
	}


	public function encrypt( $value ) {
		$value =  Crypto::encrypt( $value, $this->key );
		return $value;
	}

	public function decrypt( $value ) {
		try {
			$value = Crypto::decrypt( $value, $this->key);
		} catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
			mail("ben@benjaminheller.net","Decrypt Fail",'Decryption Failed in client portal' );
		}

		return $value;

	}




}

