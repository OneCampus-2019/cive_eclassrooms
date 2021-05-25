<?php session_start(); ?>
<?php require_once '../includes/db/db.php'; ?>
<?php require_once '../includes/auth.php'; ?>
<?php require_once '../classes/sec.php'; 

?>
<?php $_SESSION['this_ass']=$_GET['assid'];
if(hasAuthority('7') || hasAuthority('8')){
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" charset="utf8" src="../assets/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/css/datatables/css/dataTables.bootstrap.css">
<script src="../assets/js/fa.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="../assets/css/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/css/datatables/js/dataTables.bootstrap.min.js"></script>
        <script src="../assets/css/datatables/js/dataTables.responsive.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../assets/css/datatables/css/jquery.dataTables.css">
   <link rel="stylesheet" type="text/css" href="../assets/css/datatables/css/jquery.dataTables_themeroller.css">
   <script type="text/javascript" charset="utf8" src="../assets/css/datatables/js/jquery.dataTables.min.js"></script> 
   <script>
   $(document).ready(function(){

   var file_id="";
   var filename="";
   var record="";
   var pos="";
   var maxima=0; //used by the questions score handler
   var qscores=[];
   var obj=$('#fileobj');
  //the current assignment
   var course_code="<?php echo Crypt::decrypt($_GET['code']);?>";
   var ass_name="<?php echo Crypt::decrypt($_GET['asstit']);?>";

  var rw="";
  var crow="";
  var colum="";
  var regno="";
   
  //setting up the last assignment

    var last_course=localStorage.getItem('course_code');
    var last_ass=localStorage.getItem('ass_name');

     //as the assignment match, we may pick the last entry
    if(course_code==last_course && ass_name==last_ass)
    {
      file_id=localStorage.getItem('file_id');
      filename=localStorage.getItem('filename');
      record=$('#'+file_id).parent();
      
      localStorage.setItem('file_id',file_id);
      localStorage.setItem('filename',filename);
      localStorage.setItem('course_code',course_code);
      localStorage.setItem('ass_name',ass_name);
      
   
        record.css('backgroundColor',"lightblue");
        rw=$('tr').index(record);
        crow=$("tr:eq("+rw+")");
        regno=crow.children('td').eq(1).text();
        obj.attr("src","../upload/data/"+$.trim(filename));
        $('h4').text(regno);
        $('#heading').text(regno);
        $("#heading").css("width", "0%");
        $("#heading").animate({width: "100%"});
        $("#asshead").css("width", "0%");
        $("#asshead").animate({width: "50%"});   
  }
  else{
  //gone through the local storage, no last one found, we set up the first record as en entry record
  rw=1;
  crow=$("tr:eq("+rw+")");
  colum=crow.find($('td')[2]);
  file_id=colum.attr('id');
  //filename=colum.text();
  filename = crow.children('td').eq(2).text();
  regno=crow.children('td').eq(1).text();
  //alert(file_id);
  // now displaying the current entry
  if(filename!="" && file_id!=""){


  obj.attr("src","../upload/data/"+$.trim(filename));

  $('h4').text(regno);
  $('#heading').text(regno);
  $("#heading").animate({width: "100%"});
  $("#asshead").animate({width: "50%"});
   
  crow.css('backgroundColor',"lightblue");


  
  }
 
 //handling enter key clicks: the current entry is recorded and we set up the next one
  }
 $('body').keyup(function(e){
 var kcode = e.keyCode || e.which;
 if(kcode == 13) { 
//taking all the questions score
   var num_item=$('#qmarking input').length;
   //var max=$('#maxima input').length;
   for(var t=0;t<num_item;t++)
   {
	   //alert(parseFloat($('#qmarks').eq(t).val()));
    // if(isNaN(parseFloat($('#qmarking input').eq(t).val()))==false)
     //{
	  //if(parseFloat($('#qmarks').eq(t).val())>parseFloat($('#maxima input').eq(t).val())){
      //alert("marks greater than maxima");
    //} 
     //}
    
       if($('#qmarking input').eq(t).attr('id')=="qmarks")
       {
       var qm=0;
		   if(isNaN(parseFloat($('#qmarking input').eq(t).val()))){qm=0;}
		   else{ qm=parseFloat($('#qmarking input').eq(t).val());}
       qscores.push(qm);
      }
       
   }

//end taking all the questions score
 if(parseFloat($('#marks').val())!=maxima){alert("the total score must be equal to the total of questions scores");}
 else{
 var marks="";
 //we call the marking script for the current entry
 if(file_id!=""){ //test again and again
 if($('#marks').val()==""){alert("please enter marks then click enter");}
 else{
 var tot_marks=parseFloat($('#tot').val());
 if(parseFloat($('#marks').val())>tot_marks){alert("marks provided exceed the maxima"); $('#marks').val("");}
 else{
 marks=parseFloat($('#marks').val());
 $.get("multigrad_form.php",{ grad:marks, fid:file_id, q_scores:qscores},returnAnswer)

//done sending the current user, we point to the next one
.success(function(){
record.css('backgroundColor',"");
if($("tr:eq("+rw+")").is($('tr').last())){alert('end of the list');}
else{rw++; crow=$("tr:eq("+rw+")");}
colum=crow.children('td').eq(2);
file_id=colum.attr('id');
filename=colum.text();
crow.css('backgroundColor',"lightblue");
obj.attr("data","../upload/data/"+filename);

regno=crow.children('td').eq(1).text();
$('h4').text(regno);
$('#heading').text(regno);
$("#heading").css("width", "0%");
$("#heading").animate({width: "100%"});
$("#asshead").css("width", "0%");
$("#asshead").animate({width: "50%"});


//Putting the last entry into the local storage
localStorage.setItem('file_id',file_id);
localStorage.setItem('filename',filename);
localStorage.setItem('course_code',course_code);
localStorage.setItem('ass_name',ass_name);
$('#marks').val("");

//emptying the questions score
maxima=0; 
var num_item=$('#qmarking input').length;
   for(var t=0;t<num_item;t++)
   {
	   
       if($('#qmarking input').eq(t).attr('id')==="qmarks")
       {
        $('#qmarking input').eq(t).val("");
       
      }
       
	   
   }
//emptying the scores buffer
qscores=[];
});
function returnAnswer(answer)
 {
   //alert(answer+" "+marks+" "+filename+" "+file_id)
   
 }
 crow.css("background-color","");
}

}
}


 }
 }

 });

//handling next button;
$('#next').click(function(){
crow.css('backgroundColor',"");
if($("tr:eq("+rw+")").is($('tr').last())){alert('end of the list');}
else{rw++; crow=$("tr:eq("+rw+")");}
colum=crow.children('td').eq(2);
file_id=colum.attr('id');
filename=colum.text();
crow.css('backgroundColor',"lightblue");
if($.trim(filename)!="")
{
obj.attr("src","../upload/data/"+$.trim(filename));
}

regno=crow.children('td').eq(1).text();
$('h4').text(regno);
$('#heading').text(regno);
$("#heading").css("width", "0%");
$("#heading").animate({width: "100%"});
$("#asshead").css("width", "0%");
$("#asshead").animate({width: "50%"});


//Putting the last entry into the local storage
localStorage.setItem('file_id',file_id);
localStorage.setItem('filename',filename);
localStorage.setItem('course_code',course_code);
localStorage.setItem('ass_name',ass_name);

crow=$("tr:eq("+rw+")"); //set the current row
$('#marks').val("");
});


//handling prev 
$('#prev').click(function(){
crowpr=$("tr:eq("+rw+")");
if($("tr:eq("+rw+")").is($('tr:eq(1)'))){alert('no previous record');}
else{rw--; crow=$("tr:eq("+rw+")");}
crowpr.css("background-color","");
colum=crow.children('td').eq(2);
file_id=colum.attr('id');
filename=colum.text();
crow.css('backgroundColor',"lightblue");
if($.trim(filename)!="")
{
obj.attr("src","../upload/data/"+$.trim(filename));
}

regno=crow.children('td').eq(1).text();
$('h4').text(regno);
$('#heading').text(regno);
$("#heading").css("width", "0%");
$("#heading").animate({width: "100%"});
$("#asshead").css("width", "0%");
$("#asshead").animate({width: "50%"});


//Putting the last entry into the local storage
localStorage.setItem('file_id',file_id);
localStorage.setItem('filename',filename);
localStorage.setItem('course_code',course_code);
localStorage.setItem('ass_name',ass_name);

crow=$("tr:eq("+rw+")"); //set the current row
//crow.css("background-color","");
});
//row clicking handler
$('tr').click(function(){
crow.css("background-color",""); //the current record is cleared
rw=$('tr').index($(this));
file_id=$(this).children('td').eq(2).attr('id');
filename=$(this).children('td').eq(2).text();
regno=$(this).children('td').eq(1).text();
crow=$("tr:eq("+rw+")");
//updating UI
obj.attr("src","../upload/data/"+$.trim(filename));
$('h4').text(regno);
$('#heading').text(regno);
$("#heading").css("width", "0%");
$("#heading").animate({width: "100%"});
$("#asshead").css("width", "0%");
$("#asshead").animate({width: "50%"});

//showing the clicked record
crow.css('backgroundColor',"lightblue");

$('#marks').val("");




})




 




//handling questions marking


   
   $('#qmarking').on('keyup','input',function(){
   var num_item=$('#qmarking input').length;
   //var max=$('#maxima input').length;
   var total_marks=0;
   for(var t=0;t<num_item;t++)
   {
	   //alert(parseFloat($('#qmarks').eq(t).val()));
    // if(isNaN(parseFloat($('#qmarking input').eq(t).val()))==false)
     //{
	  //if(parseFloat($('#qmarks').eq(t).val())>parseFloat($('#maxima input').eq(t).val())){
      //alert("marks greater than maxima");
    //} 
     //}
    var qm=0;
       if($('#qmarking input').eq(t).attr('id')==="qmarks")
       {
      
		   if(isNaN(parseFloat($('#qmarking input').eq(t).val()))){qm=0;}
		   else{ qm=parseFloat($('#qmarking input').eq(t).val());}
		   total_marks=total_marks+qm;
      }
       
	   
   }
   if(isNaN(total_marks)){total_marks=parseFloat(total_marks);}
   $('#marks').val(total_marks);
   maxima=total_marks;

  
   
  $('#marks').blur(function(){

   
   if(parseFloat($('#marks').val())!=maxima && isNaN(parseFloat($('#marks').val()))==false)
   {
     alert(isNaN(parseFloat($('#marks').val())));
	   alert("the total score must be equal to the total of questions scores");
	   if(maxima>0){$('#marks').val(maxima);}else{$('#marks').val("");}
   }
    




  });

})
});
  


   </script>
<style>
#dataTables-ex2
{
  font-size: 10px;
  width:100%;
 
}
* {
  box-sizing: border-box;
}

.main {
  float:left;
  width:58%;
  padding:0 10px;
  margin-top:7px;
  height:85vh;
  min-height:85vh;
  display: inline-block;
  background-color:#ccd;
  border-radius:7px;
}
.right {
  background-color:#blue;
  float:left;
  width:12%;
  padding:5px;
  padding-left:0px;
  margin-top:15%;
  text-align:left;
  border-radius: 5px;
  height:fit-content;
  height:moz-fit-content;
  height:webkit-fit-content;
}
.left {
  background-color:#e5e5e5;
  float:left;
  width:30%;
  padding-left:0px;
  margin-top:5px;
  text-align:left;
  border-radius: 5px;
}
.pdfobject-container { 
    /*height: 50rem; */
    border: 1rem solid rgba(0,0,0,0.05); 
  }

@media only screen and (max-width:620px) {
  /* For mobile phones: */
  .menu, .main, .right {
    width:100%;
  }
}
#controls
{
  width:56%;
  height:10%;
  border:solid 1px #ccc;
  position:absolute;
  margin-left:31%;
  margin-top:-2.5%;
  background-color:white;
  border-radius:6px;
}
#qmarking
{
  width:8%;
  height:56%;
  border:solid 1px #ccc;
  position:absolute;
  margin-left:0%;
  background-color:white;
  border-radius:6px;
  overflow:auto;
}
#prev 
{
  height:100%;
  width:10%;
  float:left;
}
#prev img 
{
  width:100%;
  height:90%;
}
#next
{
  height:100%;
  width:10%;
  float:left;
}
#next img 
{
  width:100%;
  height:90%;
  transform:scaleX(-1);
}
#empty 
{
  min-width:80%;
  max-width:80%;
  float:left;
  border:solid 1px blue;
  height:100%;
  background-color:#000000;
  border-radius:5px;
  
}
#mrow
{
  min-width:80%;
  border:solid 1px blue;
  height:100%;
  background-color:#000000;
  border-radius:5px;
  padding:10px;
  overflow:auto;
  
}
form{
  height:60%;
  width:100%;
  padding-left:40%;
}
form input{
  width:15%;
  height:90%;
  border-radius:7px;
  color:black;
  font-weight:bold;
  font-size:20px;
}
#heading 
{
 height:40%;
 width:0%;
 text-align:center;
 color:white;
 font-size:10px;
 font-weight:bold;
}
#asshead
{
  width:0%;
  margin-left:30%;
  
}
#asstitle
{
  width:30%;


}


</style>
</head>
<body style="font-family:Verdana;color:#aaaaaa;">
<div style="background-color:#e5e5e5;padding:1px;text-align:center;">
  <div id="asstitle"><b>Marking:</b><?php print " Class: ".Crypt::decrypt($_GET['code'])."==>".Crypt::decrypt($_GET['asstit']);?></div>
  <div id="asshead"><h4></h4></div>
  
</div>
<div id="fullpage" style="height:90%">
<div style="overflow:auto">  
<div class="left" style="overflow:auto">
<?php $cod = Crypt::decrypt($_GET['id']);
$ass= Crypt::decrypt($_GET['ass']);?>
<?php include_once("stdwork2.php"); ?>
</div>
  <div class="main">
    <iframe src="" style="width:100%; color:#44f; font_size:10%;" height="550" id="fileobj"  type="application/pdf"><p style="margin-top:40%"><b><center>
    <?php if($nr < 1)
    {print "No any submissions!";
 }else{ print "No preview!! download it";}?></center></b></p>
    </iframe>
    <!-- <div id="viewpdf"></div> -->

  </div>

<div class="right">
<!--question marking-->
<div id="qmarking">
<div id="mrow">
<?php require_once("getquestions.php");?>
</div>
</div>
<!--end of question marking-->
</div>

</div>

<div id="controls">
<div id="prev"><img src="../assets/icons/prev.png" /></div>
<div id="empty">
<div id="heading"></div>
<form  action="" method="POST">

   <input id="marks" type="text" name="grad" value="" style="color:blue">

   <b>/</b>

   <input id="tot" type="text"  name="tat" value="<?php print $tot;?>"  readonly>
</form> 
</div>
<div id="next"><img src="../assets/icons/prev.png" /></div>

</div>
</div>
<?php } else { logOut(); }  ?>
