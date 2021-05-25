<?php
require_once('../includes/db/db.php');
use App\DB;
$conn = DB::getConnection();
// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];
    $owner = $_POST['inst'];
    $course = $_POST['course'];
    $title = "";
    $as_in = $_POST['as_in'];
    if($as_in === 'tutorial'){
        $title = $_POST['title'];
    }
    

    $filename = str_replace(" ", "_", $filename);
    // destination of the file on the server
    $filename =$course.'_'.time().'_'.$filename;
    $destination = '../upload/data/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //$d = 'notes/'. $filename;

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
	$tm = 0;

    if (!in_array($extension, ['zip', 'pdf', 'docx', 'pptx', 'ppt', 'doc','mp3','mp4','gif','jpeg','jpg','png','csv','flv','wav','xls','xlsx','png','PNG', 'MKV', 'mkv'])) {
        
        echo "<script>alert('Unsupported File Extension')</script>";
    } elseif ($_FILES['myfile']['size'] > 800000000) { // file shouldn't be larger than 10Megabyte
        echo "<script>alert('File too large.')</script>";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            // echo "<script>alert('Zimetoka but hazijafika')</script>";
            //end this file to another folder
            //copy($destination, $d);

            //here to put the query
            try{

                $conn->beginTransaction();
                $stmt1 = $conn->prepare("INSERT INTO `tbl_uploads` (title, file_name, size,pathd, no_downloads,owner,for_course,expire_date,as_in,total_marks,notify) VALUES (:title, :file_name, :size,:pathd, :no_downloads, :owner, :for_course, :expire_date, :as_in, :total_marks, :notify)");
                $stmt1->execute([':file_name'=>$filename, ':size'=>$size, ':pathd'=>$destination, ':no_downloads'=>0, ':owner'=>$owner, ':for_course'=>$course, ':expire_date'=>'', ':as_in'=>$as_in, ':total_marks'=>0, ':notify'=>'', ':title'=>$title]);


                $stmt2 = $conn->prepare("INSERT INTO `tbl_logs`(username,action,Description) VALUES(:username, :action, :Description) ");
                $stmt2->execute([':username'=>$n, ':action'=>'upload', ':Description'=>'Upload Materials into the system']);
                $conn->commit();
                 echo "<script>alert('File uploaded successfully')</script>";
                 echo "<script>
                 if(window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                 }
                 </script>";

            }catch(Exception $e){
                $conn->rollBack();
                 echo "<script>alert('Something went wrong".$e->getMessage()."')</script>";

            }
           
         
            
        } else {
            echo "<script>alert('Failed to upload file. Destination NotFound')</script>";
        }
    }

}

?>
