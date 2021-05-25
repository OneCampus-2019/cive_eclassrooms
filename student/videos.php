<?php require_once '../includes/header.php'; 
use App\DB;?>

<div id="layoutSidenav_content">
    <div class="container-fluid">

        <h1 class="mt-2">Videos <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>

        <hr>

        <?php
        $conn = DB::getConnection();
        $k = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id =:id");
            $stmt->execute([':id'=>$k]);
        $dd = $stmt->fetch(PDO::FETCH_ASSOC);
        if($dd == null){
            exit();
        }
        $fc = $dd['course_code'];
        $sel = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in AND file_name LIKE :file_name ORDER BY id DESC");
        $sel->execute([':file_name'=>'%.mp4', ':as_in'=>'material', ':for_course'=>$fc]);
        $videos = $sel->fetchAll(PDO::FETCH_ASSOC);
        ?>

     
           
                <div class="row" style="margin-bottom: 6% !important;">
                    
                      <?php foreach($videos as $m): ?>
                       
                        <div class="col-md-3 col-xl- col-sm-12 col-xs-12 p-0 m-0 border">
                        <a href="watch?v=<?php echo Crypt::encrypt($m['id']); ?>&code=<?php echo Crypt::encrypt($m['for_course']); ?>" style="text-decoration: none;"> 
                        <div class="col-md-12 mb-2">

                            <div class="video-container mb-2" style="height:180px; padding:0; margin:0">

                            <video id="video-player" class="mb-2" width="100%" height="180">
                            <source src="../upload/data/<?php echo $m['file_name']; ?>" type="video/mp4"> 
                            </video> 
                            </div>
                            <div class="title col-md-12" style="word-wrap: break-word;" >
                            <span> <?php echo $m['file_name']; ?></span> 
                            </div>
                            
                       </div>
                   </a>
                      
                     
                        </div>
                  
                       <?php endforeach ?>    
                
                  
           </div>
             
            
        <script>
            $(document).ready(function() {
                $('#dataTables-exa1').DataTable();
            } );
        </script>

    </div>
</div>
</div>
</div>

<?php require_once '../includes/footer.php'; ?>
