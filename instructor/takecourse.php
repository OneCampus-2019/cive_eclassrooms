<?php require_once '../includes/header.php'; ?>
<?php 
use App\DB;
if(hasAuthority('7')){
$conn = DB::getConnection();
    $cc = $conn->prepare("SELECT * FROM `tbl_users` WHERE name=:name ");
    $cc->execute([':name'=>$n]);
    $ccc = $cc->fetch(PDO::FETCH_ASSOC);
    $de = $ccc['department'];

    $q = "SELECT * FROM `tbl_course`";
        $qq = $conn->prepare($q);
        $qq->execute();
        $nr = $qq->rowCount();
 ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">take Course <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>

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
        <?php 
        $id=Crypt::encrypt($d['id']);
        $name=$_SESSION['name'];
        if(strpos($d['assigned_to'], $_SESSION['name']) === false){
        print '<a href="course_edit?name='.$name.' && did='.$id.'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
      
        }
    else{
        //print '<a href="#"><i class="fas fa-user-check"></i></a>';
        print '<a href="course_edit?id='.$id.'" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i></a>';
      
    }
        ?>
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
