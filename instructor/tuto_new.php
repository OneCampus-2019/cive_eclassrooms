<?php require_once '../includes/db/db.php'; 
use App\DB;?>
<?php require_once '../includes/auth.php'; ?>

  <?php 
  
    $k = Crypt::decrypt($_GET['id']);
    $conn = DB::getConnection();
    $stmt = $conn->prepare("SELECT * FROM tbl_course WHERE id = :id");
    $stmt->execute([':id'=>$k]);
    $course = $stmt->fetch(PDO::FETCH_OBJ);
  ?>

  <style type="text/css">
      #ddtt{
        display: block;
      }
      #kk{
        display: block;
      }
  </style>
  <div class="modal fade" role="dialog" id="NewTutorial">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
               <div class="modal-header">
               <span class="modal-title">Create New Tutorial</span>
            </div>
              <div class="modal-body">
			  <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" style="width:100%">
			  <div class="form-group row" >
			    <label class="col-sm-12 col-form-label">Tutorial Title</label>
			    <div class="col-sm-12">
			      <textarea id="title" type="text" name="title" class="form-control form-control-msm required" placeholder="Tutorial Title" required="required"></textarea>
			    </div>
			</div>
		 	
			<div id="kk">		
			<div class="form-group row">
			    <label class="col-sm-12 col-form-label">File</label>
			    <div class="col-sm-12">
			      <input type="file" name="myfile" class="form-control-file" required="required">
			    </div>
			</div>
		</div>
			
			
			<div class="inside_form_buttons float-right">
				<button type="submit" name="save" class="btn btn-wide btn-primary">Create</button>
			</div>

			<input type="text" name="course" value="<?php echo $course->course_code; ?>" style="visibility: hidden;">
		 	<input type="text" name="inst" value="<?php echo $n; ?>" style="visibility: hidden;">
		 	<input type="hidden" name="as_in" value="tutorial">
			    
			</form>
             </div>
        </div>
        </div>
        </div>
		