<?php 
session_start();
//require_once("../includes/db/db.php");
use App\DB;
$conn = DB::getConnection();
    $g = $_GET['grad'];
    $idd = $_GET['fid'];
    $scores=$_GET['q_scores'];
    $this_ass=$_SESSION['this_ass'];
    $qids=array();
    
    $done=false;
    try{
    $conn->beginTransaction();
    $stmt=$conn->prepaer("UPDATE `tbl_submit` SET result=:result,status=:status WHERE id=:id");
    $stmt->execute([':id'=>$idd, ':status'=>'marked', ':result'=>$g]);
    //selecting the question IDs

    $idq="select * from ass_questions where assID=:assID";
    $req=$conn->prepare($idq);
    $req->execute([':assID'=>$this_ass]);
    if($req->rowCount()>0)
    {
      $push=0;
      while($resp=$req->fetch(PDO::FETCH_ASSOC))
      {
       
       $qids[$push]=$resp['questionID'];
       $push++;

      }
     
    }
   // print count($qids);
    for($data=0;$data<count($scores);$data++)
    { 
      $stmt=$conn->prepare("insert into q_score(submitID,Q_id,score) values(:submitID,:Q_id,:score])");
   $stmt->execute([':submitID'=>$idd, ':Q_id'=>$qids[$data], ':score'=>$scores[$data]]);
      
    }
    $conn->commit();
  }catch(\PDOException $e){
    $conn->rollBack();
    print "Not done, Somthing went wrong";

  }
   
    
   
    //header('location: manage_my_course.php?id='.$cod);

 ?>