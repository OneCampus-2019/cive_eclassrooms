<?php
use App\DB; 
$conn = DB::getConnection();
	$k = Crypt::decrypt($_GET['id']);
	$stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id =:id");
    $stmt->execute([':id'=>$k]);
    $dd = $stmt->fetch(PDO::FETCH_ASSOC);
    if($dd == null){
        exit();
    }
	$fc = $dd['course_code'];

    $sel2 = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in AND file_name NOT LIKE :file_name");
    $sel2->execute([':file_name'=>'%.mp4', ':as_in'=>'material', ':for_course'=>$fc]);
    $sel3 = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in = :as_in AND file_name LIKE :file_name");
    $sel3->execute([':file_name'=>'%.mp4' , ':as_in'=>'material', ':for_course'=>$fc]);
    $tutalsql = $conn->prepare("SELECT * FROM tbl_uploads WHERE for_course=:for_course AND as_in=:as_in");
    $tutalsql->execute([':for_course'=>$fc, 'as_in'=>'tutorial']);
    $tutalCount = $tutalsql->rowCount();
	$no_of_lecture_materials = $sel2->rowCount();
	$no_of_video_materials = $sel3->rowCount();
?>

<div class="row">
    <div class="card bg-info text-white col-sm-3 mr-4" style="height: 200px">
        <div class="card-body">
            <a href="lectures_and_notes?id=<?php echo Crypt::encrypt($k); ?>" style="font-weight: bold; font-size: large; color: white;text-decoration: none">Lectures and Notes</a>
        </div>

        <div class="card-footer d-flex align-content-center justify-content-between">
            <i><img src="../assets/icons/lecture_notes.PNG" height="40px" width="40px"></i>
            <h3><?php echo $no_of_lecture_materials ?></h3>
            <h1></h1>
            <h1></h1>
        </div>
    </div>

    <div class="card bg-info text-white col-sm-3 mr-4" style="height: 200px">
        <div class="card-body">
            <a href="videos?id=<?php echo Crypt::encrypt($k);?>" style="text-decoration: none; font-size: large; color: white; font-weight: bold">Videos</a>
        </div>

        <div class="card-footer d-flex align-content-center justify-content-between">
            <i><img src="../assets/icons/video_notes.png" height="40px" width="40px"></i>
            <h3><?php echo $no_of_video_materials ?></h3>
            <h1></h1>
            <h1></h1>

        </div>
    </div>
     <div class="card bg-info text-white col-sm-3 mr-4" style="height: 200px">
        <div class="card-body">
           <a href="tutorials?id=<?php echo Crypt::encrypt($k); ?>" style="font-weight: bold; font-size: large; color: white;text-decoration: none">Tutorials</a>
        </div>

        <div class="card-footer d-flex align-content-center justify-content-between">
            <i><img src="../assets/icons/lecture_notes.png" height="40px" width="40px"></i>
            <h3><?php echo $tutalCount; ?></h3>
            <h1></h1>
            <h1></h1>

        </div>
    </div>

</div>
