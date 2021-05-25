<?php
use App\DB;
$conn = DB::getConnection();
if (isset($_POST['ass_update'])) { // if save button on the form is clicked
    $expr = $_POST['expire_date'];
    $assid=Crypt::decrypt($_POST['assid']);

    if (!isset($expr) || empty($expr)) {
        echo "<script>alert('Please Set The Expire Date.')</script>";
    }else{
  
       
            
        
            $logsStmt=$conn->prepare("INSERT INTO `tbl_logs`(username,action,Description) VALUES(:username,:action,:description) ");
            $logsStmt->execute([':username'=>$n, ':action'=>'upload', ':description'=>'Updated assignment']);
           
            $updateStmt = $conn->prepare("UPDATE `tbl_uploads`  SET expire_date=:expire_date WHERE id=:id");
           $success =  $updateStmt->execute([':expire_date'=>$expr, ':id'=>$assid]);
           
             if($success){
                echo "<script>alert('Assignment updated')</script>";
             }
        } 
    }


?>