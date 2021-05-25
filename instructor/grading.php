<?php require_once '../includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.css">
<style>
* {
  box-sizing: border-box;
}

.main {
  float:left;
  width:70%;
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
  if (isset($_GET['fid'])) {
    $fid = mysqli_real_escape_string($con,$_GET['fid']);
    $res = mysqli_query($con,"SELECT * FROM `tbl_submit` WHERE id='$fid'");
    $d = mysqli_fetch_assoc($res);
    $n = $d['file_ans'];
    $result = $d['result'];
    $tt = $d['total_marks'];
    $id = $d['id'];
    $nam = $d['uploaded_by'];
    $t = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `tbl_students` WHERE student_name='".$nam."' "));
    //echo $n;
  }
?>
<div style="background-color:#e5e5e5;padding:1px;text-align:center;">
  <h3>Grading: <?php echo $nam; ?> (<?php echo $t['registration_no']; ?>)</h3>
</div>

<div style="overflow:auto">  

  <div class="main">
    <object data="../upload/data/<?php echo $n; ?>" style="width:100%;" height="550"></object>
    <!-- <div id="viewpdf"></div> -->
  </div>

<!-- the right div for grading mechanism -->
  <div class="right">

    <form class="form-horizontal" action="" method="POST">
  <div class="form-group">
    <label class="control-label col-sm-2" for="marks">Marks:</label>
    <div class="col-sm-6">
    	<?php if($d['result'] == 0 && $d['status'] == 'unmarked'){ ?>
      <input type="text" class="form-control" name="grad" value="<?php echo $result; ?>">
      <?php }else{ ?>
      	<input type="text" class="form-control" name="grad" value="<?php echo $result; ?>" readonly>
      	<?php } ?>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="per">Per:</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="tat" value="<?php echo $tt; ?>" readonly>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    	<?php if($d['result'] == 0 && $d['status'] == 'unmarked'){ ?>
      <button type="submit" name="ggg" class="btn btn-info">Return</button>
       <?php }else{ ?>
       	<button type="button" name="ggg" class="btn btn-success disabled">Marked</button>
       <?php } ?>
    </div>
  </div>
</form> 
    
  </div>

</div>

  
<?php 
  if (isset($_POST['ggg'])) {
    $g = mysqli_real_escape_string($con,$_POST['grad']);
    $tt = mysqli_real_escape_string($con,$_POST['tat']);
    $idd = mysqli_real_escape_string($con,$_GET['fid']);
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
      //header('location: gg.php?fid='.$idd);
      //echo "<script>window.close();</script>";
      
      header('location: grading.php?fid='.$idd);
    }
    
    //header('location: manage_my_course.php?id='.$cod);
  }

 ?>


</body>
</html>
