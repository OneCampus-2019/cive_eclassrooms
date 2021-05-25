<?php require_once '../includes/header.php'; 

use App\DB;
if(hasAuthority('7') || hasAuthority('8')){
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid-fluid">
         <?php  
            $conn = DB::getConnection();
            if(isset($_GET['assid'])){
              try{
              $assid = Crypt::decrypt($_GET['assid']);
            }catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex){
              die($ex->getMessage());

            }
              
           }else{
            return;
           }
          
            ?> 
            

  <div class="col-md-12 col-sm-12 col-lg-12">
    <div class="row">
      <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
        <main style="height:100vh;">
          <?php 
        $stmt = $conn->prepare("SELECT * FROM tbl_submit WHERE id=:id");
        $stmt->execute([':id'=>$assid]);
        $task = $stmt->fetch(PDO::FETCH_OBJ);
        if($task !=null){
         ?>
        
        <iframe src="../upload/data/<?php echo $task->file_ans; ?>" width="100%" height="100%" allowfullscreen>
          
        </iframe>
        </main>
        
      </div>
      <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3 mt-0" style="height:100%;">
        <div class="card" style="min-height: 200px;">
          <div class="card-header small" style="background-color: #323639 !important; color:#ffffff; border-top:0">
            <span class="card-title">Student Name: <?php  echo $task->uploaded_by; ?></span>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal">
              <div class="form-group row p-0" style="padding:0;">
            <div class="input-group mb-3">
              <?php if($task->status == 'unmarked'): ?>
                 <input type="number" class="form-control" aria-label="Marks" aria-describedby="Marks" style="direction: ltr;" min=0 max="<?php echo $task->total_marks; ?>" name="grade" required />
                 <?php else: ?>
                  <input type="number" class="form-control" aria-label="Marks" aria-describedby="Marks" style="direction: ltr;" min=0 max="<?php echo $task->total_marks; ?>" value="<?php echo $task->result; ?>" name="grade" id="grade" required/>
                <?php endif ?>
                <div class="input-group-append">
                <span class="input-group-text bg-light font-weight-bold" id="basic-addon2">/<?php echo $task->total_marks; ?></span>
                </div>
          </div>
              </div>
              <div class="form-group row float-right">
                <?php if($task->status == 'unmarked'): ?>
                <button class="btn btn-primary mr-0" name="submit" type="submit">Return</button>
                <?php else: ?>
                  <div class="btn-encloser"> 
                    <button class="btn btn-secondary mr-0 disabled" type="button">Return</button>
                  </div>
                  
                <?php endif ?>
              </div>
             
             
            </form>
            <?php if(isset($_POST['submit']) && !empty($_POST['grade'])){
              $grade = $_POST['grade'];
             $stmt = $conn->prepare("UPDATE tbl_submit SET result=:result, status=:status WHERE id=:id");
             $stmt->execute([':result'=>$grade, ':id'=>$assid, ':status'=>'marked']);
            ?>
            <script>

              if(window.history.replaceState){

                window.history.replaceState(null, null, window.location.href);
                 window.location.reload();

              }
            </script>
            <?php
             


            } ?>
          </div>
        </div>
        
      </div>
    </div>
    
  </div>


<?php require_once '../includes/footer.php'; } else{

  echo "<div class='alert alert dismissible alert-info mt-4'>
  <button class='close' data-dismiss='alert'>&times;</button>
  <strong>No any result found!</strong>
  </div>";
}
?>
<script>

$(document).ready(function(){

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

        localStorage.setItem('activeTab', $(e.target).attr('href'));

    });

    var activeTab = localStorage.getItem('activeTab');

    if(activeTab){
  
        $('#myTab a[href="' + activeTab + '"]').tab('show');

    }
    //activate /de active return button
    $(document).on('keyup', '#grade', function(){
      //alert($(this).val());
      var result = '<?php echo $task->result; ?>';
      var total_marks = '<?php echo $task->total_marks; ?>';
      if($(this).val() == result){
        $(".btn-encloser").find('button').remove();
        $(".btn-encloser").append('<button class="btn btn-secondary disabled" type="button">Return</button>');
       
      }else{
        $(".btn-encloser").find('button').remove();
        $(".btn-encloser").append('<button class="btn btn-primary" type="submit" name="submit">Return</button>');
      
      }
    })


});
  

</script>
<?php } else { logOut(); } ?>