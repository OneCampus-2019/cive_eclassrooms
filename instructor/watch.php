<?php require_once '../includes/header.php'; use App\DB;?>
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
        <div class="container-fluid">
            <h1 class="small mt-1"><?php  
            if(isset($_GET['v'])){
              $vid = Crypt::decrypt($_GET['v']);
              $code = Crypt::decrypt($_GET['code']);
            
           
           
          

           
         
              echo "Class ".$code;
            ?> <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h1>
           
            <hr>
            <div class="row">
              <div class="col-md-9 col-sm-12 col-xs-12 col-lg-9" style="max-height: 540px;">
                  
                <?php 
                $conn = DB::getConnection();
                $stmt = $conn->prepare("SELECT * FROM tbl_uploads WHERE id=:id");
                $stmt->execute([':id'=>$vid]);
                $video = $stmt->fetch(PDO::FETCH_OBJ);
                 ?>
                 <div class="thumbnail">
                 <video src="../upload/data/<?php echo $video->file_name; ?>" controls autoplay="autoplay" width="100%" height="100%">
                   
                 </video>
               </div>
               <div class="caption mt-2">
                 <?php echo $video !=NULL ? $video->file_name: 'We didnt understand your request!'; ?>
               </div>
              </div>
              <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3 clearfix d-flex" style="overflow-y: scroll;">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-lg-12 mb-2" style="height: 150px;">
                         <?php 
                $stm = $conn->prepare("SELECT * FROM tbl_uploads WHERE for_course=:for_course AND as_in=:as_in AND (file_name LIKE :mp4 OR file_name LIKE :mkv OR file_name LIKE :mp3)  ORDER BY CASE id WHEN :id THEN :pos END  DESC");
                $stm->execute([':for_course'=>$code, ':as_in'=>'material', ':mp4'=>'%.mp4%', ':mkv'=>'%.mkv%', ':mp3'=>'%.mp3%', ':id'=>$vid, ':pos'=>0]);
                $video_list = $stm->fetchAll(PDO::FETCH_OBJ);
                foreach($video_list as $video){
                  ?>
                  <?php if($video->id == $vid): ?>
                  <a href="watch?v=<?php echo Crypt::encrypt($video->id); ?>&code=<?php echo Crypt::encrypt($code); ?>" style="color:#030303; opacity: 0.7; ">
                    <div class="video-enclosure col-md-12 col-sm-12 col-lg-12">
                        <div class="thumbnail" style="border-bottom:3px solid red;">
                    <video src="../upload/data/<?php echo $video->file_name; ?>" width="200" height="100%"></video>
                    </div>
                    <div class="caption col-sm-12 col-md-12 justify-content-center small" style="word-wrap: break-word; width:200px;">
                      <?php echo $video->file_name; ?>
                    </div> 
                    </div>
                 
                  </a>
                  <?php else:  ?>
                    <a href="watch?v=<?php echo Crypt::encrypt($video->id); ?>&code=<?php echo Crypt::encrypt($code); ?>"  style="color:#030303; opacity: 0.7; ">
                      <div class="vide-encloseure col-md-12 col-sm-12 col-xs-12">
                         <div class="thumbnail">
                    <video src="../upload/data/<?php echo $video->file_name; ?>" width="200" height="100%"></video>
                    </div>
                    <div class="caption col-md-12 col-sm-12 justify-content-center small align-items-between" style="word-wrap: break-word; width:200px;">
                      <?php echo $video->file_name; ?>
                    </div>
                      </div>
                   
                  </a>
                <?php endif ?>
                 
                  <?php
                }

                 ?>
                  </div>
                </div>
              </div>
            </div>

          <?php } ?>

         </div>
         <div class="clearfix"></div>

<?php require_once '../includes/footer.php'; ?>