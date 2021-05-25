<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
?>
<?php  

$conn = DB::getConnection();
    if(isset($_GET['id'])){
        $id = Crypt::decrypt($_GET['id']);
        $res = $conn->prepare("SELECT * FROM `tbl_programs` WHERE id=:id");
        $res->execute([':id'=>$id]);
        $data = $res->fetch(PDO::FETCH_ASSOC);
    }

?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Edit Program <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">Program Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="progName"  value="<?php echo (($data)) ? $data['program_name'] : ''; ?>" /></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Program Code</label><input class="form-control py-4" id="inputPassword" type="text" name="progCode" value="<?php echo (($data)) ? $data['program_code'] : ''; ?>" /></div>
                </div> 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Program College</label><input class="form-control py-4" id="inputPassword" type="text" name="progCollege" value="<?php echo (($data)) ? $data['program_college'] : ''; ?>" /></div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Program Department</label>
                        
                        <select id="semester" name="progDept" class="form-control">
                            <option value="">Choose From The List...</option>
                            <?php  
                            $r = $conn->prepare("SELECT *  FROM `tbl_department`");
                            $r->execute();
                            while($rk = $r->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <option value="<?php echo $rk['department_code']; ?>"
                               <?php echo (($data)) && $data['program_department'] == $rk['department_code'] ? 'selected' : ''; ?> 
                                ><?php echo $rk['department_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>                 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Year Of Study</label><input class="form-control py-4" id="inputPassword" type="text" name="yos" value="<?php echo (($data)) ? $data['duration'] : ''; ?>" /></div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control py-4" id="inputPassword" type="text" name="iddd" value="<?php echo (($data)) ? $data['id'] : ''; ?>" style="visibility: hidden;"/></div>
                </div>               
            </div>
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="UpdateProg" type="submit">Update Program</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php';
} else { logOut(); } ?>