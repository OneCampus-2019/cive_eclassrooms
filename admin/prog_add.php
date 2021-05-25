<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
$conn = DB::getConnection();?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Add Program <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">program Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="progName" placeholder="Enter Program Name" /></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Program Code</label><input class="form-control py-4" id="inputPassword" type="text" name="progCode" placeholder="Enter Program Code" /></div>
                </div> 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Program College</label><input class="form-control py-4" id="inputPassword" type="text" name="progCollege" placeholder="Enter Program college" /></div>
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
                            <option value="<?php echo $rk['department_code']; ?>"><?php echo $rk['department_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>                 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Year Of Study</label><input class="form-control py-4" id="inputPassword" type="text" name="yos" placeholder="Enter Year Of Study" /></div>
                </div>                
            </div>
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="AddProg" type="submit">Add Program</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; } else {logOut();}?>