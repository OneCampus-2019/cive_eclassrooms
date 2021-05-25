<?php require_once '../includes/header.php';
use App\DB;
$conn = DB::getConnection(); ?>
<?php  
if(hasAuthority('9')){

    if(isset($_GET['id'])){
        $id = Crypt::decrypt($_GET['id']);

        $res = $conn->prepare("SELECT * FROM `tbl_students` WHERE id=:id");
        $res->execute([':id'=>$id]);
        $data = $res->fetch(PDO::FETCH_ASSOC);
    }

?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Edit Student <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>

        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">Student Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="Name"  value="<?php echo (($data)) ? $data['student_name'] : ''; ?>" /></div>
                </div>
                 
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Login Username / Username</label><input class="form-control py-4" id="inputUN" type="text" name="logName" value="<?php echo (($data)) ? $data['registration_no'] : ''; ?>"/></div>
                    <input class="form-control py-4" id="inputPassword" type="text" name="id2" value="<?php echo (($data)) ? $data['id'] : ''; ?>" style="visibility: hidden;"/>
                </div>
            </div>
            <div class="form-group mb-0">
            	<button class="btn btn-primary" name="UpdateStd" type="submit">Update</button>
            </div>
        </form>
	</div>

    <script type="text/javascript">
        function jau() {
            var btc = document.getElementById('inputFirstName').value;
            var dtc = document.getElementById('inputPassword');
            var names = btc.split(" ");
            dtc.value = names[names.length - 1];
            
        }
    </script>


<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>