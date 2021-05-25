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

	$sel = $conn->prepare("SELECT * FROM `tbl_posts` WHERE for_course=:for_course AND title <> :title");
	$sel->execute([':title'=>'quizs', ':for_course'=>$fc]);
	$anouncements = $sel->fetchAll(PDO::FETCH_ASSOC);
?>

	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-exa12">
		<thead>
			<tr>
				<th>
					Post ID
				</th>
				<th>
					Title
				</th>
				<th>
					Posted by
				</th>
				<th>
					expire date
				</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($anouncements as $m){
		 ?>
		<tr>
			<td>
				<?php echo $m['postid']; ?>
			</td>
			<td>
				<?php echo $m['title']; ?>
			</td>
			<td>
				<?php echo $m['postedby']; ?>
			</td>
			<td>
				<?php echo $m['exp_date']; ?>
			</td>
			<td>
			<!-- <a href="include/downf.php?file_id=<?php //echo $m[id]; ?>" class="btn btn-primary btn-sm">
				<i class="fa fa-eye"></i><span class="button_label">VIEW</span>
			</a> -->
			<button data-id="<?php echo $m['postid']; ?>" id="getHist" class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit"><i class="fa fa-eye fa-fw"></i></button>  
			</td>
		</tr>
		<?php 
			}
		?>
		</tbody>
		</table>
		
<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="academLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ANNOUNCEMENT VIEW</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body col-md-12">
          
           <div id="dynamic-contentHist"></div> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-sm btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- end of modal -->
				<script>
    $(document).ready(function() {
    $('#dataTables-exa12').DataTable();
} );
    </script>