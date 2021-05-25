<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){
$conn = DB::getConnection();?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Add Course <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">Course Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="courseName" placeholder="Enter Course Name" /></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Course Code</label><input class="form-control py-4" id="inputPassword" type="text" name="courseCode" placeholder="Enter Course Code" /></div>
                </div> 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Credits</label><input class="form-control py-4" id="inputPassword" type="text" name="courseCredit" placeholder="Enter Course Credits" /></div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1" for="dcolege">Semester</label>
                        <!-- <input class="form-control py-4" id="inputPassword" type="text" name="progDept" placeholder="Enter Program Department" /> -->
                        <select id="semester" name="semester" class="form-control">
                            <option value="0">Choose...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>                 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Status</label>
                        <!-- <input class="form-control py-4" id="inputPassword" type="text" name="yos" placeholder="Enter Year Of Study" /> -->
                        <select id="sts" name="status" class="form-control">
                            <option value="0">Choose...</option>
                            <option value="Core">Core</option>
                            <option value="Elective">Elective</option>
                          </select> 
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Department</label>                        
                        <select id="semester" name="dept" class="form-control">
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
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="AddCourse" type="submit">Add Course</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; } else{ logOut(); }?>