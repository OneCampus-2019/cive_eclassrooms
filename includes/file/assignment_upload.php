<?php
// connect to the databas
// Uploads files
use App\DB;
$conn = DB::getConnection();
if (isset($_POST['newass'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];
    $expr = $_POST['expr'];
    $owner = $_POST['inst'];
    $course = $_POST['course'];
    $as_in = $_POST['as_in'];
    $title = $_POST['title'];
    $q_max=NULL;
    if(isset($_POST['q_max']) && !empty($_POST['q_max'])){$q_max=$_POST['q_max'];}
    
   

    if(empty($_POST['tm'])){
        $tm = 0;
    }else{
         $tm = $_POST['tm'];
    }
    if ($as_in === "material" || $as_in === "tutorial") {
        $expr = date("Y-m-d",strtotime('+5 years'));
    }

    if (!isset($expr) || empty($expr)) {
        echo "<script>alert('Please Set The Expire Date.')</script>";
    }else{
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

    if (!in_array($extension, ['zip', 'pdf', 'docx', 'pptx', 'ppt', 'doc','mp3','mp4','gif','jpeg','jpg','png','csv','flv','wav','xls','xlsx','PNG'])) {
        
        echo "<script>alert('Unsupported File Extension')</script>";
    } elseif ($_FILES['myfile']['size'] > 600000000) { // file shouldn't be larger than 10Megabyte
        echo "<script>alert('File too large.')</script>";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            
          $conn->beginTransaction();
            $req0=$conn->prepare("INSERT INTO `tbl_logs`(username,action,Description) VALUES(:username,:action, :description) ");
            $req0->execute([':username'=>$n, ':action'=>'upload', ':description'=>'Create lab']);
           
            $req1 = $conn->prepare("INSERT INTO `tbl_uploads` (title, file_name, size,pathd, no_downloads,owner,for_course,expire_date,as_in,total_marks,notify) VALUES (:title, :file_name, :size, :pathd, :no_downloads, :owner, :for_course, :expire_date,:as_in,:total_marks, :notify)");
            $req1->execute([':title'=>$title, ':file_name'=>$filename, ':size'=>$size, ':pathd'=>$destination, ':no_downloads'=>0, ':owner'=>$owner, ':for_course'=>$course, ':expire_date'=>$expr, ':as_in'=>$as_in, ':total_marks'=>$tm, ':notify'=>'']);
            
            //selecting the last input
            if($req1)
            {
            $last_ass=$conn->lastInsertId();
            }

            //inserting the assignment questions and maxima
            $done=false;
            if($q_max!=NULL){
            for($x=0;$x<count($q_max);$x++){
            $req2=$conn->prepare("INSERT INTO ass_questions (assID,Q_max) values(:assID,:Q_max)");
            $req2->execute([':assID'=>$last_ass, ':Q_max'=>$q_max[$x]]);
            if($req2)
            {
                $done=true;
            }
            }
            }else{print("<script>alert('mention at least one question and the maxima');</script>");}
            
            if($req0 && $req1 && $done)
            {
                $conn->commit();
                if($as_in==="lab"){
              
                echo "<script>alert('Lab created successfully')</script>";
            }else if($as_in==="tutorial"){
              
                echo "<script>alert('New tutorial created successfully')</script>";
            }else{
                 echo "<script>alert('Assignement created successfully')</script>";
            }
                 
                
                //AVOID SENDING DATA AGAIN AND AGAIN ON PAGE REFRESH
                echo "<script>
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
            </script>";
            }
            else
            {
              $conn->rollBack();
                echo "<script>alert('File not uploaded')</script>";  
            }
             
        } else {
            echo "<script>alert('Failed to upload file. Destination NotFound')</script>";
        }
    }
}
}

?>
