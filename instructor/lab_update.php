 <style type="text/css">
      #ddtt{
        display: block;
      }
      #kk{
        display: block;
      }
  </style>
  <div class="modal fade" role="dialog" id="EditAssignemtnModal">
  	<div class="modal-dialog" role="document">
  		<div class="modal-content">
  			<div class="modal-header">
  				<h3 class="modal-title">Edit Lab</h3>
  			</div>
  			<div class="modal-body">
  				 <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" style="width:100%">
		 	
			<div id="ddtt">	
		 	 <div class="form-group row" >
			    <label class="col-sm-2 col-form-label">Deadline</label>
			    <div class="col-sm-10">
			      <input type="date" name="expire_date" class="form-control required" id="expire_date" />
			      <input type="hidden" name="assid" class="form-control required" id="assid" />
			    </div>
			</div>
			</div>	
	
			<div class="inside_form_buttons">
				<button type="submit" name="ass_update" class="btn btn-wide btn-primary float-right">UPDATE</button>
			</div>

			<input type="text" name="course" value="" style="visibility: hidden;">
		 	<input type="text" name="inst" value="<?php echo $n; ?>" style="visibility: hidden;">
			 <input  id="fid" type="text" name="fid"  style="visibility: hidden;">
		 	
			    
			</form>
  			</div>
  		</div>
  	</div>
  	
  </div>
		