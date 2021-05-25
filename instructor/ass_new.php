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
  <script type="text/javascript">
   $(document).ready(function(){
   $('#nq').keyup(function(){
	//$('#totm').val(0);
   $('#mpq').html("");
   var noq=parseInt($(this).val());
   for(var n=1; n<=noq; n++){
   var qobj='<input id="q'+n+'" type="text" placeholder="Q'+n+'" name="q_max[]" style="width:50px;height:50px;border-color:#ccc; border-radius:7px" />';
   $('#mpq').append(qobj);
   }
   
   })
   var maxima=0;
   
   $('#mpq').on('keyup','input',function(){
   var num_item=$('#mpq').children().length;
   var total_marks=0;
   for(var t=0;t<num_item;t++)
   {
	   
	   
	       var qm=0;
		   if(isNaN(parseFloat($('#mpq').children().eq(t).val()))){qm=0;}
		   else{ qm=parseFloat($('#mpq').children().eq(t).val());}
		   total_marks=total_marks+qm;
	
		 
	   
   }
   
   if(isNaN(total_marks)){total_marks=parseFloat(total_marks);}
   $('#totm').val(total_marks);
   maxima=total_marks;

   })
   
  $('#totm').blur(function(){

 if($('#nq').val()!="" && parseInt($('#nq').val())>0)
 {
   
   if(parseFloat($('#totm').val())!=maxima)
   {
	   alert("the total maxima must be equal to the total of all the question maxima");
	   if(maxima>0){$('#totm').val(maxima);}else{$('#totm').val("");}
   }
    

 }



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
  </style>
  <div class="modal fade" role="dialog" id="NewAssignment">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
               <div class="modal-header">
               <span class="modal-title">Create New Assignment</span>
            </div>
              <div class="modal-body">
			  <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" style="width:100%">
			  <div class="form-group row" >
			    <label class="col-sm-4 col-form-label">Assignemt Title</label>
			    <div class="col-sm-8">
			      <textarea id="ass-title" type="text" name="title" class="form-control required" placeholder="Assignment Title"></textarea>
			    </div>
			</div>
		 	
			
			<div class="form-group row" >
			    <label class="col-sm-4 col-form-label">Number of questions</label>
			    <div class="col-sm-8">
			      <input id="nq" type="number" name="qnumber" class="form-control required" min=0 max=10  required="required"/>
			    </div>
			</div>
			<div id="mpdiv" class="form-group row" >
			    <label class="col-sm-4 col-form-label">Maxima per question</label>
			    <div id="mpq" style="margin-left:15px">
			   
			    </div>
			</div>
			<div id="ddtt">	
		 	 <div class="form-group row" >
			    <label class="col-sm-4 col-form-label">Deadline</label>
			    <div class="col-sm-8">
			      <input type="date" name="expr" class="form-control required"  required="required"/>
			    </div>
			</div>
			</div>	
			<div id="kk">	
			<div class="form-group row">
			    <label class="col-sm-4 col-form-label">Total Marks</label>
			    <div class="col-sm-8">
			      <input id="totm" type="text" name="tm" class="form-control required" required="required"/>
			    </div>
			</div>	
			<div class="form-group row">
			    <label class="col-sm-4 col-form-label">File</label>
			    <div class="col-sm-8">
			      <input type="file" name="myfile" class="form-control-file" required="required">
			    </div>
			</div>
		</div>
			
			
			<div class="inside_form_buttons float-right">
				<button type="submit" name="newass" class="btn btn-wide btn-primary">Create</button>
			</div>

			<input type="text" name="course" value="<?php echo $course->course_code; ?>" style="visibility: hidden;">
		 	<input type="text" name="inst" value="<?php echo $n; ?>" style="visibility: hidden;">
		 	<input type="hidden" name="as_in" value="assignment">
			    
			</form>
             </div>
        </div>
        </div>
        </div>
		