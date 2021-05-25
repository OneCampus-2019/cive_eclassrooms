<?php 
	/*define('DB_SERVER','localhost');
	define('DB_USER','root');
	define('DB_PASS' ,'');
	define('DB_NAME', 'ecive_database');
	$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);*/
	namespace App;
	use PDO;
	class DB{
		
		public static function getConnection(){
		$conn = new PDO('mysql:host=192.168.3.23; dbname=ecive_db;', 'eciveuser', 'eciveuser@info123');
		try{
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo $e->getMessage();

		}
		return $conn;
		}
	}
?>
