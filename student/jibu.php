<?php
include('../includes/db/db.php');
use App\DB;
$conn = DB::getConnection();
 if(isset($_POST["id"]))  
 {  
 	$k = $_POST["id"];
 	$v = explode(",", $k);
 	$id = $v[0];
 	$jina = $v[1];
      //$output = '';  
        
      $query = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE `id` = :id");  
      $query->execute([':id'=>$id]);
      //$output .= '';  
      while($row = $query->fetch(PDO::FETCH_ASSOC))  
      { 
      	echo ' 


<form action="jibu.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
			 	<h3>Upload File</h3>	
			 	<div class="form-group">
					<label for="file" class="col-sm-2 control-label">
						File					
					</label>
					<div class="col-sm-6">
						<input type="file" name="myfile" class="form-control-file" id="customFile">
					</div>
				</div>

				<div class="form-group">
					<label for="file" class="col-sm-2 control-label">
						File Type					
					</label>
					<div class="col-sm-6">
					<select class="form-control" name="tp">
						<option value="">Choose type</option>
						<option value="quiz">QUIZ</option>
						<option value="assignment">ASSIGNMENT</option>
						<option value="lab">LAB</option>
					</select>
					</div>
				</div>
				
				<div class="inside_form_buttons">
					<button type="submit" name="save2" class="btn btn-wide btn-primary">UPLOAD</button>
				</div>

				<input type="text" name="jina" value="';echo $jina;echo'" style="visibility:hidden;">
			 	<input type="text" name="fname" value="';echo $row['file_name'];echo'" style="visibility:hidden;">
			 	<input type="text" name="owner" value="';echo $row['owner'];echo'" style="visibility:hidden;">
			 	<input type="text" name="for_course" value="';echo $row['for_course'];echo'" style="visibility:hidden;">
                <input type="text" name="tm" value="';echo $row['total_marks'];echo'" style="visibility:hidden;">
			 	<input type="text" name="as_in" value="quiz" style="visibility: hidden;">
			    
			</form> ';
         
      }  
      // $output .= "";  
      // echo $output;  
 }else{
  echo "";
 } 


 //sending file mechanism
 // Uploads files
if (isset($_POST['save2'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];
    $tp = $_POST['tp'];
    $fname = $_POST['fname'];
    $owner = $_POST['owner'];
    $course = $_POST['for_course'];
    $jina = $_POST['jina'];
    $tm = $_POST['tm'];

    if ($tp == null) {
        echo "<script>alert('Please Choose Type.'); window.history.back();</script>";
    }else{
    $filename = str_replace(" ", "_", $filename);
    $filename = $course.'_'.time().'_'.$filename;
    // destination of the file on the server
    $destination = '../upload/data/' . $filename;
    //$d = '../notes/'. $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    // tumeshauriana kwmba wanafunzi tumlimit upload.
    if (!in_array($extension, ['zip', 'pdf', 'docx', 'pptx', 'ppt', 'doc','jpeg','jpg','png','csv','xlxs','mp3','mp4','flv','pkt'])) {
        //You file extension must be .zip, .pdf, .pptx, .ppt or .docx
        echo "<script>alert('Unsoported File Format'); window.history.back();</script>";
    } elseif ($_FILES['myfile']['size'] > 100000000) { // file shouldn't be larger than 10Megabyte
        echo "<script>alert('File too large.'); window.history.back();</script>";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
             //echo "<script>alert('Zimetoka but hazijafika')</script>";
          //end this file to another folder
            //copy($destination, $d);

          //i think status could be added as empty str
            $sql1 = $conn->prepare("INSERT INTO `tbl_submit` (file_ans, file_task_name,instructor, file_as,course,uploaded_by,total_marks,result) VALUES (:file_ans, :file_task_name,:instructor, :file_as, :course, :uploaded_by,:total_marks,:result)");
            $success = $sql1->execute([':file_ans'=>$filename, ':file_task_name'=>$fname, ':instructor'=>$owner, ':file_as'=>$tp, ':course'=>$course, ':uploaded_by'=>$jina, ':total_marks'=>$tm, ':result'=>0]);
            if ($success) {
                echo "<script>alert('File uploaded successfully'); window.history.back();</script>";
                
            }else{
              echo "Something went Wrong";
            }
        } else {
            echo "<script>alert('Failed to upload file.'); window.history.back();</script>";
        }
    }
}
}
 ?>
