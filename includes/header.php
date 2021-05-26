<?php session_start(); ?>
<?php use App\DB;?>
<?php require_once '../classes/sec.php'; ?>
<?php require_once 'actions.php'; ?>
<?php require_once '../process/adding_process.php'; ?>
<?php require_once 'auth.php'; ?>
<?php require_once 'file/filesLogic.php'; ?>
<?php require_once 'file/assignment_upload.php'; ?>
<?php require_once 'file/assignment_updator.php';?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CIVE e-CLASSROOM</title>
        <link rel="shortcut icon" type="image/png" href="../assets/img/x.png">
         <link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" /> 
         <link href="../assets/css/styles.css" rel="stylesheet" />
        <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" /> 
	<!--Select2 -->
	 <link href="../assets/select2/css/select2.min.css" rel="stylesheet" />
           <link href="../assets/select2-bootstrap4-theme/select2-bootstrap4.min.css" rel="stylesheet" />
       
      <!--  <link href="../assets/css/noti.css" rel="stylesheet" />  -->
        <link href="../assets/css/validation.css" rel="stylesheet" />
        <link href="../assets/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
        <link href="../assets/css/elements.css" rel="stylesheet" />
         <script src="../assets/js/jquery.min.js" crossorigin="anonymous"></script>
          <script src="../assets/font-awesome/css/all.min.js" crossorigin="anonymous"></script> 
           
  
    </head>
    <style type="text/css">
        body{
            font-family: "Times New Roman",TImes, serif;
            font-size: 0.8em;
        }
    </style>
    <body class="sb-nav-fixed" oncontextmenu="">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">CIVE e-CLASSROOM</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                
            </form>
            <!-- notification -->

            <!-- ///notification -->

            <!-- jina la mtu -->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item" style="color:#fff;">
                    <?php echo $n; ?> | 
                </li>
            </ul>
            <!-- // jina la mtu -->

            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <!-- notifcation -->
                 <?php if($l === '0'){ ?>

                <?php
               $conn = DB::getConnection();
                    $sl = $conn->prepare("SELECT * FROM `tbl_students` WHERE student_name =:student_name");
                    $sl->execute([':student_name'=>$n]);
                    //$cour = mysqli_fetch_assoc($sl);
                    $nrk = $sl->rowCount();
                    $mnb = 0;
                    while($d = $sl->fetch(PDO::FETCH_ASSOC)){
                        $mi = explode(", ",$d['courses']); 
                        $mnb = $d['id'];                   
                    }

                   $v = array();
                    foreach ($mi as $hapa) {
                        array_push($v, $hapa);
                    }
                    
                    $lm = json_encode($v);
                    $b = str_replace(array('[',']'),'',htmlspecialchars($lm,ENT_NOQUOTES));
                    $nn = $conn->prepare("SELECT * FROM `tbl_uploads`,`tbl_notification` WHERE `tbl_uploads`.for_course IN($b) AND `tbl_notification`.student=:student AND `tbl_uploads`.id=`tbl_notification`.material");
                    $nn->execute([':student'=>$mnb]);
                    $nol = $conn->prepare("SELECT  * FROM `tbl_uploads` WHERE for_course IN($b)");
                    $nol->execute();
                    $nolnr = $nol->rowCount();
                    $k = $nn->rowCount();
                    $dtm = $nn->fetch(PDO::FETCH_ASSOC);
                    //$mt = mysqli_query($con,"SELECT COUNT(student) FROM `tbl_notification` WHERE student ='".$mnb."' ");
                    //$mtk = mysqli_num_rows($mt);
                    $upl = $conn->prepare("SELECT * FROM `tbl_notification` WHERE student = :student ");
                    $upl->execute([':student'=>$mnb]);
                    $kvm = $upl->rowCount();
                    $vijo = $nolnr - $k;
                    
                ?>
                <li class="nav-item dropdown">
                  <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge bg-danger not_count">+<?php echo $vijo; ?></span>
                  </a>
                    <ul class="dropdown-menu dropdown-menu-right noti">
                      <li class="head text-light bg-dark">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-12">
                            <span>Notifications (<?php echo $vijo; ?>)</span>
                            <a href="" class="float-right text-light"><i class="fa fa-dot-circle"></i></a>
                          </div>
                      </li>
                      <!-- loop -->
                      <?php 
        
        while($d =$sl->fetch(PDO::FETCH_ASSOC)){            
            $mi = explode(", ",$d['courses']);
        }
        
        $v = array();
        foreach ($mi as $hapa) {
            array_push($v, $hapa);
        }

        $lm = json_encode($v);
        $b = str_replace(array('[',']'),'',htmlspecialchars($lm,ENT_NOQUOTES));
        $nn = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course IN($b) ORDER BY id DESC");
        $nn->execute();
        $c = 1;
        while($dd = $nn->fetch(PDO::FETCH_ASSOC)){
            ?>
                      <li class="notification-box cont">
                        <div class="row jh" data-id="<?php echo $dd['id']; ?>" id="getNoti" data-toggle="modal" data-target="#modalNotie" >
                            <!-- <button type="button" > -->
                          <div class="col-lg-2 col-sm-2 col-2 text-center">
                            <img src="../assets/img/logo.PNG" class="w-50 rounded-circle">
                          </div>    
                          <div class="col-lg-8 col-sm-8 col-8">
                            <strong class="text-info"><?php echo $dd['owner']; ?></strong>
                            <div style="" class="bd">
                                <?php echo "<span style='color:blue;'>File as ".$dd['as_in']."</span><br>"; ?>
                              <?php echo $dd['file_name']; ?>
                            </div>
                            <small class="text-warning"><?php echo $dd['date_created']; ?></small>
                          </div> 

                          <!-- </button>    -->
                        </div>
                      </li>
                      <?php } ?>
                      
                      <!-- looop -->
                      
                      <li class="footer bg-dark text-center">
                        <a href="" class="text-light"></a>
                      </li>
                    </ul>
                </li>
            <?php } ?>
                <!-- notification end -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="acc_setting.php"><i class="fa fa-user"></i> My Account</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../process/logout.php"><i class="fas fa-power-off"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <?php if($l === '9'){ ?>
                            <a class="nav-link" href="index"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
                            >
                            <!-- department -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-university"></i></div>
                                Department
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="dept_add">Add Department</a>
                                    <a class="nav-link" href="dept_manage">Manage Department</a></nav>
                            </div>
                            <!-- end of department -->
                            <!-- programs -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Programs
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="prog_add">Add Program</a>
                                    <a class="nav-link" href="prog_manage">Manage Programs</a></nav>
                            </div>
                            <!-- end of programs -->
                            <!-- courses -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Courses
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="course_add">Add Course</a>
                                    <a class="nav-link" href="course_manage">Manage Courses</a></nav>
                            </div>
                            <!-- end of courses -->
                            <!-- student -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts4" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Students
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="student_manage">Manage Students</a></nav>
                            </div>
                            <!-- end of student -->
                            <!-- system users -->
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts5" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                System Users
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapseLayouts5" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="user_add">Add New User</a><a class="nav-link" href="user_manage">Manage System Users</a></nav>
                            </div>
                           
                            <!-- end of system users --> 
                            <?php }elseif($l === '7'){ ?>
                            <a class="nav-link" href="index">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                                <!-- my course -->
                            <a class="nav-link " href="my_course">
                                <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                My Courses
                              
                            </a>
                            <a class="nav-link" href="takecourse">
                                <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                Take a Course
                            </a>
                            <a class="nav-link collapsed" href="prog_config">
                                <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                                Configure Programs
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a> 
                            <a class="nav-link collapsed" href="upload_students">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                                Upload Student list
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a> 
                            <!-- end of my course -->
                            <?php }elseif($l === '8'){ ?>  
                            <a class="nav-link" href="index">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            <!-- upload students -->
                            <a class="nav-link collapsed" href="upload_students">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                                Upload Student list
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a> 
                            <!-- end of upload stdudnet -->
                            <!--  programs -->
                            <a class="nav-link collapsed" href="prog_config">
                                <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                                Configure Programs
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a> 
                            <!-- end of programs -->
                            <!--  programs -->
                            <a class="nav-link collapsed" href="course_config">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Configure Courses
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a> 
                            <!-- end of programs -->
                            <!-- my course -->
                            <a class="nav-link collapsed" href="my_course">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                My Course
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a>                    
                            <a class="nav-link collapsed" href="studentList">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    List Of Students
                                    <div class="sb-sidenav-collapse-arrow"></div
                                    ></a>        
                            <!-- end of my course -->
                            <?php }elseif($l === '0'){ ?>  
                            <a class="nav-link" href="index">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            <!-- upload students -->
                            <a class="nav-link collapsed" href="my_courses">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                List Of My Courses
                                <div class="sb-sidenav-collapse-arrow"></div
                            ></a> 
                            <?php } ?>                       
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $u; ?>
                    </div>
                </nav>
            </div>


            <!-- modal for notification-->
<div class="modal fade" id="modalNotie" tabindex="-1" role="dialog" aria-labelledby="academLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body col-md-12">
         <div id="dynamic-contentNotif"></div>     
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
            <!-- end of moal for notification -->
