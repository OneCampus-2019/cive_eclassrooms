<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
?>
 <?php 
    $conn = DB::getConnection();
        $r = $conn->prepare("SELECT * FROM `tbl_users` WHERE level <> :level ");
        $r->execute([':level'=>0]);
        $nr = $r->rowCount();
        $r1 = $conn->prepare("SELECT * FROM `tbl_students`  ");
        $r1->execute();
        $nr1 = $r1->rowCount();
        $r2 = $conn->prepare("SELECT * FROM `tbl_course` ");
        $r2->execute();

        $nr2 =  $r2->rowCount();
        $r3 = $conn->prepare("SELECT * FROM `tbl_programs` ");
        $r3->execute();
        $nr3 = $r3->rowCount();
        $r4 = $conn->prepare("SELECT * FROM `tbl_department` ");
        $r4->execute();
        $nr4 = $r4->rowCount();
        ?> 
           <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>
                        <hr>
                        <!-- test -->
                        <div class="row" >
                            <div class="col-xl-8 col-md-8" >
                                <!-- test -->
                        <div class="row col-xl-12 col-md-12">
                            <div class="col-xl-3 col-md-4">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total System Users</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <i class="fa fa-user fa-3x"></i>
                                        <h3><?php echo $nr; ?></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-4">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Total Students</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <i class="fa fa-users fa-3x"></i>
                                        <h3><?php echo $nr1; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-4">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Courses</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <i class="fa fa-book fa-3x"></i>
                                        <h3><?php echo $nr2; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-4">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Total Programs</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <i class="fa fa-list fa-3x"></i>
                                        <h3><?php echo $nr3; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-4">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Department</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <i class="fa fa-university fa-3x"></i>
                                        <h3><?php echo $nr4; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <!-- test -->
                    </div>
                    <div class="col-xl-4 col-md-4" style="border: 1px solid #ccc;width:auto;height:400px; overflow-y: scroll;">
                            <h6 align="center"><b>RECENT ACTIVITIES</b></h6> <hr>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active " data-toggle="tab" href="#home">Login</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Logout</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu2">Upload</a>
    </li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active">
        <?php $ret=$conn->prepare("SELECT * FROM `tbl_logs` WHERE `action` =:action ORDER BY id DESC");
        $ret->execute([':action'=>'loggedin']);
$cnt=1;
while($row=$ret->fetch(PDO::FETCH_ASSOC))
{?>
<div style="background-color: #eee; border-radius: 5px; border-bottom: 1px; margin-bottom: -15px;margin-left: -15px;">
        <p><?php echo $row['date'];?> <br>
          <span style="color: blue;"><?php echo $row['username'];?> </span> <i><?php echo $row['Description'];?></i>
          
        </p>
      </div>
<?php $cnt=$cnt+1; }?>
   
    </div>
    <div id="menu1" class="container tab-pane fade">
    <?php $stmt=$conn->prepare("SELECT * FROM `tbl_logs` WHERE `action` =:action ORDER BY id DESC");
    $stmt->execute([':action'=>'loggedout']);
$cnt=1;
while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
?>
<div style="background-color: #eee; border-radius: 5px; border-bottom: 1px; margin-bottom: -15px;margin-left: -15px;">
        <p><?php echo $row['date'];?> <br>
          <span style="color: blue;"><?php echo $row['username'];?> </span> <i><?php echo $row['Description'];?></i>
          
        </p>
      </div>
<?php $cnt=$cnt+1; }?>
    </div>
    <div id="menu2" class="container tab-pane fade">
        <?php $stm=$conn->prepare("SELECT * FROM `tbl_logs` WHERE `action` =:action ORDER BY id DESC ");
        $stm->execute([':action'=>'upload']);
$cnt=1;
while($row=$stm->fetch(PDO::FETCH_ASSOC))
{?>
<div style="background-color: #eee; border-radius: 5px; border-bottom: 1px; margin-bottom: -15px;margin-left: -15px;">
        <p><?php echo $row['date'];?> <br>
          <span style="color: blue;"><?php echo $row['username'];?> </span> <i><?php echo $row['Description'];?></i>
          
        </p>
      </div>
<?php $cnt=$cnt+1; }?>
    </div>
  </div>
                    </div> <!-- mwisho wa div col xs 4 -->
                </div>
                <!-- test -->
                    </div>
              
                
<?php require_once '../includes/footer.php'; 
}else{
    logOut();
}?>
