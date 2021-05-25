<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('0')){
?>

<div id="layoutSidenav_content">
    <div class="container-fluid">

        <h1 class="mt-4">Assigments <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>

        <hr>

        <?php
        //require_once('../includes/db.php');
        $conn = DB::getConnection();
        $k = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id =:id");
        $stmt->execute([':id'=>$k]);
        $dd = $stmt->fetch(PDO::FETCH_ASSOC);
        if($dd !=null){
        $fc = $dd['course_code'];

        $sel = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in");
        $sel->execute([':for_course'=>$fc, ':as_in'=>'assignment']);
    }else{
        exit();
    }
        ?>

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-exa1">
            <thead>
            <tr>
                <th>
                    File Name
                </th>
                <th>
                    expire date
                </th>
                <th>Uploaded by</th>
                <th>Task</th>
                <th>Marks</th>
                <!-- panatakiwa kuongezwa feture ya upload or submit -->
                <th>Download/Upload</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($m = $sel->fetch(PDO::FETCH_ASSOC)){
                //tuta weka if statement hapa kama doc ime expire isitokee kabisa
                ?>
                <tr>
                    <td>
                        <?php echo $m['file_name']; ?>
                    </td>

                    <td>
                        <?php if(date("Y-m-d") > $m['expire_date']){ ?>
                            <span style="color:red;">Expired</span>
                        <?php }else{ ?>
                            <?php echo $m['expire_date']; ?>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $m['owner']; ?>
                    </td>
                    <td>
                        <?php echo $m['as_in']; ?>
                    </td>
                    <td>
                        <?php
                        if ($m['total_marks'] == 0) {
                            echo "Notes";
                        }else{
                            echo $m['total_marks'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php if(date("Y-m-d") <= $m['expire_date']){ ?>

                            <a href="gg?fid=<?php echo Crypt::encrypt($m['id']); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="downf?file_id=<?php echo Crypt::encrypt($m['id']); ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-download"></i>
                            </a>
                                <?php if(isSubmitted($n, $m['file_name'])): ?>
                                <button class="btn btn-secondary btn-sm disabled" style="opacity: 0.5; pointer-events: none;">Submitted</button>
                                <?php else: ?>
                                <button data-id="<?php echo $m['id'].",".$n; ?>" id="getJibu" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editt"><i class="fa fa-upload fa-fw"></i>
                                </button>
                            <?php endif ?>

                            
                        <?php }else{
                            echo "<span style='color:red;'>Expired</span>";
                        } ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                $('#dataTables-exa1').DataTable();
            } );
        </script>


        <!-- Modal -->
        <div class="modal fade" id="editt" tabindex="-1" role="dialog" aria-labelledby="academLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Assignment Answer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body col-md-12">
                        <div id="dynamic-contentjibu"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end of modal -->
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php';
}else { logOut(); } ?>

