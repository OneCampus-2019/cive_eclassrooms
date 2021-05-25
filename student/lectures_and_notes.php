<?php require_once '../includes/header.php';
 use App\DB; ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">

        <h1 class="mt-4">Lectures, Notes and Tutorials <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>

        <hr>

        <?php
       $conn = DB::getConnection();
        $k =    Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id =:id");
        $stmt->execute([':id'=>$k]);
        $dd = $stmt->fetch(PDO::FETCH_ASSOC);
        if($dd == null){
            exit();
        }
        $fc = $dd['course_code'];
        $sel = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in AND (file_name NOT LIKE :file_name)");
        $sel->execute([':file_name'=>'%.mp4', ':as_in'=>'material', ':for_course'=>$fc]);
        $materials = $sel->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-exa1">
            <thead>
            <tr>
                <th>
                    File Name
                </th>
                <th>
                    Size
                </th>
                <th>Uploaded by</th>
                <th>Task type</th>
                <!-- panatakiwa kuongezwa feture ya upload or submit -->
                <th>Download</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($materials as $m){
                //tuta weka if statement hapa kama doc ime expire isitokee kabisa
                ?>
                <tr>
                    <td>
                        <?php echo $m['file_name']; ?>
                    </td>
                    <td>
                        <?php echo $m['size']; ?>
                    </td>
                    <td>
                        <?php echo $m['owner']; ?>
                    </td>
                    <td>
                        <?php echo $m['as_in']; ?>
                    </td>
                    <td>

                            <a href="gg?fid=<?php echo Crypt::encrypt($m['id']); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="downf.php?file_id=<?php echo Crypt::encrypt($m['id']); ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-download"></i>
                            </a>

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
    </div>
</div>
</div>
</div>

<?php require_once '../includes/footer.php'; ?>
