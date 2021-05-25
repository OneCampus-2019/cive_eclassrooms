<?php session_start(); ?>
<?php require_once '../includes/db/db.php'; 

use App\DB;?>
<?php require_once '../includes/auth.php'; ?>
<?php require_once '../classes/sec.php'; ?>
<?php 
$conn =DB::getConnection();

 if(isset($_POST["id"]))  
 {  
      $output = '';  
        
      $query = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE `id` = :id");  
      $query->execute([':id'=>$_POST['id']]); 
      $output .= '';  
      while($row = $query->fetch(PDO::FETCH_ASSOC))  
      {  
         $output .= ' 

    <div class="container">
      <div class="row">      
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  toppad" >
   
          <div class="card card-info">

            <div class="card-body">

              <div class="row">
                <div class="col-md-12 col-lg-12 " align="center"> 
                <table class="table table-sm table-hover table-striped">
                    <tr>
                        <td>Course code</td>
                        <td><small>'.$row['for_course'].'</small></td>
                    </tr>
                    <tr>
                        <td>Uploaded for</td>
                        <td><small>'.$row['as_in'].'</small></td>
                    </tr>
                    <tr>
                        <td>Uploaded by</td>
                        <td><small>'.$row['owner'].'</small></td>
                    </tr>
                    <tr>
                        <td>Date uploaded</td>
                        <td><small>'.$row['date_created'].'</small></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><small>'.$row['expire_date'].'</small></td>
                    </tr>
                </table>
                <div class="row">
                    
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <a href="downf.php?file_id='.Crypt::encrypt($row['id']).'" class="btn btn-info w-100"><i class="fa fa-download"></i> Download File</a>
                    </div>
                </div>

                  
                </div>
                
              </div>
            </div>
           
            
          </div>
        </div>
      </div>
    </div>
                '; 
      //to add in that table
      $stmt = $conn->prepare("SELECT * FROM `tbl_notification` WHERE student=:student AND material=:material");
      $stmt->execute([':student'=>$imn, ':material'=>$row['id']]);
      $roja = $stmt->rowCount();
      if($roja > 0){

      }else{
        $q = $conn->prepare("INSERT INTO `tbl_notification` SET student=:student , material=:material");
        $q->execute([':student'=>$imn, ':material'=>$row['id']]);
      }

      
         
      }  
      $output .= "";           
      echo $output;  
 }else{
  echo "none";
 } 
 ?>