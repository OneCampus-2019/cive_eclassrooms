<style>
h5:hover
{
  background-color:rgba(0,0,0,0.7);
    cursor:pointer;
    border:none;
     background: repeat;
} 
h7:hover
{
   background-color:rgba(0,0,0,0.7);
    cursor:pointer;
      border:none;
      background: repeat;
 
} 

</style>
<script>
$('document').ready(function(){

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




})


</script>
            
   <div class="row mb-2">
   <div class="col-md-12 col-sm-12 col-lg-12">
   <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#NewTutorial"><span class="fa fa-plus"></span> Create Tutorial</button>
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
        $stmt = $conn->prepare("SELECT * FROM `tbl_uploads` where for_course=:for_course && owner=:owner && as_in=:as_in ORDER BY id DESC");
        $stmt->execute([':for_course'=>$code, ':owner'=>$mimi, ':as_in'=>'tutorial']);
        //$nr = mysqli_num_rows($qq);
        $k =$stmt->rowCount();
        if($k<=0){
            $jumbe = "<h4 align='center'>No Tutorial Found</h4>";
            echo '<div class="alert alert-info alert-dismissible col-md-12">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>';
                            echo $jumbe;
                            echo '
                            </strong>
                        </div>';
        }
        else{
        $asstit="Lab".$k;
        while ($d = $stmt->fetch(PDO::FETCH_ASSOC)){
            $mi =$d['owner'];
            $asstit="Lab ".$k;
            //$exploded_array = explode('~', $str);
               if($mimi ==$mi ){
                
     ?> 

            <!-- to be looped -->
            <!-- the color should be randoized from php function -->
      
     
      <a   href="../upload/data/<?php echo $d['file_name']; ?>">
            <div class="col-xl-3 col-md-4"  >
                <div class="card bg-info text-white mb-4" style="height:180px" >
                <a href="stdwork.php?ass=<?php echo Crypt::encrypt($d['file_name']);?>&&id=<?php echo $_GET['id'];?>&&asstit=<?php echo $asstit;?>&&code=<?php echo $code;?>" style="text-decoration: none;color:#fff;font-weight: bold;">
                  
                    <div class="card-body">
                        <a href="../upload/data/<?php echo $d['file_name']; ?>" target="_blank" style="text-decoration: none;color:#fff;font-weight: bold;">
                            <h6><?php echo $d['title'];?></h6>
                        </a>
                    </div>
                    </a>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <h7 id="<?php echo $d['id']; ?>" class="upd"><i class="fa fa-edit fa-2x" title="Edit"></i></h7>
                        <h5>
                            <a href="../upload/data/<?php  echo $d['file_name']; ?>" target="_blank" class="text-light">
                            <i class="fas fa-eye fa-1x" data-toggle="tooltip" data-title="View"></i>
                            </a>
                        </h5>
                        <h5>
                            <a href="#" fid="<?php echo Crypt::encrypt($d['id']); ?>" class="btn btn-danger btn-sm tuto-del" data-toggle="tooltip" data-title="Delete">
                            <i class="fas fa-trash fa-1x" ></i>
                            </a>
                        </h5>

                    </div>
                </div>
            </div>
                
         <?php 
         $k--;
        }
        ?>
        </a> 
        <?php
        }
    }
         ?>   
              </div>
            </div>   
            </div> 
           
      <!-- new assignment -->
            <!-- Tutorial new -->
          <?php require_once("tuto_new.php");?>
            <div id="ass_updater" style="display:none; position:absolute; width:50%; height:fit-content;height:moz-fit-content;height:webkit-fit-content;background-color:white;margin-top:-865px;margin-left:10%;padding-left:8%;border:solid 1px #ccc;border-radius:7px">
            <div id="closep" style="width:40%;height:8%;margin-left:90%;padding-top:3px"><a href="#" style="width:100%;height:100%;font-size:35px">&times;</a></div>
            <?php require_once("ass_update.php");?>
            </div>
            <div id="lab_updater" style="display:none; position:absolute; width:50%; height:fit-content;height:moz-fit-content;height:webkit-fit-content;background-color:white;margin-top:-465px;margin-left:10%;padding-left:8%;border:solid 1px #ccc;border-radius:7px">
            <div id="closel" style="width:40%;height:8%;margin-left:90%;padding-top:3px"><a href="#" style="width:100%;height:100%;font-size:35px">&times;</a></div>
            <?php require_once("lab_update.php");?>
            </div>
<script type="text/javascript">
    $(document).on('click', '.tuto-del', function(e){
        e.preventDefault();
        var fid = $(this).attr('fid');
        var action = 'delete_tutorial';
       // alert(fid);
         Swal.fire({
                title:'Do you want to delete this tutorial? ',
                icon:'warning',
                text:'You cant redo this action',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                 confirmButtonText: 'Yes, delete this!'

            }).then((result) => {
              if (result.value) {
                $.ajax({
                  method:"post",
                  url:'delf.php',
                  data:{fid:fid, action:action},
                  dataType:'JSON',
                  success:function(data){
                    if(data.status == 'success'){
                     Swal.fire('Success', data.message, 'success');
                 setTimeout(function(){
                      window.location.reload();

                  }, 2000);
               
                 }
             }

                  
                 
                });
               
            
             }
        });

    })
</script>
                            
                      
                    
                  
  
    