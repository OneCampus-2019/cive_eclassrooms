<?php
session_start();
include('../includes/db/db.php');
include('../classes/sec.php');
require_once('../includes/auth.php');
require_once('../classes/sec.php');
use App\DB;
if(hasAuthority('0')){
$conn = DB::getConnection();
//$con = mysqli_connect('localhost', 'root', '', 'projectsend');
// Downloads files
if (isset($_GET['file_id'])) {
    $id = Crypt::decrypt($_GET['file_id']);

    // fetch file to download from database
    $sql = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE id=:id");
    $sql->execute([':id'=>$id]);

    $file = $sql->fetch(PDO::FETCH_ASSOC);
    //$filepath = '../../upload/data' . $file['file_name'];
    //$filepath = '../../upload/data/'.$file['file_ans'];
    if($file != null){
    $filepath = $file['pathd'];
}
    //echo $filepath;
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
 
        // Now update downloads count
        //$newCount = $file['no_downloads'] + 1;
        //$updateQuery = "UPDATE `tbl_uploads` SET no_downloads=$newCount WHERE id=$id";
        //mysqli_query($con, $updateQuery) or die(mysqli_error($con));
         ?> <script>
        alert('File Successfull Downloaded....');
        window.location.href= '../../mycourse.php';
        </script> <?php 
        //header('location: ../list_of_my_courses.php');
        exit();
    }else{
        echo "imekataa".$filepath;
    }

}
}else{
    logOut();
}

?>