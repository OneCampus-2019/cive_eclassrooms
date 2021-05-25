<?php require_once '../includes/db/db.php'; ?>
<?php require_once '../includes/auth.php'; 
use App\DB;?>
<?php 

//$g = $_SESSION['loggedin'];
$nn = $n;
 if(isset($_POST["qid"]))  
 {  
    $x = explode(",", $_POST['qid']);
    $qid = $x[0];
    $gn = $x[1];
    $fc = $x[2];
    $ya = $x[3];

      $output = '';  
       
      $k = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `tbl_students` WHERE student_name='".$gn."'"));
      $rgn = $k['registration_no'];
      $query = "SELECT * FROM `tbl_posts` WHERE `postid` = '".$qid."'";  
      $result = mysqli_query($con, $query);  
      $output .= '';  
      //echo $rgn;
      while($row = mysqli_fetch_array($result))  
      {  
        $output .= ' 
        <form role="form" action="quizing.php" method="POST">
            <div class="form-group">
              <label for="usrname"><span class="fa fa-question"></span> Quiz</label>
              <textarea class="form-control" name="q" readonly>
                '.$row["body"].'
              </textarea>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-check"></span> Your Answer</label>
              <textarea class="form-control" name="ans">
                
              </textarea>
            </div>
            <div class="row">
              <div class="col-sm-4">
              <input type="text" class="form-control" name="marks" value="'.$row['marks'].'" readonly/>
              </div>
              <div class="col-sm-8 pull-right">
              <button type="submit" name="submitq" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Submit</button>
              </div>
            </div
            <br><br>
            <input type="text" name="std_name" value="'.$nn.'" style="visibility:hidden;">
            <input type="text" name="course" value="'.$fc.'" style="visibility:hidden;">   
            <input type="text" name="quizid" value="'.$qid.'" style="visibility:hidden;">   
            <input type="text" name="reg_no" value="'.$rgn.'" style="visibility:hidden;">
            <input type="text" name="ya" value="'.$ya.'" style="visibility:hidden;">   
            <input type="text" name="pb" value="'.$row['postedby'].'" style="visibility:hidden;">           
            
          </form>
    
        '; 
         
      }  
      $output .= "";  
      echo $output;  
 }else{
  //echo "none";
 } 


  
  //session_start();
  //$postedby = $_SESSION["loggedin"];
  //echo $postedby;
?>
<?php 
  //post quiz functionality

if(isset($_POST["submitq"])){
     $std_name = mysqli_real_escape_string($con,$_POST['std_name']);
     $c = mysqli_real_escape_string($con,$_POST['course']);
     $rn = mysqli_real_escape_string($con,$_POST['reg_no']);
     $qidd = mysqli_real_escape_string($con,$_POST['quizid']);
     $body = mysqli_real_escape_string($con,$_POST["ans"]);
     $qq = mysqli_real_escape_string($con,$_POST["q"]);
     $ya = mysqli_real_escape_string($con,$_POST["ya"]);
     $qb = mysqli_real_escape_string($con,$_POST['pb']);
     $m = mysqli_real_escape_string($con,$_POST['marks']);

     //$postedby = $_SESSION["loggedin"];
     if(!empty($body) && isset($body)){
  
        $alli = mysqli_query($con,"SELECT * FROM `tbl_quiz` WHERE student='".$std_name."' AND quiz_question='".$qq."' ") or die(mysqli_error($con));
        $roja = mysqli_num_rows($alli);
        if($roja > 0){
          ?>
          <script>
            alert('You Already Answer This Quiz');
            window.location.href= 'std_my_course.php?id='+<?php echo $ya; ?>;
            </script>
          <?php
        }else{
        $sql = "INSERT INTO `tbl_quiz`(quiz_question,quiz_answer,student,reg_no,course,quiz_by,marks,result) VALUES('".$qq."','".$body."','".$std_name."','".$rn."','".$c."','".$qb."','".$m."',0)";
        $result = mysqli_query($con,$sql) or die(mysqli_error($con));

      }
        if($result){

              //echo "<script>alert('Quiz posted');</script>";
              //echo "imeenda";
              // header('location: manage_my_course.php?id='.$ya);
              ?> <script>
            alert('Quiz Posted....');
            window.location.href= 'std_my_course.php?id='+<?php echo $ya; ?>;
            </script> <?php 
                }
        else{

            // echo "<script>alert('Failed to post ');</script>";
            // echo mysqli_error($con);
            // echo "imebuma";
            // header('location: manage_my_course.php?id='.$ya);
            ?> <script>
            alert('Failed To Post...'+<?php echo mysqli_error($con); ?>);
            window.location.href= 'std_my_course.php?id='+<?php echo $ya; ?>;
            </script> <?php 
        }
     }else{
        ?> <script>
            alert('No body Failed topost...'+<?php echo mysqli_error($con); ?>);
            window.location.href= 'std_my_course.php?id='+<?php echo $ya; ?>;
            </script> <?php

     }

}
 ?>