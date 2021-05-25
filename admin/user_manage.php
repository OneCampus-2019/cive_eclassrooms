<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
 ?>
<?php 
$conn = DB::getConnection();
    $q = $conn->prepare("SELECT * FROM `tbl_users` WHERE level<> :level ORDER BY id DESC ");
    $q->execute([':level'=>0]);
    $nr = $q->rowCount();
    $users = $q->fetchAll();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Users Administration <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
        	<div class="form_actions_count">
                <p>Found: <span><?php echo $nr; ?> Users</span></p>
            </div>

            <div class="clear"></div>

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr>
            <th class="td_checkbox">
                #
            </th>

            <th>
                Full Name
            </th>

            <th>
                Login Username
            </th>       

            <th>
                E-mail
            </th>
            <th>
               Role
            </th>
            <th>
            	Department
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
        foreach($users as $d){
            $v = $d['id'];
    ?>
    <tr class="table_row">
        <td>
        <?php echo $c; ?>
        </td>
        <td>
           <?php echo $d['name']; ?>
        </td>

        <td>
           <?php echo $d['user']; ?>
        </td>
        
        <td>
            <?php echo $d['email']; ?>
        </td>
         <td>
             <?php 
                if ($d['level'] === '9') {
                    echo "Administrator";
                }elseif($d['level'] === '8'){
                    echo "Head Of Department";
                }elseif($d['level'] === '7'){
                    echo "Instructor";
                }
             //echo $d['level']; 
             ?>
         </td>  
            <td>
             <?php echo $d['department']; ?>
         </td>  
         <td>
             <?php 
             if ($d['active'] === '1') {
                ?>
                <a href="usac.php?idk=<?php echo $v; ?>" class="btn btn-sm btn-success <?php echo (($d['user'] == $u)) ? disabled : ''; ?>">Active</a>
                <?php
                // echo '<a href="usac.php?id=" class="btn btn-sm btn-success">Active</a>';
             }else{
                ?>
                <a href="usac.php?idd=<?php echo $v; ?>" class="btn btn-sm btn-danger <?php echo (($d['user'] == $u)) ? disabled : ''; ?>">Inactive</a>
                <?php
             }
             //echo $d['active']; 
             ?>
         </td>  
         <td>
             <?php echo $d['timestamp']; ?>
         </td>  
        
        <td>
        <a href="user_edit?id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>
        <a href="user_manage?u=u&id=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure??');"><i class="fa fa-trash"></i></a>
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
    if (isset($_GET['u']) && $_GET['u'] === 'u') {
        $idd2 = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM `tbl_users` WHERE id=:id");
        $success = $stmt->execute([':id'=>$idd2]);
        if($success){
        ?>
            <script>
                //alert("Department Deleted successfull!");
                window.location.href= 'user_manage';
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
<?php require_once '../includes/footer.php';
} else { logOut(); } ?>