<?php require_once '../includes/header.php'; 
use App\DB;?>
<?php 
$conn = DB::getConnection();
    //this query must added the where clause for only my course
    $mimi = $n;
    $q = $conn->prepare("SELECT * FROM `tbl_course` WHERE assigned_to LIKE :assigned_to");
    $q->execute([':assigned_to'=>'%'.$mimi.'%']);
    $courses = $q->fetchAll(PDO::FETCH_ASSOC);
        $nr = $q->rowCount();
 ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">My Courses <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Courses Assigned to You</span></p>
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
                Credits
            </th>
            <th>
                Status
            </th>
            <th>
                Assigned To
            </th>
            
            <th data-hide="phone">Actions</th>
        </tr>
    </thead>
    <tbody>
   <?php 
        $cc = 1;
        foreach($courses as $d){
         /*   $mi = explode(", ",$d['assigned_to']);
            //$exploded_array = explode('~', $str);
            foreach ($mi as $hapa)
            {
               if($mimi === $hapa){*/


            
     ?>
    <tr class="table_row">
        <td>
        <?php echo $cc; ?>
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
             <?php echo $d['course_credits']; ?>
         </td>  
          <td>
             <?php echo $d['status']; ?>
         </td>   
        <td>
             <?php echo $d['assigned_to']; ?>
         </td> 
        <td>
        <a href="course_edit?name='' && did=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a>
        </td>
        </tr>
        <?php 
        $cc++;
       // }
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
<?php require_once '../includes/footer.php'; ?>