<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('0')){
    ?>


           <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>

                        <hr>
                        <div class="row">
                <?php
               // $conn = DB::getConnection();
                //this query must added the where clause for only my course
                //global $k;
                $mimi = $n;

                //hii query itabadilika tukiweza ku login kama mwanafunzi
                $q = $conn->prepare("SELECT * FROM `tbl_students` WHERE student_name= :student_name");
                  $q->execute([':student_name'=>$mimi]);
                    $nr = $q->rowCount();
                
                    while($d = $q->fetch(PDO::FETCH_ASSOC)){

                        $mi = explode(", ",$d['courses']);

                    }

                $v = array();
                foreach ($mi as $hapa) {
                    array_push($v, $hapa);
                }

                $l = json_encode($v);
                $b = str_replace(array('[',']'),'',htmlspecialchars($l,ENT_NOQUOTES));
                $nn = $conn->prepare("SELECT * FROM `tbl_course` WHERE course_code IN($b)");
                $nn->execute();
                $k = $nn->rowCount();
                //echo $k;
                while($dd = $nn->fetch(PDO::FETCH_ASSOC)){
             ?>

                <!-- to be looped -->
                <div class="col-xl-3 col-md-4">
                    <div class="card bg-success text-white mb-4" style="height: 180px">
                        <div class="card-body">
                            <a href="std_my_course?id=<?php echo Crypt::encrypt($dd['id']); ?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                <?php echo $dd['course_name']." <br>(".$dd['course_code'].")"; ?>
            </a>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <i class="fa fa-book fa-3x"></i>
                            <h3><?php echo $dd['course_credits']; ?></h3>
                            <br><p><?php echo $dd['status']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>


                        </div>
                        <?php if ($k == 0) {
                            $jumbe = "<h4 align='center'>No Subject Assigned</h4>";
                            echo '<div class="alert alert-info alert-dismissible col-md-12">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>';
                                            echo $jumbe;
                                            echo '
                                            </strong>
                                        </div>';
                        } ?>
                    </div>


                
<?php require_once '../includes/footer.php'; 
}else{
   logOut();
}
?>