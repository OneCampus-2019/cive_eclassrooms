<?php 
 require_once('db/db.php');
 use App\DB;
if(isset($_POST['action'])){
   
	$conn = DB::getConnection();
    //delete comment/posts for instructor
	if($_POST['action'] == 'del_comment'){
		$cid = $_POST['cid'];
    $stm = $conn->prepare("DELETE FROM `tbl_coments` WHERE id=:id ");
     $success = $stm->execute([':id'=>$cid]);
     if($success){
     	echo json_encode(['status'=>'success', 'message'=>'Comment deleted']);
     }else {
     	echo json_encode(['status'=>'error', 'message'=>'Failed! Not deleted']);
     }
	}
    //delete comment/post for students
        if($_POST['action'] == 'std_del_comment'){
        $cid = $_POST['cid'];
    $stm = $conn->prepare("DELETE FROM `tbl_coments` WHERE id=:id ");
     $success = $stm->execute([':id'=>$cid]);
     if($success){
        echo json_encode(['status'=>'success', 'message'=>'Comment deleted']);
     }else {
        echo json_encode(['status'=>'error', 'message'=>'Failed! Not deleted']);
     }
    }
 }
 //function to check whether student submited task or not
 function isSubmitted($sid, $assId){
    //include('db.php');
    $conn = DB::getConnection();
    $stmt = $conn->prepare("SELECT * FROM tbl_submit WHERE file_task_name=:file_task_name AND uploaded_by=:uploaded_by");
    $stmt->execute([':file_task_name'=>$assId, ':uploaded_by'=>$sid]);
    if($stmt->rowCount() > 0){
        return true;
    }else{
        return false;
    }


 }
 //CHECK IF USE IS EXISTS 
 function exists($table, $column, $userid){
    $conn = DB::getConnection();
    $stmt = $conn->prepare("SELECT * FROM $table WHERE $column=:userid");
    $stmt->execute([':userid'=>$userid]);
    if($stmt->rowCount() > 0){
        return true;
    }else{
        return false;
    }

 }
 //get taskfile name(this is used as assigment/lab id)
 function getOutofMarks($assid){
    $conn = DB::getConnection();
    $stmt = $conn->prepare("SELECT outof FROM tbl_coursework WHERE ass_id=:ass_id");
    $stmt->execute([':ass_id'=>$assid]);
    $ass = $stmt->fetch(PDO::FETCH_OBJ);
    $outof = $ass->outof;
    return $outof;

 }
 //get student score
 function score($sid, $assid){
    $conn = DB::getConnection();
    $stmt = $conn->prepare("SELECT * FROM tbl_submit WHERE file_task_name=:file_task_name AND uploaded_by=:uploaded_by");
    $stmt->execute([':file_task_name'=>$assid, ':uploaded_by'=>$sid]);
    $student = $stmt->fetch(PDO::FETCH_OBJ);
    return $student->result;

 }
 ?>
