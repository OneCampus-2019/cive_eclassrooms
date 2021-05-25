<!-- row -->
<?php
require_once('../includes/db/db.php');
use App\DB;
 $conn = DB::getConnection();
 if(isset($_GET['id'])){ 
 
  ?>

             <div class="row">

        <div class="col-sm-4">
          <div class="card">
            <div class="card-header">Post Announcement</div>
            <div class="card-body">
              <form action="" method="post">
              <label for="">Title</label>
              <input type="text" name="title" class="form-control" required>
              <label for="">Expire Date</label>
              <input type="date" name="edate" class="form-control" required>
              <label for="">Body</label>
              <textarea name="body" id="" cols="30" rows="5" name="" class="form-control" required></textarea>
              <input type="text" name="for_course" value="<?php echo $_SESSION['code']; ?>" style="visibility: hidden;">
              <input type="text" name="idk" value="<?php echo $_GET['id']; ?>" style="visibility: hidden;">
              
                  <div class="row">
                      <div class="col-md-12"><br>
                        <button class="btn btn-primary pull-right" type="submit">Post</button>
                      </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
<?php 

  $postedby = $u;
  
?>

        <div class="col-sm-8 overflow-auto" >
          <div class="card">
            <div class="card-header">Announcement Posted By You</div>
            <div class="card-body" style="width:auto;height:500px; overflow-y: scroll;">
              <table class="table table-striped table-bordered table-hover" id="tbl">
          <thead>
              <tr>
                  <th>Sno.</th>
                  <th>title</th>
                  <th>body</th>
                  <th>expired date</th>
                  <th>Action</th>

                 
              </tr>
            </thead>
            <tbody>
            <?php $code=$_SESSION['code']; 
            $ret=$conn->prepare("SELECT * FROM tbl_posts where postedby = :postedby AND for_course=:for_course AND title<> :title");
            $ret->execute([':postedby'=>$postedby, ':for_course'=>$code, ':title'=>'quizs']);
            $rows = $ret->fetchAll();
    $cnt=1;
    $j = $_GET['id'];
    $code = $_GET['code'];
    foreach($rows as $row)
    {?>
             
            <tr>
              <td><?php echo $cnt;?></td>
              <td><?php echo $row['title'];?></td>
              <td><?php echo $row['body'];?></td>
              <td><?php echo $row['exp_date'];?></td>

              <td>
      <a href="ann.php?postid=<?php echo $row['postid'];?>&usk=<?php echo $j; ?>&code=<?php echo $_GET['code']; ?>" class="btn btn-sm btn-danger" onclick ="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i></a></td>
             
            </tr>
                <?php $cnt=$cnt+1; }?>            
            </tbody>
              </table>
            </div>
          </div>
        </div>

      </div> <!-- row end -->
<?php } ?>
<?php //require_once '../includes/db.php'; ?>
      <?php 
if(isset($_POST["title"]) && isset($_POST["body"])){
echo "This is for course value: ".$_POST['for_course'];
     $title = $_POST["title"];
     $body =$_POST["body"];
     $edate = $_POST["edate"];
     $fc = $_POST["for_course"];
     $idk =$_POST["idk"];
     $postedby = $u;
     $time = date('Y-m-d H:i:s');
     if(!empty($title) && !empty($body)){
  
        $stmt = $conn->prepare("INSERT INTO tbl_posts(title,exp_date,body,postedby,for_course,time) VALUES(:title, :exp_date, :bd,:postedby, :for_course, :time)");
        $result = $stmt->execute([':title'=>$title, ':exp_date'=>$edate, ':bd'=>$body,':postedby'=>$postedby, ':for_course'=>$fc, ':time'=>$time]);

        if($result){
              ?>
              <script>

               
                if(window.history.replaceState){
                  window.history.replaceState(null, null, window.location.href);
                   window.location.reload();
                }
              </script>
              <?php
        }
        else{
            echo "<script>alert('Failed to post');</script>";
        }
     }

}

if(isset($_GET['postid']))
{
  $postid = $_GET['postid'];
  $k = $_GET['usk'];
  $code = $_GET['code'];
  $sms = $conn->prepare("DELETE FROM `tbl_posts` WHERE postid =:postid");
  $sms->execute([':postid'=>$postid]);
if($sms)
{
  ?>
  <script>alert('Announcement deleted');

</script>
  <?php
  header("Location:manage_my_course?id=".$k."&&code=".$code);
}
else{
echo "<script>alert('Data  not deleted');</script>";  
}
}

 ?>