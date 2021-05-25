<?php 
     session_start();
require_once '../includes/db/db.php'; 
use App\DB;
?>
	<?php 
	$conn = DB::getConnection();
	 
	       $n=$_SESSION['name'];

	           $ass_marks=[];

				$cod = $_SESSION['cid'];
				$ass=$_GET['ass'];
				$reduce=$_GET['reduce'];
				$total_agg=$_GET['agg'];
				  //print $cod;
	  			$sel = $conn->prepare("SELECT course_code FROM `tbl_course` WHERE id=:id");
	  			$sel->execute([':id'=>$cod]);
	  			$m = $sel->fetch();
	  			$mimi = $m['course_code'];
          
				  $q = $conn->prepare("SELECT * FROM `tbl_students` ORDER BY registration_no DESC");
				  $q->execute();
				  $students= $q->fetchAll();
					$nr = $q->rowCount();

			
			foreach($students as $d ){
				$mi = explode(", ",$d['courses']);
				//$exploded_array = explode('~', $str);
				foreach ($mi as $hapa)
				{
				   if($mimi === $hapa){
				   
	  			$total_marks=0;
				
			//////////////////////////////////////////
			    $name=$d['student_name'];
				$q1 = "SELECT * FROM `tbl_submit` WHERE course=:course AND instructor=:instructor";
					$qq1 = $conn->prepare($q1);
					$qq1->execute([':course'=>$mimi, ':instructor'=>$n]);
					$datas = $qq1->fetchAll(PDO::FETCH_ASSOC);
					$nr = $qq1->rowCount();
				$ass_marks[$d['registration_no']]=0;			
		        foreach($datas as $m)
				{
					for($as=0;$as<count($ass);$as++)
					{
				    if($ass[$as]==$m['file_task_name'])
					{
				   if($name==$m['uploaded_by'])
				   {
                   $total_marks=$total_marks+$m['result'];
				   if($reduce==0){$ass_marks[$d['registration_no']]=$total_marks;}
				   else{$ass_marks[$d['registration_no']]=number_format(($total_marks*$reduce)/$total_agg,2);}
					}

				}
					
				    }
			    }
		
				

			}
		}
	}
		
			print(json_encode($ass_marks));
				
	?>





