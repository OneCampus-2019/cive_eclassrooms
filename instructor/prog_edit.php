<?php require_once '../includes/header.php'; ?>
<?php  
use App\DB;
$conn = DB::getConnection();
    if(isset($_GET['id'])){
        $id = Crypt::decrypt($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM `tbl_programs` WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
    }

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
            <h2 class="mt-4">Edit Program <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
            <hr>
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-md-12">Program Name</label>
                                    <div class="col-md-12">
                                        <input type="text" name="pname" class="form-control form-control-sm" readonly="readonly" value="<?php echo $data !=null ? $data->program_name : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-form-label col-md-12">Program Code</label>
                                    <div class="col-md-12">
                                        <input type="text" name="pcode" class="form-control form-control-sm" readonly="readonly" value="<?php echo $data !=null ? $data->program_code : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-md-12">Program College</label>
                                    <div class="col-md-12">
                                        <input type="text" name="pcollege" class="form-control form-control-sm" readonly="readonly" value="<?php echo $data !=null ? $data->program_college : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-form-label col-md-12">Program Department</label>
                                    <div class="col-md-12">
                                        <input type="text" name="pdept" class="form-control form-control-sm" readonly="readonly" value="<?php echo $data !=null ? $data->program_department : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                       <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-md-12">Year of Study</label>
                                    <div class="col-md-12">
                                        <input type="text" name="pyos" class="form-control form-control-sm" readonly="readonly" value="<?php echo $data !=null ? $data->duration : '' ?>">
                                         <input type="hidden" name="pid" class="form-control form-control-sm" readonly="readonly" value="<?php echo $data !=null ? $data->id : '' ?>">
                                    </div>
                                </div>
                            </div>
                           
                    </div>
                </div>
                 <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-md-12 small mb-1">Assign Semester One Courses</label>
                                    <div class="col-md-12">
                                        <select type="text" name="courses[]" class="form-control form-control-sm" multiple="multiple" id="members-select" data-placeholder="Select one or more course. Type to search.">
                                             <?php
                define("TABLE_PROS", 'tbl_programs');
                define("TABLE_COURSE", 'tbl_course');
                // testing 
                $ii = Crypt::decrypt($_GET['id']);
                $current_members = array();
                
                $stm = $conn->prepare("SELECT * FROM " . TABLE_PROS . " WHERE id = :id");
                $stm->execute([':id'=>$ii]);
                
                if ( $stm->rowCount() > 0) {                    
                        $member_data = $stm->fetch(PDO::FETCH_ASSOC);
                        $current_members[] = $member_data['assigned_to'];
                }

                // end of testing
                    $sql = $conn->prepare("SELECT * FROM " . TABLE_COURSE . " WHERE course_semester=:course_semester ORDER BY course_name ASC");
                    $sql->execute([':course_semester'=>1]);
                    
                    $xx = array();
                    $yy = explode(", ", $member_data['assigned_to']);
                    foreach ($yy as $k) {
                        $xx[] = $k;
                    }
                    while ( $row = $sql->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <option value="<?php echo $row["course_code"]; ?>"
                        <?php
                                if (in_array($row["course_code"],$xx)) {
                                    echo ' selected="selected"';        
                                }                            
                        ?>
                        ><?php echo $row["course_code"]; ?>
                            
                        </option>
                        <?php
                    }
                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-md-12 small mb-1">Assign Semester Two Courses</label>
                                    <div class="col-md-12">
                                        <select type="text" name="courses[]" class="form-control form-control-sm" multiple="multiple" id="members-select1" data-placeholder="Select one or more course. Type to search.">
                                             <?php
                // testing 
                $ii = Crypt::decrypt($_GET['id']);
                $current_members = array();
                
                $res = $conn->prepare("SELECT * FROM " . TABLE_PROS . " WHERE id = :id");
                $res->execute([':id'=>$ii]);
                
                if ( $res->rowCount() > 0) {                    
                        $member_data = $res->fetch(PDO::FETCH_ASSOC);
                        $current_members[] = $member_data['assigned_to'];
                }

                // end of testing
                    $statment = $conn->prepare("SELECT * FROM " . TABLE_COURSE . " WHERE course_semester=:course_semester ORDER BY course_name ASC");
                    $statment->execute([':course_semester'=>2]);
                    
                    $xx = array();
                    $yy = explode(", ", $member_data['assigned_to']);
                    foreach ($yy as $k) {
                        $xx[] = $k;
                    }
                    while ($row = $statment->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <option value="<?php echo $row["course_code"]; ?>"
                        <?php
                                if (in_array($row["course_code"],$xx)) {
                                    echo ' selected="selected"';        
                                }                            
                        ?>
                        ><?php echo $row["course_code"]; ?>
                            
                        </option>
                        <?php
                    }
                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row float-right mr-0">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm " name="UpdateProgs">Update Program</button> 
                        </div>
                    </div>
                   
                      
                  
                    </div>
                    
            </div>
            </form>
 
    </div>

<?php 
        if (isset($_POST['UpdateProgs'])) {
            $pname = $_POST['pname'];
            $pcode = $_POST['pcode'];
            $pcol = $_POST['pcollege'];
            $pdept = $_POST['pdept'];
            $yosa = $_POST['pyos'];
            $pid = $_POST['pid'];
            $kaka = isset($_POST['courses']) ? implode(', ', $_POST['courses']) : '';
            
            //hamna tena ku updtate itakuwa ni insert
            try{
                $conn->beginTransaction();
            $upd = $conn->prepare("UPDATE `tbl_programs` SET program_name=:program_name,program_code=:program_code,program_college=:program_college,program_department=:program_department,assigned_to=:assigned_to WHERE id=:id ");
            $upd->execute([':program_name'=>$pname, ':program_code'=>$pcode, ':program_college'=>$pcol, ':program_department'=>$pdept, ':assigned_to'=>$kaka, ':id'=>$pid]);

            $upd2 = $conn->prepare("UPDATE `tbl_students` SET courses=:courses WHERE programme_name LIKE :programme_name AND year_of_study=:year_of_study");
            $upd2->execute([':programme_name'=>'%'.$pname.'%', ':year_of_study'=>$yosa, ':courses'=>$kaka]);
            $conn->commit();
           // header('Location:prog_edit?id='.Crypt::encrypt($ids));
              // header("location:".$_SERVER['REQUEST_URI']);
            echo "<script>window.location.href='".$_SERVER['REQUEST_URI']."'</script>";
   
        }catch(\PDOException $e){
            $conn->rollBack();
            echo "Something went wrong";
        }

            //header('location: config_prog.php');
            //echo "zimeenda";
        }

      ?>
<script>
        $(document).ready(function(){
            $("#members-select").select2({
                    //placeholder: "select country", //placeholder
                    tags: true,
                    tokenSeparators: ['/',',',';'," "],
                    search: true 
                });
              $("#members-select1").select2({
                    //placeholder: "select country", //placeholder
                    tags: true,
                    tokenSeparators: ['/',',',';'," "],
                    search: true 
                });
            })

    </script>
<?php require_once '../includes/footer.php'; ?>