<?php 
require_once('../includes/auth.php');
use App\DB;
if(hasAuthority('7') || hasAuthority('8')){ ?>
<style>
h5:hover
{
    background-color:rgba(0,0,0,0.7);
    color:white;
    cursor:pointer;
    border: solid 2px white;
} 
h7:hover
{
    background-color:rgba(0,0,0,0.7);
    color:white;
    cursor:pointer;
    border: solid 2px white;
} 

</style>
<script>
$(document).ready(function(){

$('#newass').click(function(){

$("#ass_form").animate({left: '250px'});
$('#ass_form').css('display','block');



});

$('.update').click(function(){

var assid=$(this).attr('assid');
var expdate=$(this).attr('expdate');
$('#assid').val(assid);
$("#expire_date").val(expdate);


});




})


</script>
            
   <div class="row mb-2">
   <div class="col-md-12 col-sm-12 col-lg-12">
   <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#NewAssignment"><span class="fa fa-plus"></span>New Assignment</button>
   </div>    

   </div>

         <div class="row">
         <div class="col-md-12">
         <div class="row">
  
    <?php 
  
        //this query must added the where clause for only my course
        $mimi = $n;
        $code=NULL;
        if(isset($_GET['code'])){ 
        $_SESSION['code']=Crypt::decrypt($_GET['code']);
        $code=Crypt::decrypt($_GET['code']);
    
    }
        else{$code=$_SESSION['code'];}
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM `tbl_uploads` WHERE for_course=:for_course AND as_in=:as_in ORDER BY id DESC");
        $stmt->execute([':for_course'=>$code, ':as_in'=>'assignment']);
        $assignments = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        //$nr = mysqli_num_rows($qq);
        $k= $stmt->rowCount();
        if($k<=0){
            $jumbe = "<h4 align='center'>No Assignment found</h4>";
            echo '<div class="alert alert-info alert-dismissible col-md-12">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>';
                            echo $jumbe;
                            echo '
                            </strong>
                        </div>';
        }
        else{
            $title="";
        //$asstit="Assignment".$k;
        foreach ($assignments  as $assignment){
           // $mi =$assignment->owner;
            $asstit1="Assignment ".$k;
            //$exploded_array = explode('~', $str);
               //if($mimi ==$mi ){
                
                if($assignment->title==null){$title=$asstit1;}else{$title=$assignment->title;}
     ?> 

            <!-- to be looped -->
            <!-- the color should be randoized from php function -->
  
            <div class="col-xl-3 col-md-4">
                <div class="card bg-info text-white mb-4" style="height:180px" >
          
                <a href="stdwork?ass=<?php echo Crypt::encrypt($assignment->file_name);?>&&id=<?php echo Crypt::encrypt($_GET['id']);?>&&asstit=<?php echo $title;?>&&code=<?php echo $code;?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                    <div class="card-body">
                        <a href="stdwork?ass=<?php echo Crypt::encrypt($assignment->file_name);?>&&id=<?php echo $_GET['id'];?>&&asstit=<?php echo $title;?>&&code=<?php echo Crypt::encrypt($code);?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                            <h6><?php echo $title;?></h6>
                            <h6><?php echo "Deadline: ".$assignment->expire_date.""; ?></h6>
                            <b style="font-size:11px;"><?php echo "created by: ".$assignment->owner; ?></b>
                        </a>
                    </div>
                    </a>
                    <div class="card-footer d-flex align-items-center justify-content-between">

                        <h7 class="update" assid="<?php echo Crypt::encrypt($assignment->id); ?>" expdate="<?php echo $assignment->expire_date; ?>"><i class="fa fa-edit fa-2x" title="Edit" data-target="#EditAssignemtnModal" data-toggle="modal"></i></h7>
                        <h5>
                            <a href="../upload/data/<?php  echo $assignment->file_name; ?>" target="_blank" style="color:white">
                            <i class="fas fa-eye fa-1x" title="View"></i>
                            </a>
                        </h5>
                        <br><h7><a href="multigrading?assid=<?php echo Crypt::encrypt($assignment->id); ?>&&ass=<?php  echo Crypt::encrypt($assignment->file_name); ?>&&asstit=<?php  echo Crypt::encrypt($title); ?>&&code=<?php  echo Crypt::encrypt($_SESSION['code']); ?>&&id=<?php  echo $_GET['id']; ?>" style="color:white"><i class="fas fa-pen fa-2x" title="Mark"></i></h7>
                        <h5><a href="delf?mif=<?php echo Crypt::encrypt($assignment->id); ?>&kkk=<?php echo $_GET['id']; ?>" class="btn btn-sm btn-danger" style="color:white"><i class="fas fa-trash fa-1x " title="Delete"></i></a></h5>
                    </div>
                </div>
            </div>
        <?php
        $k--;
        }
    }
         ?>   
              </div>
            </div>   
            </div> 
           
      <!-- new assignment -->
            <?php require_once("ass_new.php");?>
    
            <?php require_once("ass_update.php");?>
           
            <div id="lab_updater" style="display:none; position:absolute; width:50%; height:fit-content;height:moz-fit-content;height:webkit-fit-content;background-color:white;margin-top:-465px;margin-left:10%;padding-left:8%;border:solid 1px #ccc;border-radius:7px">
            <div id="closel" style="width:40%;height:8%;margin-left:90%;padding-top:3px"><a href="#" style="width:100%;height:100%;font-size:35px">&times;</a></div>
            </div>
          
            <?php }else { logOut(); } ?>          
                    
                  
  
    