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
	$sel = $conn->prepare("SELECT * FROM `tbl_submit` WHERE course=:course AND uploaded_by=:uploaded_by");
	$sel->execute([':course'=>$fc, ':uploaded_by'=>$n]);
	$results = $sel->fetchAll(PDO::FETCH_ASSOC);
?>

	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-exa11">
		<thead>
			<tr>
				<th>
					File Name
				</th>
				<th>
					Total Marks
				</th>
				<th>
					What i Get
				</th>
				
				<th>
					Instructor
				</th>
				<th>Task</th>
                <th>Status</th>
                
               
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($results as $m){
		 ?>
		<tr>
			<td>
				<?php echo $m['file_ans']; ?>
			</td>
			<td>
				<?php echo $m['total_marks']; ?>
			</td>
			
			<td>
				<?php 
					if ($m['status'] == 'unmarked' && $m['result'] == 0) {
						echo "-";
					}else{
						echo $m['result'];
					}
				?>
			</td>
            <td>
				<?php echo $m['instructor']; ?>
			</td>
			<td>
				<?php echo $m['file_as']; ?>
			</td>
			<td>
				<?php echo $m['status']; ?>
			</td>
			
		</tr>
		<?php 
			}
		?>
		</tbody>
		</table>

				<script>
    $(document).ready(function() {
    $('#dataTables-exa11').DataTable();
} );
    </script>