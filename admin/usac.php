<?php 
session_start(); 
include('../includes/db/db.php');
use App\DB;
if(hasAuthority('9')){

$conn = DB::getConnection();
	if (isset($_GET['idk'])) {
		$idk = $_GET['idk'];
		$stmt = $conn->prepare("UPDATE `tbl_users` SET active=0 WHERE id=:id");
		$stmt->execute([':id'=>$idk]);
		header('location: user_manage.php');
	}

	if (isset($_GET['idd'])) {
		$idd =$_GET['idd'];
		$st = $conn->prepare("UPDATE `tbl_users` SET active=1 WHERE id=:id");
		$st->execute([':id'=>$idd]);
		header('location: user_manage.php');
	}
}else { logOut(); }

?>