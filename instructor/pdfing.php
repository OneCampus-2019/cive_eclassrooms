<?php require_once '../includes/db/db.php'; ?>
<?php require_once '../includes/auth.php'; ?>
<?php 


if(isset($_POST["id"]))  
 {  
    $x = explode(",", $_POST['id']);
    //$x = $_POST['id'];
    $qid = $x[0];
    $iid = $x[1];
    // $fc = $x[2];
    // $ya = $x[3];

      $output = '';  
     ///$connect = mysqli_connect("localhost", "root", "", "projectsend");  
      //$k = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `tbl_students` WHERE student_name='$gn'"));
      //$rgn = $k['registration_no'];

      $query = "SELECT * FROM `tbl_quiz` WHERE `id` = '".$qid."'";  
      $result = mysqli_query($con, $query);  
      $output .= '';  

      while($row = mysqli_fetch_array($result))  
      {  
        $jibu = (($result)) ? $row['marks'] : '';
        $an = (($result)) ? $row['result'] : '';
        $output .= ' 
        <form role="form" action="pdfing.php" method="POST">
            <div class="form-group">
              <label for="usrname"><span class="fa fa-question"></span> Quiz</label>
              <textarea class="form-control" name="q" readonly>
                '.$row["quiz_question"].'
              </textarea>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-check"></span> Answer</label>
              <textarea class="form-control" name="ans" readonly>
                '.$row["quiz_answer"].'
              </textarea>
            </div>
            <div class="col-md-4">
              <label for="psw"><span class="glyphicon glyphicon-user"></span> Grade</label>
              <input type="text" class="form-control col-md-4" name="marks" value="'.$an.'">
              <input type="text" class="form-control col-md-4" name="pa" value="'.$jibu.'"  readonly>
            </div>
            <br>
              
            <button type="submit" name="submitq" class="btn btn-success"><span class="glyphicon glyphicon-off"></span> Submit</button>
                      
            <input type="text"  name="idd" value="'.$row['id'].'" style="visibility:hidden;">
            <input type="text"  name="iid" value="'.$iid.'" style="visibility:hidden;">
          </form>
    
        '; 
         
      }  
      $output .= "";  
      echo $output;  
 }else{
  //echo "none";
 } 

 
 if (isset($_POST['submitq'])) {
  
   $m = mysqli_real_escape_string($con,$_POST['marks']);
   $idd = mysqli_real_escape_string($con,$_POST['idd']);
   $iid = mysqli_real_escape_string($con,$_POST['iid']);
   $pa = mysqli_real_escape_string($con,$_POST['pa']);
   if($m > $pa){
      ?>
      <script type="text/javascript">alert("You Can not Put Marks > Total Marks");</script>
      <?php
    }elseif(!isset($m) || empty($m)){
      ?>
      <script type="text/javascript">alert("Please Enter Marks First");</script>
      <?php
    }else{

       $k = mysqli_query($con,"UPDATE `tbl_quiz` SET result='".$m."',status='marked' WHERE id='".$idd."'");
       if ($k) {
         echo "Marks Saved";
         header('location: manage_my_course.php?id='.$iid);
       }else{
        echo "Something Went Wrong ".mysqli_error($con);
       }
     }

 }
 ?>