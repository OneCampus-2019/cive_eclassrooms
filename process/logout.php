<?php 
session_start();
include('../includes/db/db.php');
	use App\DB;
	$conn = DB::getConnection();
		if ($_SESSION['level'] === '8' OR $_SESSION['level'] === '9' OR $_SESSION['level'] === '7') {
			$stmt = $conn->prepare("INSERT INTO tbl_logs SET username=:username, action=:action, Description=:Description");
			$stmt->execute([':username'=>$_SESSION['user'], ':action'=>'Loggedout', ':Description'=>'Logged Out From the System']);
		}elseif($_SESSION['level'] === '0'){
			$stmt = $conn->prepare("INSERT INTO tbl_logs SET username=:username, action=:action, Description=:Description");
			$stmt->execute([':username'=>$_SESSION['email'], ':action'=>'Loggedout', ':Description'=>'Logged Out From the System']);
		}
		unset($_SESSION['user']);
		unset($_SESSION['level']);
		unset($_SESSION['email']);
		
		session_destroy();
		header("location: ../index");

	

 ?>