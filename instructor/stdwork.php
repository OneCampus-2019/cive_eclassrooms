<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('7') || hasAuthority('8')){
?>
<div id="layoutSidenav_content">

    <main>
        <div class="container-fluid">
		<div class="inside_form_buttons float-right">
			
            <?php if(isset($_GET['id']) && isset($_GET['ass'])){ ?>
            
	    </div>
            <h3 class="mt-4"><?php print "Class: ".Crypt::decrypt($_GET['code'])."==>".$_GET['asstit'];?><i class="pull-right muted" style="font-size: 18px;"><?php //echo date("F d, Y h:i:s A"); ?></i></h3>
            <hr>
			
<?php 
$conn = DB::getConnection();

			
				  $cod = Crypt::decrypt($_GET['id']);
				  $ass=Crypt::decrypt($_GET['ass']);

	  			$sel = $conn->prepare("SELECT course_code FROM tbl_course WHERE id=:id");
	  			$sel->execute([':id'=>$cod]);
	  	
	  			$m = $sel->fetch();
	  			
	  			$mimi = $m['course_code'];

	  			$q1 = $conn->prepare("SELECT * FROM `tbl_students` ORDER BY courses DESC");
					$q1->execute();
					$students = $q1->fetchAll();
					$nr1 = $q1->rowCount();
			$count1 = 0;
			foreach($students as $d1){
				$mi = explode(", ",$d1['courses']);
				//$exploded_array = explode('~', $str);
				foreach ($mi as $hapa)
				{
				   if($mimi === $hapa){
				   	$count1++;
				   }
				}
			}
				$stmt = $conn->prepare("SELECT * FROM `tbl_submit` WHERE course=:course AND instructor=:instructor AND file_task_name=:file_task_name AND status=:status  GROUP BY uploaded_by DESC");
				$stmt->execute([':course'=>$mimi, ':instructor'=>$n, ':file_task_name'=>$ass, ':status'=>'unmarked']);
				
					
					$stdworks = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nr = $stmt->rowCount();
							//echo $nr;
			 ?>

			
							
				<div class="clear">	</div>

				

				<div class="clear"></div>
				<!-- TABS FOR submitted students, not submitted and graded -->
				<ul class="nav nav-tabs justify-content-center" id="tabs">
					<li class="nav-item">
						<a href="#turnedin" class="nav-link active" data-toggle="tab">Turned In</a>
					</li>
					<li class="nav-item">
						<a href="#assigned" class="nav-link" data-toggle="tab">Assigned</a>
					</li>
					<li class="nav-item">
						<a href="#marked" class="nav-link" data-toggle="tab">Marked</a>
					</li>
					
					
				</ul>
				<div class="tab-content mt-2">
					<div class="tab-pane container-fluid active" id="turnedin">
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-ex2">
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
			foreach($stdworks as $d){
				$x = $conn->prepare("SELECT * FROM `tbl_students` WHERE student_name=:student_name ");
				$x->execute([':student_name'=>$d['uploaded_by']]);
				$v = $x->fetch(PDO::FETCH_ASSOC);
				//$mi = explode(", ",$d['courses']);
				
				   	$count++;
		 ?>
		<tr class="table_row">
			<td>
				<?php echo $count; ?>
			</td>
			
			<td>
				<?php echo $d['uploaded_by']; ?>
			</td>
			<td>
				<?php echo $v['registration_no']; ?>
			</td>

			<td>
				<?php echo $d['file_as']; ?>
			</td>
			
			<td>
				<?php  echo $d['uploaded_on']; ?>
			</td>
			<!-- <td>
				<?php //echo $d['file_task_name']; ?>
			</td> -->
			<td>
				<a href="../upload/data/<?php  echo $d['file_ans']; ?>" download>
				<?php  echo $d['file_ans'];?>
				</a>
			</td>
			<td><a href="marking?assid=<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-info btn-sm" target="_blank">
			<span class="fa fa-pencil-alt"></span>
			</a>
			</td>
		</tr>
			
			<?php 
				
		}
		//hapa natakiwa kupata idadi ya wanafunzi wanaosoma hili somo.
		
			 ?>

		</tbody>
		</table>
					</div>
					<div class="tab-pane container-fluid " id="assigned">
						<?php 
							$stmt = $conn->prepare("SELECT * FROM tbl_students WHERE FIND_IN_SET(:courses, replace(courses, ', ', ',')) AND student_name NOT IN (
								SELECT uploaded_by FROM tbl_submit WHERE file_task_name=:file_task_name
						)");
							$stmt->execute([':file_task_name'=>$ass, ':courses'=>$mimi]);
							
							?>
							<table class="table table-bordered table-striped" id="AssignedStudents">
								<thead>
									<tr><th>#</th><th>Student Name</th><th>Registration Number</th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$i = 0;
									while($row =  $stmt->fetch(PDO::FETCH_OBJ)){
										?>
										<tr>
											<td><?php echo ++$i; ?></td>
											<td><?php echo $row->student_name; ?></td>
											<td><?php echo $row->registration_no; ?></td>
										</tr>
										<?php
									}
									 ?>
									

								</tbody>
							</table>
						
					</div>
					<div class="tab-pane container-fluid" id="marked">
						<?php 

						$stm = $conn->prepare("SELECT * FROM tbl_submit WHERE file_task_name=:file_task_name AND instructor=:instructor AND course=:course AND status=:status");
						$stm->execute([':file_task_name'=>$ass, ':instructor'=>$n, ':course'=>$mimi, ':status'=>'marked']);
						 ?>
						 
						 <table class="table table-striped table-bordered" id="MarkedStudents">
						 	<thead>
						 		<tr>
						 			<th>#</th><th>STUDENT NAME</th> <th>REG#</th><th>YOS</th><th>SCORE</th><th>Gradding</th>
						 		</tr>
						 	</thead>
						 	<tbody>
						 		<?php 
						 		$i=0;
						 		$students = $stm->fetchAll(PDO::FETCH_OBJ);
						 		foreach($students as $row){
						 			$st = $conn->prepare("SELECT * FROM tbl_students WHERE student_name=:student_name");
						 			$st->execute([':student_name'=>$row->uploaded_by]);
						 			$s = $st->fetch(PDO::FETCH_OBJ);
						 			if($s !=null){
						 			?>
						 			<tr>
						 				<td><?php echo ++$i; ?></td>
						 				<td><?php echo $row->uploaded_by;?></td>
						 				<td><?php echo $s->registration_no; ?></td>
						 				<td><?php echo $s->year_of_study; ?></td>
						 				<td><?php echo $row->result; ?></td>
						 				<td>
						 					
						 					
						 						<a href="marking?assid=<?php echo Crypt::encrypt($row->id); ?>" class="btn btn-info btn-sm" target="_blank">
						 							<span class="fa fa-pencil-alt"></span>
						 						</a>
						 						
						 				</td>
						 			</tr>
						 			<?php
						 		}

						 		}
						 		 ?>
						 		
						 	</tbody>
						 	
						 </table>
						

					</div>
					
				</div>

			
		<script>
    $(document).ready(function() {
    $('#dataTables-ex2').DataTable();
    $("#AssignedStudents").DataTable({
    	dom: 'Bfrtip',
         buttons: [
         {
         	extend: 'excel',
         	message: 'Export To EXCEL',
         	title: 'Assigned Students'

         },
          {
         	extend: 'pdf',
         	title: 'Assigned Students in PDF'

         },
          {
                extend: 'csv',
                title: 'Assigned Students'
            },
         ]
    });
    $("#MarkedStudents").DataTable({
    	dom: 'Bfrtip',
         buttons: [
         {extend:  'excel',
     		title: 'Marked students',
     		exportOptions: {columns: ':not(:eq(5))'},
     		text: 'Export to Excel',
     		className: 'btn btn-primary btn-sm'
     		},

       ]
    });
       $("#duplicateStudents").DataTable();
    //remember the previous active tab logic
    //get the current active tab
   
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

        localStorage.setItem('activeTab', $(e.target).attr('href'));

    });

    var activeTab = localStorage.getItem('activeTab');

    if(activeTab){
  
        $('#tabs a[href="' + activeTab + '"]').tab('show');

    }

} );
    </script>

<?php 
	/*if (isset($_POST['ggg'])) {
		$g = $_POST['grad'];
		$tt = $_POST['tat'];
		$idd =$_POST['idd'];
		if($g > $tt){
			?>
			<script type="text/javascript">alert("You Can not Put Marks > Total Marks");</script>
			<?php
		}elseif(!isset($g) || empty($g)){
			?>
			<script type="text/javascript">alert("Please Enter Marks First");</script>
			<?php
		}else{
			$stm = $conn->prepare("UPDATE `tbl_submit` SET result=:result,status=:status WHERE id=:id ");
			$stm->execute([':result'=>$g, ':status'=>'marked', ':id'=>$idd]);
			header('location: manage_my_course.php?id='.$cod);
		}
		
		//header('location: manage_my_course.php?id='.$cod);
	}

				*/
}
 ?>



		<!-- Modal -->
<div class="modal fade" id="pdfing" tabindex="-1" role="dialog" aria-labelledby="academLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload The Assignment/Quiz</h5>
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
<?php require_once '../includes/footer.php'; 
} else {logOut();}?>


