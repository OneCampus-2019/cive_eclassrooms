<style>
  .modal-header, h4, .close {
    background-color: #5cb85c;
    color:white !important;
    text-align: center;
    font-size: 30px;
    /*height: 70px;*/
  }
  .modal-footer {
    background-color: #f9f9f9;
  }
</style>
<?php 
	$k = Crypt::decrypt($_GET['id']);
	$stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id =:id");
	$stmt->execute([':id'=>$k]);
	$dd = $stmt->fetch(PDO::FETCH_ASSOC);
if($dd == null){
	exit();
}
		$fc = $dd['course_code'];
		$fcd = $dd['id'];
	$sel = $conn->prepare("SELECT * FROM `tbl_posts` WHERE for_course=:for_course AND title = :title ");
	$sel->execute([':for_course'=>$fc, ':title'=>'quizs']);
	$quizs = $sel->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	//$mimi = $m['course_code'];

	// $q = "SELECT * FROM `tbl_students` ORDER BY courses DESC";
	// $qq = mysqli_query($con,$q);
	// $nr = mysqli_num_rows($qq);
?>
<br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example22">
	<thead>
			<tr>
				<th>
					Course Name
				</th>
				<th>
					Instructor
				</th>
				<th>
					Deadline
				</th>
				<th>
					Marks
				</th>
				<th>View & Answer</th>
			</tr>
	</thead>
	<tbody>
		<?php 
		foreach($quizs as $m ){
		 ?>
		<tr>
			<td>
				<?php echo $m['for_course']; ?>
			</td>
			<td>
				<?php echo $m['postedby']; ?>
			</td>
			<td>
				<?php echo $m['time']; ?>
			</td>
			<td>
				<?php echo $m['marks']; ?>
			</td>
			<td>
				<button data-id="<?php echo $m['postid'].",".$n.",".$fc.",".$fcd; ?>" id="getQuiz" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editjibu">
					<i class="fa fa-eye fa-fw"></i> & <i class="fa fa-question"></i>
				</button> 
				
			</td>
		</tr>
		<?php 
			}
		?>
	</tbody>
</table>
<script>
    $(document).ready(function() {
    $('#dataTables-example22').DataTable();
} );
    </script>

<!-- Modal -->
<div class="modal fade" id="editjibu" tabindex="-1" role="dialog" aria-labelledby="academLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding:35px 50px;">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel"><span class="fa fa-pencil-alt"></span>QUIZ</h3>
      </div>

      <div class="modal-body col-md-12">
          
           <div id="dynamic-contentQuiz"></div> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- end of modal -->