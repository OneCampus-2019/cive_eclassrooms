<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/auth.php'; ?>
  			<?php if(isset($_GET['id'])){ ?>
          <?php  
            $k = mysqli_real_escape_string($con,$_GET['id']);
            $q = "SELECT * FROM `tbl_course` WHERE id = '".$k."' ";
            $res = mysqli_query($con,$q);
            $dd = mysqli_fetch_assoc($res);
          ?>
          <div class="row"><!-- satrt of row -->
          <div class="col-sm-4" > <!-- left column -->
          <!-- card start -->
          <div class="card">
            <div class="card-header">
              POST QUIZ
            </div>
            <div class="card-body" >
              <form action="mannq.php" method="POST">
                      
                <label for="">Write Quiz Question</label>
                <textarea name="quizb" id="" cols="30" rows="5" class="form-control" required></textarea>
                <input type="text" name="for_course" value="<?php echo $dd['course_code']; ?>" style="visibility: hidden;">
                <input type="text" name="ya" value="<?php echo $_GET['id']; ?>" style="visibility: hidden;">
                
                <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="marks" placeholder="Marks" required>
                    </div>
                    <div class="col-md-6">
                      <button class="btn btn-primary pull-right" type="submit" name="quizs">Post</button>
                    </div>
                </div>
                </form>
            </div>
          </div>
          <!-- card end -->
        </div> <!-- end of the left column -->
        <?php 

  $postedby = $u;
?>

        <div class="col-sm-8 overflow-auto" >
          <div class="card">
            <div class="card-header">Quiz Created By You</div>
            <div class="card-body" style="width:auto;height:500px; overflow-y: scroll;">
              <table class="table table-striped table-bordered table-hover" id="tbl">
          <thead>
              <tr>
                  <th>Sno.</th>
                  <th>Marks</th>
                  <th>Body</th>
                  <th>Deadline</th>
                  <th>Action</th>                 
              </tr>
            </thead>
            <tbody>
            <?php $ret=mysqli_query($con,"SELECT * FROM tbl_posts where `postedby` = '$postedby' AND title='quizs'");
    $cnt=1;
    $j = $_GET['id'];
    while($row=mysqli_fetch_array($ret))
    {?>
             
            <tr>
              <td><?php echo $cnt;?></td>
              <td><?php echo $row['marks'];?></td>
              <td><?php echo $row['body'];?></td>
              <td><?php echo $row['exp_date'];?></td>

              <td>
      <a href="mannq.php?postid=<?php echo $row['postid'];?>&usk=<?php echo $j; ?>" class="btn btn-sm btn-danger" onclick ="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i></a></td>
             
            </tr>
                <?php $cnt=$cnt+1; }?>            
            </tbody>
              </table>
            </div>
          </div>
        </div> <!-- end of riht -->

  			</div> <!-- end of row -->
      <?php } ?>

<?php 
	//post announcement functionality

if(isset($_POST["quizs"])){

     $body = mysqli_real_escape_string($con,$_POST["quizb"]);
     $ya = mysqli_real_escape_string($con,$_POST["ya"]);
     $fc = mysqli_real_escape_string($con,$_POST["for_course"]);
     $m = mysqli_real_escape_string($con,$_POST["marks"]);
     //$postedby = $_SESSION["loggedin"];
     if(!empty($body) && isset($body)){
        if (!empty($m) && isset($m)) {
            $sql = "INSERT INTO `tbl_posts`(title,exp_date,body,postedby,for_course,time,marks) VALUES('quizs','".date("Y-m-d")."','".$body."','".$u."','".$fc."','".date("Y-m-d H:i:s")."','".$m."')";

            $result = mysqli_query($con,$sql) or die(mysqli_error($con));

            if($result){              
                  ?> <script>
                alert('Quiz Posted....');
                window.location.href= 'manage_my_course.php?id='+<?php echo $ya; ?>;
                </script> <?php 
                    }
            else{
                ?> <script>
                alert('Failed To Post...'+<?php echo mysqli_error($con); ?>);
                window.location.href= 'manage_my_course.php?id='+<?php echo $ya; ?>;
                </script> <?php 
            }
        }else{
          ?>
        <script type="text/javascript">
        alert('Please Enter Marks!');
        window.location.href= 'manage_my_course.php?id='+<?php echo $ya; ?>;
        </script>
        <?php
        }
        
     }else{
      ?>
      <script type="text/javascript">alert('Failed To Post...');</script>
      <?php
        echo "title hamna";
     }

}

if(isset($_GET['postid']))
{
	$postid = mysqli_real_escape_string($con,$_GET['postid']);
	$k = mysqli_real_escape_string($con,$_GET['usk']);
	$sms = mysqli_query($con,"DELETE FROM `tbl_posts` WHERE postid ='".$postid."'");
if($sms)
{
?>
  <script>alert('Quiz deleted');
window.location.href= 'manage_my_course.php?id='+<?php echo $k; ?>;
</script>
  <?php
}
else{
echo "<script>alert('Data  not deleted');</script>";	
}
}

 ?>



  			