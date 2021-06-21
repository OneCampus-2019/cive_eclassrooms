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
$('#closes').click(function(){

    $(this).parent().css('display','none');
})
$('#closep').click(function(){

$(this).parent().css('display','none');
})
$('#closel').click(function(){

$(this).parent().css('display','none');
})
$('.upd').click(function(){
var fid=$(this).attr('id');
$('#fid').val(fid);
$("#ass_updater").animate({left: '250px'});
$('#ass_updater').css('display','block');

});
$('.lpd').click(function(){
var fid=$(this).attr('id');
$('#fidl').val(fid);
$("#lab_updater").animate({left: '250px'});
$('#lab_updater').css('display','block');

});
$('.update').click(function(){

var assid1=$(this).attr('labid');
var expdate=$(this).attr('expdate');
$('#labidd').val(assid1);
//$("#expire_date").val(expdate);


});




})


</script>
            
   <div class="row mb-2">
   <div class="col-md-12 col-sm-12 col-lg-12">
   <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#NewLab"><span class="fa fa-plus"></span>New Lab</button>
   </div>    

   </div>

         <div class="row">
         <div class="col-md-12">
         <div class="row">
  
    <?php
    use App\DB;
    $conn = DB::getConnection(); 
        //this query must added the where clause for only my course
        $mimi = $n;
        $code=NULL;
        if(isset($_GET['code'])){ 
            $_SESSION['code']=Crypt::decrypt($_GET['code']);
            $code=Crypt::decrypt($_GET['code']);}
        else{$code=$_SESSION['code'];}
        $stmt = $conn->prepare("SELECT * FROM `tbl_uploads` where for_course=:for_course  && as_in=:as_in ORDER BY id DESC");
        $stmt->execute([':for_course'=>$code,':as_in'=>'lab']);
        //$nr = mysqli_num_rows($qq);
        $k =$stmt->rowCount();
        if($k<=0){
            $jumbe = "<h4 align='center'>No Lab Found</h4>";
            echo '<div class="alert alert-info alert-dismissible col-md-12">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>';
                            echo $jumbe;
                            echo '
                            </strong>
                        </div>';
        }
        else{
            $asstit="";
        while ($d = $stmt->fetch(PDO::FETCH_ASSOC)){

            if($d['title']==null){$asstit="";}else{$asstit=$d['title'];}
                
     ?> 

            <!-- to be looped -->
            <!-- the color should be randoized from php function -->
      
     
     
            <div class="col-xl-3 col-md-4"  >
                <div class="card bg-info text-white mb-4" style="height:180px" >
                      
                <a href="stdwork.php?ass=<?php echo Crypt::encrypt($d['file_name']);?>&&id=<?php echo $_GET['id'];?>&&asstit=<?php echo $asstit;?>&&code=<?php echo $code;?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                    <div class="card-body">
                        <a href="stdwork.php?ass=<?php echo Crypt::encrypt($d['file_name']);?>&&id=<?php echo $_GET['id'];?>&&asstit=<?php echo $asstit;?>&&code=<?php echo $code;?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                            <h6><?php echo $d['title'];?></h6>
                            <h6><?php echo "Deadline: ".$d['expire_date'].""; ?></h6>
                            <b style="font-size:11px;"><?php echo "created by: ".$d['owner']; ?></b>
                        </a>
                    </div>
                    </a>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                         <h7 class="update" labid="<?php echo Crypt::encrypt($d['id']); ?>" expdate="<?php echo $d['expire_date']; ?>"><i class="fa fa-edit fa-2x" data-target="#EditLabModal" data-toggle="modal"></i></h7>
                        <h5>
                            <a href="../upload/data/<?php  echo $d['file_name']; ?>" target="_blank" style="color:white">
                            <i class="fas fa-eye fa-1x" title="View"></i>
                            </a>
                        </h5>
                        <br><h7><a href="multigrading.php?assid=<?php echo $d['id']; ?>&&ass=<?php  echo $d['file_name']; ?>&&asstit=<?php  echo Crypt::encrypt($asstit); ?>&&code=<?php  echo $_SESSION['code']; ?>&&id=<?php  echo $_GET['id']; ?>" style="color:white"><i class="fas fa-pen fa-2x" title="Mark"></i></h7>
                        <h5><a href="delf.php?mif=<?php echo Crypt::encrypt($d['id']); ?>&kkk=<?php echo $_GET['id']; ?>" class="btn btn-sm btn-danger" style="color:white"><i class="fas fa-trash fa-1x " title="Delete" onclick="confirm('Delete this Lab?');"></i></a></h5>
                    </div>
                </div>
            </div>
                

      
        <?php
        }
    }
         ?>   
              </div>
            </div>   
            </div> 
           
      <!-- new assignment -->
            <?php require_once("lab_new.php");?>
            <?php require_once("lab_update.php");?>
            <div id="lab_updater" style="display:none; position:absolute; width:50%; height:fit-content;height:moz-fit-content;height:webkit-fit-content;background-color:white;margin-top:-465px;margin-left:10%;padding-left:8%;border:solid 1px #ccc;border-radius:7px">
            <div id="closel" style="width:40%;height:8%;margin-left:90%;padding-top:3px"><a href="#" style="width:100%;height:100%;font-size:35px">&times;</a></div>
            
            </div>
           
                            
                      
                    
                  
  
    