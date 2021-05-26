<?php 
use App\DB;
	  			$cod = Crypt::decrypt($_GET['id']);
	  			$sel = $conn->prepare("SELECT course_code FROM `tbl_course` WHERE id=:id");
	  			$sel->execute([':id'=>$cod]);
	  			$m = $sel->fetch(PDO::FETCH_ASSOC);
	  			$mimi = $m['course_code'];

				$q = $conn->prepare("SELECT * FROM tbl_students WHERE FIND_IN_SET(:courses, replace(courses, ', ', ',')) ORDER BY courses DESC");
				$q->execute([':courses'=>$mimi]);
				$students = $q->fetchAll(PDO::FETCH_ASSOC);
					$nr = $q->rowCount();
					//echo $nr;
			 ?>

			
				

				<table width="100%" class="table table-striped table-bordered table-hover" id="studentList">
		<thead>
			<tr>
				

				<th>
					Student Name
				</th>

				<th>
					Registration no
				</th>

				<th>
					Year of Study
				</th>
				
				<th>
					Program name
				</th>
				<th>
				Action
				</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		// echo $mimi .' '.$cod;
			$count = 0;
		foreach($students as $d){
				$mi = explode(", ",$d['courses']);
				//$exploded_array = explode('~', $str);
			
				   	$count++;
		 ?>
		<tr class="table_row">
			
			<td>
				<?php echo $d['student_name']; ?>
			</td>

			<td>
				<?php echo $d['registration_no']; ?>
			</td>
			
			<td>
				<?php  echo $d['year_of_study']; ?>
			</td>
			<td>
				<?php  echo $d['programme_name'];?>
			</td>
			
			<td>
			<?php
			$idds=Crypt::encrypt($d['id']);
			print '<a href="std_edit?id='.$idds.'" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>';
			?>
			</td>


			
			<?php 
				
			
		}
		echo  "<h4>TOTAL: " .$count."</h4";
			 ?>

		</tbody>
		</table>

<script>
    $(function() {
    $('#studentList').DataTable();
   } );
    </script>