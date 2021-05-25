<?php  
require '../vendor/autoload.php';
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
class Crypt{
	//public $key = $this->getKey();
	public  static function encrypt($message){
		return Crypto::encrypt($message, self::getKey());

	}
	public static function decrypt($message){
		try{
		if($message == NULL){
			return;
		}
		$decrypted = Crypto::decrypt($message, self::getKey());
	}catch(Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex ){
		// header('Location'.$_SERVER["REQUEST_URI"]);
		return;

	}
		return $decrypted;
	}

	

	public static function getKey(){
    $keyAscii = trim(file_get_contents("../crypt/key.txt"));
    return Key::loadFromAsciiSafeString($keyAscii);
}

}
 ?>
