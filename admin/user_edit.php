<?php require_once '../includes/header.php';
use App\DB;
if(hasAuthority('9')){

$conn = DB::getConnection(); ?>
<?php  
    if(isset($_GET['id'])){
        $id = Crypt::decrypt($_GET['id']);
        $res = $conn->prepare("SELECT * FROM `tbl_users` WHERE id=:id");
        $res->execute([':id'=>$id]);
        $data = $res->fetch(PDO::FETCH_ASSOC);


?>
<script type="text/javascript">
    function deptingi(txtx) {
        var btc = document.getElementById('deptings');
        if (txtx.value == 9) {
            btc.style.display = 'none';
        }
        else {
            btc.style.display = 'block';
        }
    }
  </script>
  <style type="text/css">
      #deptings{
        display: block;
      }
  </style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Edit System User <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A");
    }?></i></h2>
        	<hr>
	<form action="" id="edit_user_form" method="POST" onsubmit="return validateForm();">
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-group"><label class="small mb-1" for="dname">Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="Name" value="<?php echo (($data)) ? $data['name'] : ''; ?>" />
                        <p class="help-block errFB errorSpan" id="inputFirstNameError">FullName is Required</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"><label class="small mb-1" for="dcode">Login Username</label><input class="form-control py-4" id="inputUsername" type="text" name="username" value="<?php echo (($data)) ? $data['user'] : ''; ?>" />
                        <p class="help-block errFB errorSpan" id="inputUsernameError">Username is Required</p>
                    </div>
                </div> 
                 <div class="col-md-4">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Email</label><input class="form-control py-4" type="email" id="email" name="email" value="<?php echo (($data)) ? $data['email'] : ''; ?>" />
                    <p class="help-block errFB errorSpan" id="emailError">Email is Required</p>
                    </div>
                </div>                 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1" for="dcolege">Role</label>
                        
                        <select  id="role" name="role" class="form-control" onchange="deptingi(this);">
                            <option value="">Choose From The List...</option>
                            <?php  
                            $stmt = $conn->prepare("SELECT DISTINCT(level)  FROM `tbl_users`");
                            $stmt->execute();
                            while($rk = $stmt->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <option value="<?php echo $rk['level']; ?>"
                               <?php echo (($data)) && $data['level'] == $rk['level'] ? 'selected' : ''; ?> 
                                ><?php 
                                //echo $rk['level']; 
                                if ($rk['level'] === '7') {
                                    echo  "Instructor";
                                }elseif($rk['level'] === '8'){
                                    echo "H.O.D";
                                }elseif($rk['level'] === '9'){
                                    echo "Administrator";
                                }
                                ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <p class="help-block errFB errorSpan" id="roleError">Role is Required</p>
                    </div>
                </div>  
                <div class="col-md-6" id="deptings">
                    <div class="form-group">
                        <label class="small mb-1" for="dcolege">Department</label>
                        
                         <select id="dept" name="dept" class="form-control">
                            <option value="">Choose From The List...</option>
                            <?php  
                            $r = $conn->prepare("SELECT *  FROM `tbl_department`");
                            $r->execute();
                            while($rk = $r->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <option value="<?php echo $rk['department_code']; ?>"
                               <?php echo (($data)) && $data['department'] == $rk['department_code'] ? 'selected' : ''; ?> 
                                ><?php echo $rk['department_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <p class="help-block errFB errorSpan" id="deptError">Department is Required</p>
                    </div>
                </div>  
                <input type="text" name="id3" value="<?php echo (($data)) ? $data['id'] : ''; ?>" style="visibility: hidden;">           
            </div>
            
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="UpdateUser" type="submit">Update User</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>