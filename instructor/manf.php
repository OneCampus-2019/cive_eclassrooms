<script type="text/javascript">
$('document').ready(function(){
$('#file').click(function(e){
    e.preventDefault();
	var loc=$(this).parent().parent().attr('href');
	alert(loc);



})


})
  
  </script>
  <style type="text/css">
      #ddtt{
        display: block;
      }
      #kk{
        display: block;
      }
	  form 
	  {
		  width:100%;
		
	  }
	 video 
	 {
		 max-width:250px;
		 max-height:150px;
	 }
  </style>
<?php 
use App\DB;
$conn = DB::getConnection();
$cod = NULL;
	if(isset($_GET['code'])){
	$cod = Crypt::decrypt($_GET['code']);
	$_SESSION['codex']=$cod;
     }else{
     	$cod=$_SESSION['codex'];
     }
	
	$sel = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE  for_course=:for_course && as_in=:as_in ORDER BY id DESC");
	$sel->execute([':for_course'=>$cod, ':as_in'=>'material']);
	$datas = $sel->fetchAll();
	if($sel->rowCount()<=0){print("<div class='alert alert-info alert-dismissible col-md-12'><h4 align='center'>No material found</h4><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong></strong></div>");}
	else{
	//$mimi = $m['course_code'];

	// $q = "SELECT * FROM `tbl_students` ORDER BY courses DESC";
	// $qq = mysqli_query($con,$q);
	// $nr = mysqli_num_rows($qq);
?>
<div id="thetable" style="width:70%;max-height:500px; float:left;overflow:auto">
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" style="overflow:auto;overflow-wrap: break-word">
	<thead>
			<tr>
				<th>
					
				</th>
				<th>
					<?php echo "File details"; ?>
				</th>
				<!-- <th>
					number of download
				</th> -->
				<th>
					Action
				</th>
			</tr>
	</thead>
	<tbody>
		<?php 
		foreach($datas as $m){
		 ?>
		<tr>
			<td>
			<?php $filename=$m['file_name']; $ext=pathinfo($filename,PATHINFO_EXTENSION);
			if(!in_array($ext, ['mp4', 'mkv', 'MKV', 'mp3'])){
			?>
				<a href="#"><div id="obj" style="width:250px;height:150px;border:solid 1px #ccd;overflow:hidden;display:inline-block;border-radius:8px; box-shadow:4px 4px rgba(0,0,0,.5); padding:10px"><object data="" id="file" style="min-width:100%;min-height:100%;padding:10px;overflow:hidden"><i class="fa fa-book fa-6x"></i></object></div></a>
			<?php }else{ ?>
			    <a href="watch?v=<?php echo Crypt::encrypt($m['id']); ?>&code=<?php echo  Crypt::encrypt($cod);?>"><?php echo '<video src="../upload/data/'.$filename.'"></video>'; ?></a>
			<?php } ?>
			</td>
			<td style="overflow-wrap: break-word">
			<b>file: </b><a href="#"><div id="filename" style="width:250px;height:200px;overflow-wrap: break-word"><?php echo $m['file_name']."<br><br><br><b style='color:black'>uploaded by: ".$m['owner']."</b>"; ?></div></a>
			</td>
			<!-- <td>
				<?php //echo $m['no_downloads']; ?>
			</td> -->
			<td>
				<!-- mechanism to delete file from database,server forum coments -->
				<a href="delf.php?mif=<?php echo Crypt::encrypt($m['id']); ?>&kkk=<?php echo $_GET['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php 
			}
		
		?>
	</tbody>
</table>
</div>
<?php } ?>
<div id="uploadnew" style="width:25%; float:left; margin-left:2%; border:solid 1px #ccc; border-radius:7px;padding:10px;padding-left:6%">

 
		 <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
		 	<h4>Upload Materials</h4>	
		 	<div class="form-group row">
			    <label class="col-sm-2 col-form-label">File</label>
			    <div class="col-sm-6">
			      <input type="file" name="myfile" class="form-control-file" >
			    </div>
			</div>
			<div class="inside_form_buttons">
				<button type="submit" name="save" class="btn btn-wide btn-primary">UPLOAD</button>
			</div>

			<input type="text" name="course" value="<?php echo $_SESSION['codex']; ?>" style="visibility: hidden;">
			<input type="text" name="as_in" value="material" style="visibility: hidden;">
		 	<input type="text" name="inst" value="<?php echo $n; ?>" style="visibility: hidden;">
		 	
			    
			</form>
</div>
<script>
    $(document).ready(function() {
    $('#dataTables-example').DataTable();
} );
    </script>
