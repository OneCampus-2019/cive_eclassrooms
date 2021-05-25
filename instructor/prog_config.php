<?php require_once '../includes/header.php'; ?>
<?php 
use App\DB;
if(hasAuthority('8')){
$conn = DB::getConnection();
    $cc = $conn->prepare("SELECT * FROM `tbl_users` WHERE name=:name ");
    $cc->execute([':name'=>$n]);
    $ccc = $cc->fetch(PDO::FETCH_ASSOC);
    $de = $ccc['department'];
    $q = "SELECT * FROM `tbl_programs` WHERE program_department=:prodpt ";
    $qq = $conn->prepare($q);
    $qq->execute([':prodpt'=>$de]);
    $nr = $qq->rowCount();
 ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Configure Programs <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Programs</span></p>
            </div>

            <div class="clear"></div>

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examplex1">
    <thead>
        <tr>
            <th class="td_checkbox">
                #
            </th>

            <th>
                Program Name
            </th>

            <th>
                Program Code
            </th>       

            <th>
                College
            </th>
            <th>
                Department
            </th>
            
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $c =1;
        while($d = $qq->fetch(PDO::FETCH_ASSOC)){

     ?>
    <tr class="table_row">
        <td>
        <?php echo $c; ?>
        </td>
        <td>
            <?php echo $d['program_name']; ?>
        </td>

        <td>
            <?php echo $d['program_code']; ?><?php echo $d['duration']; ?>
        </td>
        
        <td>
            <?php echo $d['program_college']; ?>
        </td>
        <td>
            <?php echo $d['program_department']; ?>
        </td>
        
        
        <td>
        <a href="prog_edit?id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
        </td>
        </tr>
        <?php 
        $c++;
            }
         ?>

    </tbody>
    </table>


  </div>
<script>
    $(document).ready(function() {
    $('#dataTables-examplex1').DataTable();
} );
    </script>

<?php require_once '../includes/footer.php'; 
}else{logOut();}?>