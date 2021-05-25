<?php
//include('db.php');
USE APP\DB;
//checking if the session is not set then back to log
if(!isset($_SESSION["user"]) && !isset($_SESSION['level']))
{	
	header("Location: ../process/logout");
	exit();
}else{
	//creating session variables
	$u = $_SESSION['user']; //useer from tbl users
	$l = $_SESSION['level']; 
	$e = $_SESSION['email'];
	$n = $_SESSION['name']; //name from tbl users
	if ($l === '7') {
		$lv = "Instructor";
	}elseif($l === '8'){
		$lv = "H.O.D";
	}elseif($l === '9'){
		$lv = "Administrator";
	}elseif($l === '0'){
		$lv = "Student";
		$conn = DB::getConnection();
		$stmt = $conn->prepare("SELECT * FROM `tbl_students` WHERE registration_no =:registration_no");
		$stmt->execute([':registration_no'=>$e]);
		$student = $stmt->fetch(PDO::FETCH_OBJ);
		$imn = $student->id;
	}


}
//check if user has authority
function hasAuthority($level){
	if($level === $_SESSION['level']){
	return true;
	}else{
		return false;
	}

}
//redirect user to login page if trying to access page which has no authority
function logOut(){
	 echo "<script>window.location.href='../process/logout'</script>";

}

?>