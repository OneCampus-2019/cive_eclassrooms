<?php 
require_once('../includes/db/db.php');
use App\DB;
$conn = DB::getConnection();

 if(isset($_POST["id"]))  
 {  
      $output = '';  
        
      $query = $conn->prepare("SELECT * FROM tbl_posts WHERE postid = :postid");  
    $query->execute([':postid'=>$_POST['id']]);
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
      $output .= '';  
      foreach($posts as $row)  
      {  
         $output .= ' 

    <div class="container">
      <div class="row">      
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  toppad" >
   
          <div class="panel panel-info">

            <div class="panel-body">

              <div class="row">
                <div class="col-md-10 col-lg-10 " align="center"> 

                  <h3><b>'.$row["title"].'</b></h3>
                  <p>'.$row["body"].'</p>
                  <p>Posted by <b>'.$row["postedby"].'</b> on '.$row["time"].'</p>
                  
                </div>
                
              </div>
            </div>
           
            
          </div>
        </div>
      </div>
    </div>
                '; 
         
      }  
      $output .= "";  
      echo $output;  
 }else{
  echo "none";
 } 
 ?>