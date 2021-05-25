<?php require_once '../includes/header.php';?>
<?php use App\DB; 
if(hasAuthority('7') || hasAuthority('8')){
?>
<script>

$('document').ready(function(){

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
        <div class="container-fluid-fluid">
            <h3 class="mt-4 ml-2"><?php  
            $code = NULL;
            if(isset($_GET['code'])){
              $code = Crypt::decrypt($_GET['code']);
             $_SESSION['code']=$code;
              $_SESSION['cid']=Crypt::decrypt($_GET['id']);
           }else{
            $code =  $_SESSION['code'];
            $cid =  $_SESSION['cid'];
           }
           
          

           
         
              echo "Class ".$code;
            ?> <i class="pull-right muted mr-2" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h3>
           
            <hr>

            <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#forum">Forum</a>
    </li>
    <!--<li class="nav-item dropdown">
	    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Quiz</a>
	    <div class="dropdown-menu">
	      <a class="dropdown-item" data-toggle="tab" href="#nq">New Quiz</a>
	      <a class="dropdown-item" data-toggle="tab" href="#nqq">Response</a>	      
	    </div>
	</li>-->
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#manage">Class materials</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#anno">Announcements</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#assignement">Assignments</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#lab">Labs</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#tutorial">Tutorials</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#cageneration">CA Generation</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#los">List Of Students</a>
    </li>

    
  </ul>
  <!-- end of nav tab -->

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="forum" class="container-fluid tab-pane active"><br>
      <?php require_once 'forum.php'; ?>      
    </div>
    <!--<div id="nq" class="container-fluid tab-pane fade"><br>
      <?php //require_once 'mannq.php'; ?>
    </div>
    <div id="nqq" class="container-fluid tab-pane fade"><br>
      <?php //require_once 'stdqq.php'; ?>
    </div>-->
    <div id="manage" class="container-fluid tab-pane fade"><br>
      <?php require_once 'manf.php'; ?>
    </div>
    <div id="anno" class="container-fluid tab-pane fade"><br>
      <?php require_once 'ann.php'; ?>
    </div>
    <div id="assignement" class="container-fluid tab-pane fade"><br>
      <?php require_once 'myassignment.php'; ?>  
    </div>
    <div id="lab" class="container-fluid tab-pane fade"><br>
      <?php require_once 'mylabs.php'; ?>  
    </div>
     <div id="tutorial" class="container-fluid tab-pane fade"><br>
      <?php require_once 'tutorials.php'; ?>  
    </div>
     <div id="cageneration" class="container-fluid tab-pane fade"><br>
      <?php require_once('cagen.php'); ?>
    </div>
    <div id="los" class="container-fluid tab-pane fade"><br>
      <?php require_once 'los.php'; ?>
    </div>

 
  </div>
  <!-- end of tab panels -->

<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>