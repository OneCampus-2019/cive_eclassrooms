<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
?>
<?php 

    $q = $conn->prepare("SELECT * FROM `tbl_students` ORDER BY id DESC ");
    $q->execute();
    $nr = $q->rowCount();
    $students = $q->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Student Administration <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Students</span></p>
            </div>

            <div class="clear"></div>

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr>
            <th class="td_checkbox">
                #
            </th>

            <th>
                Student Name
            </th>

            <th>
                Registration no
            </th>       

            <th>
                Status
            </th>
            <th>
                Added On
            </th>
            
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
   <?php 
        $c = 1;
        foreach($students as $d){

    ?>
    <tr class="table_row">
        <td>
        <?php echo $c; ?>
        </td>
        <td>
           <?php echo $d['student_name']; ?>
        </td>

        <td>
           <?php echo $d['registration_no']; ?>
        </td>
        
        <td>
            <?php echo $d['status']; ?>
        </td>
         <td>
             <?php echo $d['registered_on']; ?>
         </td>  
            
        
        <td>
        <a href="std_edit?id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
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
    $('#dataTables-example').DataTable();
} );
    </script>

<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>