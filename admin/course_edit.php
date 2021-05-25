<?php require_once '../includes/header.php'; 
use App\DB;?>
<?php 
if(hasAuthority('9')){
$conn = DB::getConnection(); 
    if(isset($_GET['id'])){
        $id = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    }

?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Edit Course <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">Course Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="courseName" value="<?php echo (($data)) ? $data['course_name'] : ''; ?>" /></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Course Code</label><input class="form-control py-4" id="inputPassword" type="text" name="courseCode" value="<?php echo (($data)) ? $data['course_code'] : ''; ?>" /></div>
                </div> 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Credits</label><input class="form-control py-4" id="inputPassword" type="text" name="courseCredit" value="<?php echo (($data)) ? $data['course_credits'] : ''; ?>" /></div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1" for="dcolege">Semester</label>                        
                        <!-- <select id="semester" name="semester" class="form-control">
                            <option value="0">Choose...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select> -->
                        <select id="semester" name="semester" class="form-control">
                            <option value="">Choose From The List...</option>
                            <?php 
                           // $holder = array(); 
                            $semesters = [
                                ['id'=>1, 'name'=>'Semester One'], 
                                ['id'=>2, 'name'=>'Semester Two']
                            ];
                          
                            foreach($semesters as $sem){
                            ?>
                            <option value="<?php echo $sem['id']; ?>"
                               <?php echo (($data)) && $data['course_semester'] == $sem['id'] ? 'selected' : ''; ?> 
                                ><?php echo $sem['name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>                 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Status</label>
                        <!-- <input class="form-control py-4" id="inputPassword" type="text" name="yos" placeholder="Enter Year Of Study" /> -->
                        <!-- <select id="sts" name="status" class="form-control">
                            <option value="0">Choose...</option>
                            <option value="Core">Core</option>
                            <option value="Elective">Elective</option>
                          </select>  -->
                          <select id="semester" name="status" class="form-control">
                            <option value="">Choose From The List...</option>
                            <?php  
                         $r = $conn->prepare("SELECT DISTINCT(status)  FROM `tbl_course`");
                            $r->execute();
                            while($rk = $r->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <option value="<?php echo $rk['status']; ?>"
                               <?php echo (($data)) && $data['status'] == $rk['status'] ? 'selected' : ''; ?> 
                                ><?php echo $rk['status']; ?></option>
                            <?php
                            }
                            ?>
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
                            <option value="<?php echo $rk['department_code']; ?>"
                               <?php echo (($data)) && $data['department'] == $rk['department_code'] ? 'selected' : ''; ?> 
                                ><?php echo $rk['department_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select> 
                    </div>
                </div>                
            </div>
            <div class="form-row">
                <input type="text" name="id1" value="<?php echo (($data)) ? $data['id'] : ''; ?>" style="visibility: hidden;">
            </div>
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="UpdateCourse" type="submit">Update Course</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; } else { logOut(); }?>