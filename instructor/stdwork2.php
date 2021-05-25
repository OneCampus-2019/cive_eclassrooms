<?php use App\DB;
 ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
<?php 
$conn = DB::getConnection();

	  			$sel = $conn->prepare("SELECT course_code FROM `tbl_course` WHERE id=:id");
	  			$sel->execute([':id'=>$cod]);
	  			$m = $sel->fetch(PDO::FETCH_ASSOC);
	  			$mimi = $m['course_code'];
                $tot=0;
	  			$q1 = "SELECT * FROM `tbl_students` WHERE FIND_IN_SET(:courses, courses)ORDER BY courses DESC";
					$stmt = $conn->prepare($q1);
					$stmt->execute([':courses'=>$mimi]);
					$nr1 = $stmt->rowCount();
			$count1 = $nr1;
			while($d1 = $stmt->fetch(PDO::FETCH_ASSOC)){
				//$mi = explode(", ",$d1['courses']);
				//$exploded_array = explode('~', $str);
				/*foreach ($mi as $hapa)
				{
				   if($mimi === $hapa){
				   	$count1++;
				   }
				}*/

			}
			$nr=0;
			if($ass){
				$q = "SELECT * FROM `tbl_submit` WHERE course=:course AND instructor=:instructor AND file_task_name=:file_task_name ORDER BY course DESC";
					$qq = $conn->prepare($q);
					$qq->execute([':course'=>$mimi, ':instructor'=>$n, ':file_task_name'=>$ass]);
					$students = $qq->fetchAll(PDO::FETCH_ASSOC);
					$nr = $qq->rowCount();
					}
			  if($nr>0)
			  {		//echo $nr;
			 ?>

			
							
				<div class="clear"></div>

				

				<div class="clear"></div>

				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-ex2">
		<thead>
			<tr>
				<th>
					#
				</th>

				<th>
					Registration no
				</th>

				<!-- <th>
					Question
				</th> -->
				
				<th>
					Answer
				</th>
				
				<th>
					Grading
				</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		// echo $mimi .' '.$cod;
			$count = 0;
			foreach($students as $d){
				$x = $conn->prepare("SELECT * FROM `tbl_students` WHERE student_name=:student_name ");
				$x->execute([':student_name'=>$d['uploaded_by']]);
				$tot=$d['total_marks'];
				$v = $x->fetch();
				//$mi = explode(", ",$d['courses']);
				
				   	$count++;
		 ?>
		<tr class="table_row">
			<td>
				<?php echo $count; ?>
			</td>
			
			<td>
				<?php echo $v['registration_no']; ?>
			</td>
			<!-- <td>
				<?php //echo $d['file_task_name']; ?>
			</td> -->
			<td id='<?php  echo $d['id']; ?>'>
				<a  href="../upload/data/<?php  echo $d['file_ans']; ?>">
				<?php  echo $d['file_ans'];?>
				</a>
			</td>
			
			<td>
				<?php  
					if ($d['status'] == "marked") {
						echo "<button class='btn btn-sm btn-success disabled'><i class='fa fa-check'></i></button>";
					}
				?>
			</td>
			</tr>
			<?php 
				
		}
	
			 ?>
      
		</tbody>
		</table>
		<script>
    $(document).ready(function() {
    $('#dataTables-ex2').DataTable();
} );
    </script>




<?php
			  }

			  else{ $count=0; print ("no any submissions yet");}
			  ?>
		<!-- Modal -->

</div>
</div>

<!-- end of modal -->