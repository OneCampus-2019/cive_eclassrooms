<?php require_once '../includes/db/db.php'; ?>
<?php require_once '../includes/auth.php'; ?>
<?php 
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
			$g = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `tbl_users` WHERE name='".$n."'"));
			//echo $u ."<br>".$n;
			$gg = $g['user'];

				$q = "SELECT * FROM `tbl_quiz` WHERE course='".$mimi."' AND quiz_by='".$gg."' ORDER BY course DESC";
					$qq = mysqli_query($con,$q);
					$nr = mysqli_num_rows($qq);
					//echo $nr;
			 ?>

			
							
				<div class="clear"></div>

				

				<div class="clear"></div>

				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-ex">
		<thead>
			<tr>
				<th>
					#
				</th>

				<th>
					Student Name
				</th>
				<th>
					Registration no
				</th>

				<th>
					Type
				</th>

				<th>
					Uploaded_on
				</th>
				<!-- <th>
					Question
				</th> -->
				
				<th>
					Grading
				</th>
				
				
			</tr>
		</thead>
		<tbody>
		<?php 
		// echo $mimi .' '.$cod;
			$count = 0;
			while($d = mysqli_fetch_assoc($qq)){
				$x = mysqli_query($con,"SELECT * FROM `tbl_students` WHERE student_name='".$d['student']."' ");
				$v = mysqli_fetch_assoc($x);
				//$mi = explode(", ",$d['courses']);
				
				   	$count++;
		 ?>
		<tr class="table_row">
			<td>
				<?php echo $count; ?>
			</td>
			
			<td>
				<?php echo $d['student']; ?>
			</td>
			<td>
				<?php echo $v['registration_no']; ?>
			</td>

			<td>
				Quiz
			</td>
			
			<td>
				<?php  echo $d['date']; ?>
			</td>
			
			
			<td>
				<button data-id="<?php echo $d['id'].",".$_GET['id']; ?>" id="getPdf" class="btn btn-sm btn-info <?php echo $d['status'] == "marked" ? disabled : ''; ?>" data-toggle="modal" data-target="#pdfing"><i class="fa fa-eye fa-fw"></i></button> 
				<?php  
					if ($d['status'] == "marked") {
						echo "<button class='btn btn-sm btn-success disabled'><i class='fa fa-check'></i></button>";
					}
				?>
			</td>
			
			<?php 
				
		}
		//hapa natakiwa kupata idadi ya wanafunzi wanaosoma hili somo.
		echo  "<h3>TOTAL STUDENT SUBMIT: " .$count." / <span style='color: #f55;'>".$count1."</span></h3";
			 ?>

		</tbody>
		</table>

<script>
    $(document).ready(function() {
    $('#dataTables-ex').DataTable();
} );
    </script>

<?php 
	if (isset($_POST['ggg'])) {
		$g = mysqli_real_escape_string($con,$_POST['grad']);
		$tt = mysqli_real_escape_string($con,$_POST['tat']);
		$idd = mysqli_real_escape_string($con,$_POST['idd']);
		if($g > $tt){
			?>
			<script type="text/javascript">alert("You Can not Put Marks > Total Marks");</script>
			<?php
		}elseif(!isset($g) || empty($g)){
			?>
			<script type="text/javascript">alert("Please Enter Marks First");</script>
			<?php
		}else{
			mysqli_query($con,"UPDATE `tbl_submit` SET result='".$g."',status='marked' WHERE id='".$idd."' ");
			header('location: manage_my_course.php?id='.$cod);
		}
		
		//header('location: manage_my_course.php?id='.$cod);
	}

 ?>



		<!-- Modal -->
<div class="modal fade" id="pdfing" tabindex="-1" role="dialog" aria-labelledby="academLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Grading Quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body col-md-12">
         <div id="dynamic-contentpdf"></div>     
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- end of modal -->

