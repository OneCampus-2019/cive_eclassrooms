<?php require_once '../includes/db/db.php';
use App\DB; ?>
<?php require_once '../includes/auth.php'; ?>

  <?php  
  $conn = DB::getConnection();
    $k = Crypt::decrypt($_GET['id']);
    $q = $conn->prepare("SELECT * FROM `tbl_course` WHERE id = :id ");
    $q->execute([':id'=>$k]);

    $dd = $q->fetch(PDO::FETCH_ASSOC);
  ?>
  <script type="text/javascript">
   $(document).ready(function(){
   $('#nql').keyup(function(){
	//$('#totm').val(0);
   $('#mpql').html("");
   var noq=parseInt($(this).val());
   for(var n=1; n<=noq; n++){
   var qobj='<input id="q'+n+'" type="text" placeholder="Q'+n+'" name="q_max[]" style="width:50px;height:50px;border-color:#ccc; border-radius:7px" />';
   $('#mpql').append(qobj);
   }
   
   })
   var maxima=0;
   
   $('#mpql').on('keyup','input',function(){
   var num_item=$('#mpql').children().length;
   var total_marks=0;
   for(var t=0;t<num_item;t++)
   {
	   
	   
	       var qm=0;
		   if(isNaN(parseFloat($('#mpql').children().eq(t).val()))){qm=0;}
		   else{ qm=parseFloat($('#mpql').children().eq(t).val());}
		   total_marks=total_marks+qm;
	
		 
	   
   }
   
   if(isNaN(total_marks)){total_marks=parseFloat(total_marks);}
   $('#totml').val(total_marks);
   maxima=total_marks;

   })
   
  $('#totml').blur(function(){

 if($('#nql').val()!="" && parseInt($('#nql').val())>0)
 {
   
   if(parseFloat($('#totml').val())!=maxima)
   {
	   alert("the total maxima must be equal to the total of all the question maxima");
	   if(maxima>0){$('#totml').val(maxima);}else{$('#totml').val("");}
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
  <div class="modal fade" role="dialog" id="NewLab">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
               <div class="modal-header">
               <span class="modal-title">Create New Lab</span>
			   <button CLASS="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
              <div class="modal-body">
			  <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" style="width:100%">
			  <div class="form-group row" >
			    <label class="col-sm-4 col-form-label">Lab Title</label>
			    <div class="col-sm-8">
			      <textarea id="lab-title" type="text" name="title" class="form-control " placeholder="Lab Title" required="required"></textarea>
			    </div>
			</div>
		 	
			
			<div class="form-group row" >
			    <label class="col-sm-4 col-form-label">Number of questions</label>
			    <div class="col-sm-8">
			      <input id="nql" type="number" name="qnumber" class="form-control required" min=0 max=10 />
			    </div>
			</div>
			<div id="mpdiv" class="form-group row" >
			    <label class="col-sm-4 col-form-label">Maxima per question</label>
			    <div id="mpql" style="margin-left:15px">
			   
			    </div>
			</div>
			<div id="ddtt">	
		 	 <div class="form-group row" >
			    <label class="col-sm-4 col-form-label">Deadline</label>
			    <div class="col-sm-8">
			      <input type="date" name="expr" class="form-control " required="required"/>
			    </div>
			</div>
			</div>	
			<div id="kk">	
			<div class="form-group row">
			    <label class="col-sm-4 col-form-label">Total Marks</label>
			    <div class="col-sm-8">
			      <input id="totml" type="text" name="tm" class="form-control required" required="required"/>
			    </div>
			</div>	
			<div class="form-group row">
			    <label class="col-sm-4 col-form-label">File</label>
			    <div class="col-sm-8">
			      <input type="file" name="myfile" class="form-control-file required" required="required">
			    </div>
			</div>
		</div>
			
			
			<div class="inside_form_buttons float-right">
				<button type="submit" name="newass" class="btn btn-wide btn-primary">Create</button>
			</div>

			<input type="text" name="course" value="<?php echo $dd['course_code']; ?>" style="visibility: hidden;">
		 	<input type="text" name="inst" value="<?php echo $n; ?>" style="visibility: hidden;">
		 	<input type="hidden" name="as_in" value="lab">
			    
			</form>
             </div>
        </div>
        </div>
        </div>
		