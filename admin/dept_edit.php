<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
?>
<?php  
$conn = DB::getConnection();
    if(isset($_GET['id'])){
        $id = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM `tbl_department` WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }

?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Edit Department <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1" for="dname">Department Name</label>
                        <input class="form-control py-4" id="inputFirstName" type="text" name="deptName" value="<?php echo (($data)) ? $data['department_name'] : ''; ?>" />
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        
                        <input class="form-control py-4" id="inputFirstName" type="text" name="idd" value="<?php echo (($data)) ? $data['id'] : ''; ?>" style="visibility: hidden;"/>
                    </div>

                </div>               
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Department Code</label><input class="form-control py-4" id="inputPassword" type="text" name="deptCode" value="<?php echo (($data)) ? $data['department_code'] : ''; ?>" /></div>
                </div>                
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Department College</label><input class="form-control py-4" id="inputPassword" type="text" name="deptCollege" value="<?php echo (($data)) ? $data['department_college'] : ''; ?>"  /></div>
                </div>                
            </div>
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="deptUpdate" type="submit">Update Department</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>