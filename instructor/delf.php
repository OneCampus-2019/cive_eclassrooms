<?php 
    session_start();
    
	include('../includes/db/db.php');
	use App\DB;
	require_once('../classes/sec.php');
$conn = DB::getConnection();
	if (isset($_GET['mif'])) {
		$id = Crypt::decrypt($_GET['mif']);
		
		$k = $_GET['kkk'];
		$cd=$_SESSION['code'];
		$rq=$conn->prepare("SELECT * FROM `tbl_uploads` WHERE id=:id");
		$rq->execute([':id'=>$id]);
		$r = $rq->fetch();
		$fn = $r['file_name'];
		$folder_del=false;
		$req=false;
		$req2=false;
		$req3=false;
		$sub_del=false;
		$req4=false;
	   
		
		
		//deleting questions if assignment
		if($r['as_in']=="assignment" || $r['as_in']=="lab")
		{
			$conn->beginTransaction();

			$sql=$conn->prepare("delete from ass_questions where assID=:assID");
			$req2 = $sql->execute([':assID'=>$id]);
			//deleting all submits files
			$sql2=$conn->prepare("select * from tbl_submit where file_task_name=:file_task_name");
			$sql2->execute([':file_task_name'=>$fn]);
			$submits=$sql2->fetchAll();
			if($sql2->rowCount()>0){
			foreach($submits as $res)
			{
			if(file_exists('../upload/data/'.$res['file_ans'])){
			if(unlink('../upload/data/'.$res['file_ans'])){$sub_del=true;}else{$sub_del=false;}
			}
			else{$sub_del=true;}
			}
		    }else{ $sub_del=true;}
		    if(file_exists('../upload/data/'.$fn)){
			if(unlink('../upload/data/'.$fn)){$folder_del=true;}
			} //deleting all assignment files
			else{$folder_del=true;}
			
			//deleting all submits
			$sql3=$conn->prepare("delete from tbl_submit where file_task_name=:file_task_name");
			$req3 = $sql3->execute([':file_task_name'=>$fn]);
			$req4=$conn->prepare("DELETE FROM `tbl_uploads` WHERE id=:id");
			$req4 = $req4->execute([':id'=>$id]);

		if($folder_del && $req2 && $req3 && $req4)
		{
			$conn->commit();
			   header("location: manage_my_course.php?id=".$k."&&code=".Crypt::encrypt($cd));
		}
		else{
			
			$conn->rollBack();
			   header("location: manage_my_course.php?id=".$k."&&code=".Crypt::encrypt($cd));
			echo "<script>alert('deleting failed')</script>";
			
		}
         
		}
		//deleting other files
		
		else
		{
		  $conn->beginTransaction();
		  $mat_del="false";
		  $db_req="false";
		  $stmt = $conn->prepare("DELETE FROM tbl_uploads WHERE id=:id");

		  if( $stmt->execute([':id'=>$id])){$db_req=true;}
		  if(file_exists('../upload/data/'.$fn)){
			if(unlink('../upload/data/'.$fn)){$mat_del=true;}
			}

         if($mat_del && $db_req){
		 $conn->commit();
          header("location: manage_my_course.php?id=".$k."&&code=".Crypt::encrypt($cd));
		 }
		 else{

			$conn->rollBack();
			echo "<script>alert('deleting failed')</script>";
		 }
		}
	}
	if(isset($_POST['action'])){
		if($_POST['action']=='delete_tutorial'){
			ob_start();
			$fid = Crypt::decrypt($_POST['fid']);
			$stmt = $conn->prepare("SELECT * FROM tbl_uploads WHERE id=:id");
			$stmt->execute([':id'=>$fid]);
			$tutorial = $stmt->fetch(PDO::FETCH_OBJ);
			if($tutorial !=null){
				$filename = $tutorial->file_name;
				if(file_exists("../upload/data/".$filename)){
					if(unlink("../upload/data/".$filename)){
						//now delete the tutorial file
						$del = $conn->prepare("DELETE FROM tbl_uploads WHERE id=:id");
						$success = $del->execute([':id'=>$fid]);
						ob_end_clean();
						if($success){
							echo  json_encode(['status'=>'success', 'message'=>'Deleted']);
						}else{
							echo  json_encode(['status'=>'error', 'message'=>'Not Deleted']);
						}
					}

				}
			}
		}
	}
?>