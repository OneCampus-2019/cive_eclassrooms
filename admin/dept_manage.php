<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){

?>
<?php 
$conn = DB::getConnection();
    $q = $conn->prepare("SELECT * FROM `tbl_department` ");
    $q->execute();
    $nr = $q->rowCount();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Manage Department <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Department</span></p>
            </div>

            <div class="clear"></div>

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr>
            <th class="td_checkbox">
                #
            </th>

            <th>
                Department Name
            </th>

            <th>
                Department Code
            </th>       

            <th>
                College
            </th>
            
            
            
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $c = 1;
        while($d = $q->fetch(PDO::FETCH_ASSOC)){

    ?>
    <tr class="table_row">
        <td>
        <?php echo $c; ?>
        </td>
        <td>
           <?php echo $d['department_name']; ?>
        </td>

        <td>
           <?php echo $d['department_code']; ?>
        </td>
        
        <td>
            <?php echo $d['department_college']; ?>
        </td>
                
        
        <td>
        <a href="dept_edit?id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
        <a href="dept_manage?d=d&id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('are you sure??');"><i class="fa fa-trash"></i></a>
        </td>
        </tr>
        <?php 
        $c++;
            }
         ?>

    </tbody>
    </table>

<?php  
    //deleting dept mechanism
    if (isset($_GET['d']) && $_GET['d'] === 'd') {
        $idd2 = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM `tbl_department` WHERE id=:id");
        $success = $stmt->execute([':id'=>$idd2]);
        if($success){
        ?>
            <script>
                //alert("Department Deleted successfull!");
                window.location.href= 'dept_manage.php';
            </script>
        <?php
    }
    }
?>

</div>
<script>
    $(document).ready(function() {
    $('#dataTables-example').DataTable();
} );
    </script>
<?php require_once '../includes/footer.php'; } else{ logOut(); }?>

