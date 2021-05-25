<?php require_once '../includes/header.php'; 
use App\DB;?>
<?php 
if(hasAuthority('9')){
$conn = DB::getConnection();
    $q = $conn->prepare("SELECT * FROM `tbl_course` ORDER BY id DESC ");
    $q->execute();
    $nr = $q->rowCount();
    $courses = $q->fetchAll();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Manage Course <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Courses</span></p>
            </div>

            <div class="clear"></div>

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
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
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $c = 1;
        foreach($courses as $d){

     ?>
    <tr class="table_row">
        <td>
        <?php echo $c; ?>
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
        <a href="course_edit?id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i>
        </a>
        <a href="course_manage?c=c&id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('are you sure??');"><i class="fa fa-trash"></i>
        </a>
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
    if (isset($_GET['c']) && $_GET['c'] === 'c') {
        $idd2 = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM `tbl_course` WHERE id=:id");
       $success =  $stmt->execute([':id'=>$idd2]);
       if($success){
        ?>
            <script>
                //alert("Department Deleted successfull!");
                window.location.href= 'course_manage.php';
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

<?php require_once '../includes/footer.php'; } else { logOut(); }?>