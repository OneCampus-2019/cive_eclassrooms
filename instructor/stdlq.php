<?php 
	$q = "SELECT DISTINCT(body),title,time,exp_date FROM `tbl_posts` ORDER BY postid DESC";
	$qq = mysqli_query($con,$q);
	$nr = mysqli_num_rows($qq);
	//echo $nr;

	$cod = mysqli_real_escape_string($con,$_GET['id']);
	$sel = mysqli_query($con,"SELECT course_code FROM `tbl_course` WHERE id='".$cod."'");
	$m = mysqli_fetch_assoc($sel);
	$mimi = $m['course_code'];
	$q1 = "SELECT * FROM `tbl_students` ORDER BY courses DESC";
	$qq1 = mysqli_query($con,$q1);
	$nr1 = mysqli_num_rows($qq1);
	$count1 = 0;
	while($d1 = mysqli_fetch_assoc($qq1)){
		$mi = explode(", ",$d1['courses']);
		//$exploded_array = explode('~', $str);
		foreach ($mi as $hapa)
		{
		   if($mimi === $hapa){
		   	$count1++;
		   }
		}
	}
?>

	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-exa3">
		<thead>			
			<tr>
				<th>
					#
				</th>

				<th>
					Quiz
				</th>

				<th>
					Posted On
				</th>
				<th>
					Due Date
				</th>
				<th>
					Total Student
				</th>
				<th>
					Total Response
				</th>
				<th>
					Action
				</th>
			</tr>
			
		</thead>
		<tbody>
		<?php  
			$cx = 1;
			while ($d = mysqli_fetch_assoc($qq)) {
		?>
		<tr class="table_row">
			
			<td>
				<?php echo $cx; ?>
			</td>

			<td>
				<?php echo $d['body']; ?>
			</td>
			
			<td>
				<?php echo $d['time']; ?>
			</td>
			<td>
				<?php echo $d['exp_date']; ?>
			</td>
			<td>
				<?php echo $count1; ?>
			</td>
			<td>
				<?php echo $d['title']; ?>
			</td>
			<td>
				<button class='btn btn-sm btn-primary'><i class='fa fa-eye'></i></button>
			</td>
			
		</tr>
		<?php
			$cx++; 
			} 
		?>
		</tbody>
		</table>

	<script>
	    $(document).ready(function() {
		    $('#dataTables-exa3').DataTable();
		} );
    </script>