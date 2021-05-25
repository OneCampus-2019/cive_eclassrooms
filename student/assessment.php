<?php
use App\DB;
if(hasAuthority('0')){
$conn = DB::getConnection();
$k = Crypt::decrypt($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id =:id");
$stmt->execute([':id'=>$k]);
$dd = $stmt->fetch(PDO::FETCH_ASSOC);
if($dd==null){
    exit();
}
$fc = $dd['course_code'];
$sel1 = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in");
$sel1->execute([':for_course'=>$fc, ':as_in'=>'assignment']);
$sel4 = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in");
$sel4->execute([':for_course'=>$fc, ':as_in'=>'lab']);

$no_of_assignment = $sel1->rowCount();
$no_of_labs = $sel4->rowCount();
?>

<div class="row">
    <div class="card bg-info text-white col-sm-3" style="height: 200px">
        <div class="card-body">
            <a href="assignment?id=<?php echo Crypt::encrypt($k); ?>" style="font-weight: bold; font-size: large; color: white;text-decoration: none">Assignments</a>
        </div>

        <div class="card-footer d-flex align-content-center justify-content-between">
            <i><img src="../assets/icons/assignment.png" height="40px" width="40px"/></i>
            <h3><?php echo $no_of_assignment; ?></h3>
            <h1></h1>
            <h1></h1>
        </div>
    </div>

    <div style="width: 20px"></div>

    <div class="card col-sm-3 text-white bg-info" style="height: 200px">
        <div class="card-body">
            <a href="labs?id=<?php echo Crypt::encrypt($k); ?>" style="font-weight: bold; font-size: large; color: white; text-decoration: none">Labs</a>
        </div>

        <div class="card-footer d-flex align-content-center justify-content-between">
            <i><img src="../assets/icons/lab.png" height="40px" width="40px"></i>
            <h3><?php echo $no_of_labs?></h3>
            <h1></h1>
            <h1></h1>
        </div>
    </div>
</div>
<?php } else{ logOut(); } ?>
