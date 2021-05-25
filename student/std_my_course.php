<?php require_once '../includes/header.php'; 
use App\DB;?>
<script>

$(document).ready(function(){

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

        localStorage.setItem('activeTab', $(e.target).attr('href'));

    });

    var activeTab = localStorage.getItem('activeTab');

    if(activeTab){
  
        $('#myTab a[href="' + activeTab + '"]').tab('show');

    }

});
	$('.tab').click(function(){
	var a=$(this).attr('id');
	$('#myTab').html('Active Tab is'+a);
	});
</script>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h3 class="mt-4">Dashboard <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h3>
            <hr>

            <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#forum">Forum</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#assessment">Assessment</a>
    </li>
      <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#upload">Course materials</a>
      </li>
    
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#returned">Returned</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#anno">Announcement</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#quiz">Quiz</a>
    </li>
    
  </ul>
  <!-- end of nav tab -->

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="forum" class="container tab-pane active"><br>
      <?php require_once 'forum.php'; ?> 
    </div>
    <div id="upload" class="container tab-pane fade"><br>
      <?php require_once 'upload_material.php'; ?>
    </div>

      <div id="assessment" class="container tab-pane fade"><br>
          <?php require_once 'assessment.php'; ?>
      </div>
    
    <div id="returned" class="container tab-pane fade"><br>
      <?php require_once 'stdr.php'; ?>
    </div>
    <div id="anno" class="container tab-pane fade"><br>
      <?php require_once 'stdan.php'; ?>
    </div>
    <div id="quiz" class="container tab-pane fade"><br>
      <?php require_once 'stdq.php'; ?>
    </div>
    
  </div>
  <!-- end of tab panels -->
</div>
       


<?php require_once '../includes/footer.php'; ?>