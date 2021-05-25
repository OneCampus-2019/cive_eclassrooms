<?php require_once '../includes/header.php'; 
use App\DB;?>
<?php 
//$conn = DB::getConnection();
    //this query must added the where clause for only my course
    $mimi = $n;
    //hii query itabadilika tukiweza ku login kama mwanafunzi
    $q = $conn->prepare("SELECT * FROM `tbl_students` WHERE student_name= :student_name ");
    $q->execute([':student_name'=>$mimi]);
        $nr = $q->rowCount();
        while($d = $q->fetch(PDO::FETCH_ASSOC)){
                
                        $mi = explode(", ",$d['courses']);
                    
                    }
            
                $v = array();
                foreach ($mi as $hapa) {
                    array_push($v, $hapa);
                }
                
                $l = json_encode($v);
                $b = str_replace(array('[',']'),'',htmlspecialchars($l,ENT_NOQUOTES));
                $nn = $conn->prepare("SELECT * FROM `tbl_course` WHERE course_code IN($b)");
                $nn->execute();
                $k = $nn->rowCount();
 ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">List Of My Courses <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $k; ?> Courses Assigned to You</span></p>
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
                Semester
            </th>       

            <th>
                Course Code
            </th>
            <th>
                Course Credits
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
        
    /*    while($d = mysqli_fetch_assoc($qq)){            
            $mi = explode(", ",$d['courses']);
        }
        
        $v = array();
        foreach ($mi as $hapa) {
            array_push($v, $hapa);
        }

        $l = json_encode($v);
        $b = str_replace(array('[',']'),'',htmlspecialchars($l,ENT_NOQUOTES));
        $nn = mysqli_query($con,"SELECT * FROM `tbl_course` WHERE course_code IN($b)");*/
        $c = 1;
        while($dd = $nn->fetch(PDO::FETCH_ASSOC)){
            ?>
    <tr class="table_row">
        <td>
        <?php echo $c; ?>
        </td>
        <td>
           <?php echo $dd['course_name']; ?>
        </td>

        <td>
           <?php echo $dd['course_semester']; ?>
        </td>
        
        <td>
           <?php echo $dd['course_code']; ?>
        </td>
         <td>
             <?php echo $dd['course_credits']; ?>
         </td>  
            <td>
             <?php echo $dd['status']; ?>
         </td> 
         <td>
             <?php echo $dd['assigned_to']; ?>
         </td> 
        
        <td>
        <a href="std_my_course?id=<?php echo Crypt::encrypt($dd['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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
<?php require_once '../includes/footer.php'; ?>