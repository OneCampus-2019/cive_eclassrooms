<?php require_once '../includes/header.php';
  use App\DB;
  if(hasAuthority('7') || hasAuthority('8')){
  ?>

           <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">My classes <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>
                        <hr>
                        <div class="row">
                           <?php 

        //this query must added the where clause for only my course
        $mimi = $n;
        $conn = DB::getConnection();
        $q = $conn->prepare("SELECT * FROM `tbl_course` WHERE assigned_to LIKE :assigned_to");
        $q->execute([':assigned_to'=>'%'.$mimi.'%']);
        $courses = $q->fetchAll(PDO::FETCH_ASSOC);
        $nr = $q->rowCount();
        $k = 0;
        foreach ($courses as $course) {
     
                
                $k++;

     ?> 
         
            <!-- to be looped -->
            <!-- the color should be randoized from php function -->
            <div class="col-xl-3 col-md-4" >
                <div class="card bg-success text-white mb-4" style="height: 180px">
                    <div class="card-body">
                        <a href="manage_my_course?id=<?php echo Crypt::encrypt($course['id']); ?>&&code=<?php echo Crypt::encrypt($course['course_code']); ?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                            <?php echo $course['course_name']." <br>(".$course['course_code'].")"; ?>
                        </a>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <i class="fa fa-book fa-3x"></i>
                        <h3>
                            <?php echo $course['course_credits']; ?>
                        </h3>
                        <br><p><?php echo $course['status']; ?></p>
                    </div>
                </div>
            </div>
                
         <?php 
            }
       
         ?>                     
                            
                        </div>
                        <?php //echo $k; ?>
                        <?php if ($k == 0) {
                            $jumbe = "<h4 align='center'>No Course Assigned</h4>";
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
}?>
