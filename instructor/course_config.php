<?php require_once '../includes/header.php'; ?>
<?php 
use App\DB;
if(hasAuthority('8')){
$conn = DB::getConnection();
    $cc = $conn->prepare("SELECT * FROM `tbl_users` WHERE name=:name ");
    $cc->execute([':name'=>$n]);
    $ccc = $cc->fetch(PDO::FETCH_ASSOC);
    $de = $ccc['department'];

    $q = "SELECT * FROM `tbl_course` WHERE department=:department ";
        $qq = $conn->prepare($q);
        $qq->execute([':department'=>$de]);
        $nr = $qq->rowCount();
 ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Configure Course <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Courses</span></p>
            </div>

            <div class="clear"></div>

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
    <thead>
        <tr>
            <th class="td_checkbox">
                #
            </th>

            <th>
                Course Name
            </th>

            <th>
                Course Code
            </th>       

            <th>
                Semester
            </th>
            <th>
                Department
            </th>
            <th>
            	Credits
            </th>
            <th>
            	Status
            </th>
            <th>Assigned to</th>
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
   <?php 
        $n = 1;
        while($d = $qq->fetch(PDO::FETCH_ASSOC)){

     ?>
    <tr class="table_row">
        <td>
        <?php echo $n; ?>
        </td>
        <td>
           <?php echo $d['course_name']; ?>
        </td>

        <td>
           <?php echo $d['course_code']; ?>
        </td>
        
        <td>
            <?php echo $d['course_semester']; ?>
        </td>
         <td>
             <?php echo $d['department']; ?>
         </td>  
         <td>
         	<?php echo $d['course_credits']; ?>
         </td> 
         <td>
         	<?php echo $d['status']; ?>
         </td>    
         <td>
             <?php echo $d['assigned_to']; ?>
         </td>
        
        <td>
        <a href="course_edit?id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
        </td>
        </tr>
        <?php 
        $n++;
            }
         ?>

    </tbody>
    </table>


  </div>

<script>
    $(document).ready(function() {
    $('#dataTables-example2').DataTable();
} );
    </script>
<?php require_once '../includes/footer.php'; }
else { logOut(); } ?>
