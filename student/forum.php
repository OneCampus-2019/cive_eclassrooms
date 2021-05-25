<?php  
    //if (!$con) {
        require_once '../includes/db/db.php';
        use App\DB;
        if(hasAuthority('0')){
    //}
?>
<style type="text/css">
*{
    margin: 0;
    padding: 0px;
    /*font-family: verdana;*/
}

.chatbox{
    width: auto;    
    background: #fff;
    /*box-shadow: 0 3px #ccc;*/
}

.chatlogs{
    padding: 10px;
    width: 100%;
    height: 450px;
    overflow-x: scroll;
    overflow-y: auto;
    /*background: #eee;*/
}

.chatlogs::-webkit-scrollbar{
    width: 10px;
}

.chatlogs::-webkit-scrollbar-thumb{
    border-radius: 5px;
    background: rgba(0,0,0,0.1);
}

.chat{
    display: flex;
    flex-flow: row wrap;
    align-items: flex-start;
    margin-bottom: 10px;
    width: 130%;
}
.chat .user-photo {
    width: 60px;
    height: 60px;
    background: #ccc;
    border-radius: 50%;
    /*background-image: url('img/kaz2.png');
    background-repeat: no-repeat;*/

}

.nani {
    padding:0;
    font-weight: bold;
}

.chat .chat-message {
    width: 70%; /*henda ikawa mia*/
    padding: 7px;
    margin: 5px 10px 0;
    border-radius: 10px;
    color: #fff;
    font-size: 12px;
}

.chat .chat-message p{
    width: auto; /*henda ikawa mia*/
    
    font-size: 20px;
}

.friend .chat-message{
    background: #ddd;
    color: #111;
    box-shadow: 0 3px #ccc;
}

.self .chat-message{
    background: #2980b9;
    color: #fff;
    box-shadow: 0 3px #ccc;
    order : -1;
}

.chat-form{
    margin-top: 20px;
    display: flex;
    align-items: flex-start;
}

.chat-form textarea{
    background: #fbfbfb;
    width: 75%;
    height: 50px;
    border: 2px solid #eee;
    border-radius: 3px;
    resize: none;
    padding: 10px;
    font-size: 18px;
    color: #333;
}

.chat-form textarea:focus{
    background: #fff;
}

.chat-form button{
    background: #1ddced;
    padding: 5px 15px;
    font-size: 30px;
    color: #fff;
    border: none;
    
    border-radius: 3px;
    box-shadow: 0 3px 0 #0eb2c1;
    cursor: pointer;

    -webkit-transitin: background .2s ease;
    -moz-transitin: background .2s ease;
    -o-transitin: background .2s ease;
}

.chat-form button:hover{
    background: #13c8d9;
}

.card .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.card-body
{
    overflow-y: scroll;
    overflow-x: hidden;
    height: 250px;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

</style>
<br>
<?php if(isset($_GET['id'])){ ?>
<div class="card-group">

	<?php 
    $conn = DB::getConnection();
		$gg = Crypt::decrypt($_GET['id']);
		$stmt = $conn->prepare("SELECT * FROM `tbl_course` WHERE id=:id ");
        $stmt->execute([':id'=>$gg]);
		$r =$stmt->fetch(PDO::FETCH_ASSOC);
        if($r == null){
            exit();
        }
		$v = $r['course_code'];
		$res = $conn->prepare("SELECT * FROM `tbl_coments` WHERE topic=:topic ");
        $res->execute([':topic'=>$v]);
        $comments = $res->fetchAll(PDO::FETCH_ASSOC);
		
	 ?>
    
    <div class="card">
      <div class="card-header">Forum Chat For - <?php echo $v; ?></div>
      <div class="card-body">
      	<div class="chatbox">
            <div class="chatlog">
            <?php foreach($comments as $data){ ?>

            <?php if($data['comentedby'] != $n){ ?>

                <div class="chat friend">
                    <div class="user-photo">  <img src="../assets/img/kaz2.png" alt="User Avatar" class="img-circle" width="60" height="60" /></div>
                    <p class="chat-message">
                        <span class="nani"><?php echo $data['comentedby']; ?></span> <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span><?php echo $data['posted_on']; ?>
                        </small><br>
                        <?php echo $data['coment']; ?>
                        
                    </p>
                </div>
            <?php }else{ ?>
                <div class="chat self">
                    <div class="user-photo"><img src="../assets/img/kaz2.png" alt="User Avatar" class="img-circle" width="60" height="60" /></div>
                    <p class="chat-message">
                        <span class="nani"><?php echo $data['comentedby']; ?></span> <small class="pull-right text-muted" style="color:#fff;">
                            <span class="glyphicon glyphicon-time"></span><?php echo $data['posted_on']; ?>
                        </small><br>
                        <?php echo $data['coment']; ?><br>

                      <small class="pull-right" >
                            <span class="glyphicon glyphicon-delete"></span>
                            <a href="#" class="del" style="color:#fff;" del="<?php echo $data['id']; ?>">Delete</a>
                        </small>  
                    </p>

                </div>

                <?php } ?>
        <?php } ?>
            </div>

           
        </div>
      </div>
      

      <div class="card-footer">
      	<form action="" method="POST">
	        <div class="input-group">
	            <input id="btn-input" type="text" name="tpost" class="form-control input-sm" placeholder="Type your message here..." />
	            <span class="input-group-btn">
	                <button type="submit" name="spost" class="btn btn-primary btn-sm" id="btn-chat">
	                    Send
	                </button>
	            </span>
	        </div>
        </form>
      </div>
    </div>
    <br>

</div>
<?php } ?>
<?php 
	if (isset($_POST['spost'])) {
		$tpost = $_POST['tpost'];
		$mi = $n;
		$txt = "text";
		$ft = "text";
        $cate = "chat";

		$stm = $conn->prepare("INSERT INTO`tbl_coments`(topic,category,comentedby,coment,ftype,postedby,expire) VALUES(:topic, :category,:comentedby, :coment, :ftype, :postedby, :expire)");
        $stm->execute([':topic'=>$v, ':category'=>$cate, ':comentedby'=>$mi, ':coment'=>$tpost, ':ftype'=>$ft, ':postedby'=>$mi, ':expire'=>'']);
        //header('location: std_my_course.php?id='.$gg);
        ?>
        <script>window.location.href= 'std_my_course?id=<?php echo Crypt::encrypt($gg); ?>';</script>
        <?php

	}

    /*if (isset($_GET['iido'])) {
        $iido =Crypt::decrypt($_GET['iido']);
        $ggg = Crypt::decrypt($_GET['gg']);
        $delst = $conn->prepare("DELETE FROM `tbl_coments` WHERE id=:id ");
        $delst->execute([':id'=>$iido]);
        header('location: std_my_course.php?id='.$_GET['gg']);
        
    }*/

 ?>
 <script type="text/javascript">
    
     $(document).ready(function(){
        $(document).on('click', '.del', function(e){
            e.preventDefault();
            var cid = $(this).attr('del');
            var action = "std_del_comment";
            Swal.fire({
                title:'Are you sure',
                icon:'warning',
                text:'You cant redo this action',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                 confirmButtonText: 'Yes, delete it!'

            }).then((result) => {
              if (result.value) {
                $.ajax({
                  method:"post",
                  url:'../includes/actions.php',
                  data:{cid:cid, action:action},
                  success:function(data){
                    if(data.status == 'success')
                
                     Swal.fire('Success', data.message, 'success')
                 window.location.reload();
                 }

                  
                 
                });
               
            
             }
        });
        });

     });
     
 </script>
<?php } else { logOut(); } ?>
   