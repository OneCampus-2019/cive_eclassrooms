<?php require_once '../includes/header.php';
use App\DB; ?>
<?php 
$conn = DB::getConnection(); 
	//if(isset($_GET['id'])){
      
        $res = $conn->prepare("SELECT * FROM `tbl_users` WHERE name=:name");
        $res->execute([':name'=>$n]);
        $data = $res->fetch(PDO::FETCH_ASSOC);
    //}
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Account Setting/Change password <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" id="add_user_form" method="POST" onsubmit="return validateForm();">
             <div class="form-row">
                 <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dcolege"> Old Password</label>
                    <input class="form-control" id="oldPassword" type="password" name="oldpass" placeholder="Enter Old Password" required="required" />
                    <!-- <p class="help-block errFB errorSpan" id="inputPasswordError">Password is Required</p> -->
                    <!--<div class="help-block errFB errorSpan" id="inputPasswordError"></div>-->
                </div>
            </div>
                                
            </div>
            <div class="form-row">
                  <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dcolege"> New Password</label>
                    <input class="form-control" id="inputPassword" type="password" name="newpass" placeholder="Enter New Password" />
                    <!-- <p class="help-block errFB errorSpan" id="inputPasswordError">Password is Required</p> -->
                    <div class="help-block errFB errorSpan" id="inputPasswordError"></div>
                </div>
            </div>
                                
            </div>
            
            <input type="text" name="id" value="<?php echo $data['id'];?>" style="visibility: hidden;"/>
            <input type="text" name="lv" value="<?php echo $l; ?>" style="visibility: hidden;"/>
            
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="setAcc" type="submit">Save</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; ?>