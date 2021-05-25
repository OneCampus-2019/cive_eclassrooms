<?php session_start(); ?>
<?php require_once '../includes/db/db.php'; ?>
<?php require_once '../includes/auth.php'; ?>
<?php require_once '../classes/sec.php'; 
use App\DB;?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
<style>
* {
  box-sizing: border-box;
}

.main {
  float:left;
  width:100%;
  padding:0 10px;
  margin-top:7px;
}
.right {
  background-color:#e5e5e5;
  float:left;
  width:30%;
  padding:15px;
  margin-top:7px;
  text-align:left;
  border-radius: 5px;
}
.pdfobject-container { 
    /*height: 50rem; */
    width: 100%;
    border: 1rem solid rgba(0,0,0,0.05); 
  }

@media only screen and (max-width:620px) {
  /* For mobile phones: */
  .menu, .main, .right {
    width:100%;
  }
}
</style>
</head>
<body style="font-family:Verdana;color:#aaaaaa;">
<?php  
$conn = DB::getConnection();
  if (isset($_GET['fid'])) {
    $fid = Crypt::decrypt($_GET['fid']);
    $res = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE id=:id");
    $res->execute([':id'=>$fid]);
    $d = $res->fetch(PDO::FETCH_ASSOC);
    if($d == null){
      exit();
    }
    $n = $d['file_name'];
    //$result = $d['result'];
    $tt = $d['total_marks'];
    $id = $d['id'];
    $nam = $d['owner'];
    $stmt = $conn->prepare("SELECT * FROM `tbl_users` WHERE name=:name ");
    $stmt->execute([':name'=>$nam]);


    //echo $n;
  }
?>


<div style="overflow:auto">  

  <div class="main">
    <object data="../upload/data/<?php echo $n; ?>" style="width:100%;" height="600"></object>
    <!-- <div id="viewpdf"></div> -->
  </div>



</div>

  
<?php 
  if (isset($_POST['ggg'])) {
    $g = $_POST['grad'];
    $tt = $_POST['tat'];
    $idd = $_GET['fid'];
    if($g > $tt){
      ?>
      <script type="text/javascript">alert("You Can not Put Marks > Total Marks");</script>
      <?php
    }elseif(!isset($g) || empty($g)){
      ?>
      <script type="text/javascript">alert("Please Enter Marks First");</script>
      <?php
    }else{
      mysqli_query($con,"UPDATE `tbl_submit` SET result='$g',status='marked' WHERE id='$idd' ");
      header('location: gg.php?fid='.$idd);
      ?>
        <script type="text/javascript">
          javascript: setTimeout(window.close, 5);
        </script>

      <?php
      //header('location: manage_my_course.php?id='.$cod);
    }
    
    //header('location: manage_my_course.php?id='.$cod);
  }

 ?>


</body>
</html>
