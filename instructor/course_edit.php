<?php require_once '../includes/header.php'; ?>
<?php  
use App\DB;
if(hasAuthority('8') || hasAuthority('7') ){
   $conn = DB::getConnection(); 
    if(isset($_GET['id'])){
        $ii = Crypt::Decrypt($_GET['id']);
        $res = $conn->prepare("SELECT * FROM `tbl_course` WHERE id=:id ");
        $res->execute([':id'=>$ii]);
        $data = $res->fetch(PDO::FETCH_ASSOC);

?>
<style>
        .mul-select{
            width: 100%;
            color: red;
        }
    </style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h2 class="mt-4">Add partner <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
            <hr>
    <form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">Course Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="courseName"  value="<?php echo $data != null ? $data['course_name'] : ''; ?>" readonly/></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Course Code</label><input class="form-control py-4" id="inputPassword" type="text" name="courseCode" value="<?php echo $data !=null ? $data['course_code'] : ''; ?>" readonly/></div>
                </div> 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Semester</label><input class="form-control py-4" id="inputPassword" type="text" name="courseSem" value="<?php echo $data !=null ? $data['course_semester'] : ''; ?>" readonly/></div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Credtits</label><input class="form-control py-4" id="inputPassword" type="text" name="courseCredit" value="<?php echo $data !=null ? $data['course_credits'] : ''; ?>" readonly/></div>
                </div>                 
            </div>
            
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Status</label><input class="form-control py-4" id="inputPassword" type="text" name="status" value="<?php echo $data !=null ? $data['status'] : ''; ?>" readonly/></div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control py-4" id="inputPassword" type="text" name="iddd" value="<?php echo $data !=null ? $data['id'] : ''; ?>" style="visibility: hidden;"/></div>
                </div>               
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1" >Choose an Instructor to Add</label>
                        <select multiple="true" class="mul-select" id="members-select" name="j[]" data-placeholder="Select one or more course. Type to search.">
                <?php
                define("TABLE_USERS", 'tbl_users');
                define("TABLE_COURSE", 'tbl_course');
                // testing 
                $ii = Crypt::decrypt($_GET['id']);
                $current_members = array();
                
                $stmt = $conn->prepare("SELECT * FROM " . TABLE_COURSE . " WHERE id = :id");
                $stmt->execute([':id'=>$ii]);
                if ( $stmt->rowCount() > 0) {                    
                        $member_data = $stmt->fetch(PDO::FETCH_ASSOC);
                        $current_members[] = $member_data['assigned_to'];
                        
                }

                // end of testing
                    $sql = $conn->prepare("SELECT * FROM " . TABLE_USERS . " WHERE level IN(7,8) ORDER BY name ASC");
                    $sql->execute();
                    
                    $xx = array();
                    $yy = explode(", ", $member_data['assigned_to']);
                    foreach ($yy as $k) {
                        $xx[] = $k;
                    }
                    
                    while ( $row = $sql->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <option value="<?php echo $row["name"]; ?>"
                        <?php
                                if (in_array($row["name"],$xx)) {
                                    echo ' selected="selected"';        
                                }                            
                        ?>
                        ><?php echo $row["name"]; ?>
                            
                        </option>
                        <?php
                    }
                ?>
            </select>
                 
                    </div>
                </div>
                
            </div>
            <div class="form-group mt-4 mb-0">
                <button class="btn btn-primary" name="UpdateCourse2" type="submit">Update Course</button>
            </div>
        </form>
    </div>
    <?php  } ?>
<?php 
        if (isset($_POST['UpdateCourse2'])) {
            $cname = $_POST['courseName'];
            $ccode =$_POST['courseCode'];
            $csem = $_POST['courseSem'];
            $ccred = $_POST['courseCredit'];
            $sts = $_POST['status'];
            $ids = $_POST['iddd'];
            $kaka = isset($_POST['j']) ? implode(', ', $_POST['j']): '';
            
            //hamna tena ku updtate itakuwa ni insert
            //$upd = "UPDATE `tbl_programs` SET program_name='$pname',program_code='$pcode',program_college='$pcol',program_department='$pdept',assigned_to='$kaka' WHERE id='".$ids."' ";

            //$upd2 = "UPDATE `tbl_students` SET courses='$kaka' WHERE id<>0 AND programme_name LIKE '$pname%' AND year_of_study='$yosa'";
            $q = $conn->prepare("UPDATE `tbl_course` SET course_name=:course_name, course_code=:course_code, course_semester=:course_semester, status=:status, course_credits=:course_credits, assigned_to=:assigned_to WHERE id=:id ");
            $q->execute([':course_code'=>$ccode, ':course_name'=>$cname, ':course_semester'=>$csem, ':status'=>$sts, ':course_credits'=>$ccred, ':assigned_to'=>$kaka, ':id'=>$ids]);
    		//here we trigger the page after submit for convinience
		  echo "<meta http-equiv='refresh' content='0'>";
            ?>
            <script type="text/javascript">
                alert("Course Configured");
		//here we prevent data submission on page refresh
		 if ( window.history.replaceState ) {
           window.history.replaceState( null, null, window.location.href );
              }
                // hapa tutaangalia kama inastahili kurudi hapa hapa tena au 
                //iende kwenye course_config.php
               // window.location.href= 'course_edit.php?id='+<?php echo Crypt::encrypt($ids); ?>;
            </script>
            <?php
            //header('location: config_prog.php');
            //echo "zimeenda";
        }
   
        if(isset($_GET['action']))
        {
            
        if($_GET['action']=="delete")
        {
            
        if(isset($_GET['name']) && isset($_GET['assigned']))
        {
          $name=strval(Crypt::Decrypt($_GET['name']));
          $assigned=Crypt::Decrypt($_GET['assigned']);
          $idme=Crypt::Decrypt($_GET['did']);

         
          //checking if it is only this user having the course
          if($name==$assigned)
          {
          $q = $conn->prepare("UPDATE `tbl_course` SET assigned_to=:assigned_to WHERE id=:id ");
            $q->execute([':assigned_to'=>"", ':id'=>$idme]);

            print '<script>window.location.href="my_course.php";</script>';


          }
          else
          {
            $all = explode(",",$assigned);

            $myelem=array();

            for($a=0;$a<count($all);$a++)
            {
              $newname=trim(strval($name));
              if(trim(strval($all[$a]))==$newname){

                unset($all[$a]);
                //print '<script>alert("'.$all[$a].'");</script>';
              }
            }

                $newassign=trim(strval(implode(",",$all)));
                //print '<script>alert("'.$newassign.'");</script>';
               $q = $conn->prepare("UPDATE `tbl_course` SET assigned_to=:assigned_to WHERE id=:id ");
               $q->execute([':assigned_to'=>$newassign, ':id'=>$idme]);
    
               print '<script>window.location.href="my_course.php";</script>';
            
          }
        }
    }
    else if($_GET['action']=="takecourse")
    {
        $idme=Crypt::Decrypt($_GET['did']);
        $thename=$_GET['name'];
        $f= $conn->prepare("UPDATE `tbl_course` SET assigned_to=:assigned_to WHERE id=:id ");
        $f->execute([':assigned_to'=>$thename, ':id'=>$idme]);

       print '<script>window.location.href="takecourse.php";</script>';
       //print $thename;


    }
}
  

      ?>
<script>
        $(document).ready(function(){
            $(".mul-select").select2({
                    //placeholder: "select country", //placeholder
                    tags: true,
                    tokenSeparators: ['/',',',';'," "],
                    search: true 
                });
            })
    </script>
<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>
