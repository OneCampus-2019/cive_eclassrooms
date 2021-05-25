<?php require_once '../includes/header.php'; ?>
<?php 
use App\DB;
$conn = DB::getConnection();
if(hasAuthority('8')){ 
    $stmt = $conn->prepare("SELECT department FROM `tbl_users` WHERE name=:name");
    $stmt->execute([':name'=>$n]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    if($data == null){ exit();}
    $k = $data->department;
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Upload Students <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
            <div class="row" >
            <div class="col-xl-3 col-md-3" >
                <h4>Upload List By Excel</h4>
	       <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group"><label class="small mb-1" for="dname">Deprtment Name</label><input class="form-control" id="inputFirstName" type="text" name="deptName" value="<?php echo $k; ?>" readonly/></div> <!-- the name should be fetched -->
                </div>
                
            </div>
            
            
            
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group"><label class="small mb-1" for="dname">Upload excel File</label>
                    	<input class="form-control-file py-2" id="inputFirstName" type="file" name="excel" placeholder="Enter Course Name" /></div> <!-- the name should be fetched -->
                </div>                              
            </div>
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="astd" type="submit">Upload Students</button>
            </div>
        </form>
    </div>
    <!-- *************************************************************** -->
    <div class="col-xl-2 col-md-2" style="border-right: 1px solid #bbb;">
        <h5>Download format</h5>
        <a href="../upload/template/Add_Students_template.xls" class="btn btn-primary">
            <i class="fa fa-4x fa-download"></i>
        </a>        
    </div>
    <!-- *************************************************************** -->
    <div class="col-xl-7 col-md-7" >
        <h4>Add Single Student</h4>
        <form action="" id="upload_std" method="POST" onsubmit="return validateForm();">
        <!-- this div is for javascript validation -->
        <div id="errorDiv" align="center"></div>
        <!-- //this div is for javascript validation -->
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="small mb-1" for="dname">Student Name</label><input class="form-control" id="stdName" type="text" name="stdName" placeholder="Enter Student Name" />
                        <p class="help-block errFB errorSpan" id="stdNameError">Student Name is Required</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group"><label class="small mb-1" for="dcode">Registration Number</label><input class="form-control" id="regNo" type="text" name="regNo" placeholder="Enter Registration Number" /></div>
                </div> 
                 <div class="col-md-4">
                    <div class="form-group"><label class="small mb-1" for="dname">Department Name</label><input class="form-control" id="deptName" type="text" name="deptName" value="<?php echo $k; ?>" readonly/></div>
                </div> 
            </div>
            
            
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group"><label class="small mb-1" for="yos">Year Of Study</label>
                        <select id="yos" name="yos" class="form-control">
                            <option value="">Choose From The List...</option>
                           <option value="1">First Year</option>
                            <option value="2">Second Year</option>
                            <option value="3">Third Year</option>
                            <option value="4">Fourth Year</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group"><label class="small mb-1" for="yos">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="">Choose From The List...</option>
                           <option value="M">MALE</option>
                            <option value="F">FEMALE</option>
                            
                        </select>
                    </div>
                </div>  
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Program Name</label>
                        
                        <select id="progName" name="progName" class="form-control">
                            <option value="">Choose From The List...</option>
                            <?php  
                            $r = $conn->prepare("SELECT *  FROM `tbl_programs`");
                            $r->execute();
                            while($rk = $r->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <option value="<?php echo $rk['program_name']; ?>">

                                <?php 
                                $year = "";
                                if($rk['duration'] == 1){
                                    $year = "1st Year";
                                }else if($rk['duration'] == 2){
                                    $year = "2nd Year";
                                }else if($rk['duration'] == 3){
                                    $year = "3rd Year";
                                }else if($rk['duration'] == 4){
                                    $year = "4th Year";
                                }
                                echo $rk['program_name']." (".$year.")";
                                
                             ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>               
            </div>
            <div class="form-group mt-4 mb-0">
                <button class="btn btn-primary" name="AddStd" type="submit">Add Student</button>
            </div>
        </form>
    </div>
</div>
	</div>


<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>
