<?php
require_once '../includes/db/db.php'; 
require_once '../includes/auth.php';
use App\DB;
?>
<style>
td,th{ 
  border:solid 1px black;
  width:fit-content;
  width:moz-fit-content;
  width:webkit-fit-content;
}
table {
  width:400px;
}
  
</style>
<script>

$(document).ready(function(){
 var chosen_labs=[];
 var chosen_ass=[];
 var ass_aggmax=0;
 var lab_aggmax=0;
 var ass_maxima=0;
 var lab_maxima=0;
 var p_max=0;
 var p_max1=0;

  $('.ass-checkbox').change(function() {

    if (this.checked) {
         $ch_ass=$(this).val();
         chosen_ass.push($ch_ass);
         ass_maxima=ass_maxima+parseInt($(this).attr('id'));
        // get_ag_assessment(chosen_ass,ass_aggmax,"assignment");
    } else {
      //removing it
      get_ag_assessment(chosen_ass,ass_aggmax,p_max,"assignment");
      $unch_ass=$(this).val();
      chosen_ass = $.grep(chosen_ass, function(value) {
      return value != $unch_ass;
      });
      ass_maxima=ass_maxima-parseInt($(this).attr('id'));
    } 
    if($('#ass_aggmax').val()!="")
    {
      ass_aggmax=parseInt($('#ass_aggmax').val());
    }
    else{
      if(ass_maxima>0){ass_aggmax=ass_maxima;}
    }
    var max=$('#ass_aggmax').val();
    if(max!=""){p_max=parseInt(max);}else{p_max=ass_aggmax;}  
    get_ag_assessment(chosen_ass,ass_aggmax,p_max,"assignment");
    //add_totals();
    
    
});

$('.lab-checkbox').change(function() {
  
    if (this.checked) {
         $ch_lab1=$(this).val();
         chosen_labs.push($ch_lab1);
         lab_maxima=lab_maxima+parseInt($(this).attr('id'));
    } else {
      //removing it
      get_ag_assessment(chosen_labs,lab_aggmax,p_max1,"lab");
      $unch_lab1=$(this).val();
      chosen_labs = $.grep(chosen_labs, function(value) {
      return value != $unch_lab1;
      });
      lab_maxima=lab_maxima-parseInt($(this).attr('id'));
    }
    if($('#lab_aggmax').val()!="")
    {
      lab_aggmax=parseInt($('#lab_aggmax').val());
    }
    else{
      if(lab_maxima>0){lab_aggmax=lab_maxima;}
    } 
    var max1=$('#lab_aggmax').val();
    if(max1!=""){p_max1=parseInt(max1);}else{p_max1=lab_aggmax;}  
    get_ag_assessment(chosen_labs,lab_aggmax,p_max1,"lab");
    //add_totals();
    
});
$('#ass_aggmax').keyup(function(){
var thismax=0;
if($(this).val()!=""){
  thismax=parseInt($(this).val());
  get_ag_assessment(chosen_ass,ass_aggmax,thismax,"assignment");
  }
  else{

    get_ag_assessment(chosen_ass,ass_aggmax,thismax,"assignment")
  }
 

})
$('#lab_aggmax').keyup(function(){
var lmax=0;
if($(this).val()!=""){
  lmax=parseInt($(this).val());
  get_ag_assessment(chosen_labs,lab_aggmax,lmax,"lab");
  }
  else
  {
    get_ag_assessment(chosen_labs,lab_aggmax,lmax,"lab");
  }

  

})
function get_ag_assessment(ass,agg_max,reduct,type){ 

  var assess=ass;
  var agg_maxx=0;
  if(reduct==0 || reduct=="")
  {
    agg_maxx=agg_max;
  }
  else{agg_maxx=reduct;}

  var tp=type;
  
  $.getJSON("getassmarks.php",{ass:assess,reduce:reduct,agg:agg_max},function(data,status){

  var stud_marks={};
  var stud_lab_marks={};
 
  if(type=="assignment"){stud_marks=data;}
  else if(type=="lab"){stud_lab_marks=data;}
  else{}
  console.log(stud_marks);
 //console.log( stud_marks);
  var table_data={
     ass_col:ass_cols=[],
     labs_col:lab_cols=[]
  }

  //handling assignment columns

  if(type=="assignment")
  {
    //generate all assignment tds and store them in the object
for(var mar in stud_marks)
{
  var ass_row="";
   if($('#tablehead').children().length==0)
   {
    ass_row="<td>"+mar+"</td><td>"+stud_marks[mar]+"</td>";
   }
   else
   {
    ass_row="<td>"+stud_marks[mar]+"</td>";
   }
     
    for(var assess in table_data)
    {
      if(assess=="ass_col")
      {
       table_data[assess].push(ass_row);
       
      }

    }


  }
  
  }
  //handling labs colums
  else if(type=="lab")
  {
   
    for(var l in stud_lab_marks)
    {
   var labs_row="";
   if($('#tablehead').children().length==0)
   {
    labs_row="<td>"+l+"</td><td>"+stud_lab_marks[l]+"</td>";
   }
   else
   {
    labs_row="<td>"+stud_lab_marks[l]+"</td>";
   }
    for(var lbs in table_data)
    {
      if(lbs=="labs_col")
      {
       table_data[lbs].push(labs_row);
      }

    }


  }

  }
  
  //now handling the display
  for(var disp in table_data)
  {
    
     //for assignment
    if(disp=="ass_col" && table_data[disp].length!==0)
    {
       var newth="";
       var new_content="";
       var tb_head=$('#tablehead');
       var tb_body=$('#table_body');

       //if the table is empty we put it, if not we append

       if(tb_head.children().length==0)
       {
          newth="<th>S/NO</th><th>Registration no</th><th id='assn'>Assignments /"+agg_maxx+"</th>";
          tb_head.html(newth);

          //the content

          for(var cont=0;cont<table_data[disp].length;cont++)
          {
            //console.log(table_data[disp][cont]);
            var sn=cont+1;
            new_content="<tr><td>"+sn+"</td>"+table_data[disp][cont]+"</tr>";
            tb_body.append(new_content);
            //console.log(new_content);

          }
       }
       else
       {
        var assid=$('#assn');
        newth="<th id='assn'>Assignments /"+agg_maxx+"</th>";
        if(tb_head.find(assid).length==0) //does exist
        {
        if(tb_head.find($('#totalid')).length==0)
        {
        tb_head.append(newth);
        
       //the content
       for(var con=0;con<table_data[disp].length;con++)
          {
            new_content=table_data[disp][con];

           
              $('#table_body ').children().eq(con).append(new_content);
          


          }
        }

        else{
          $(newth).insertBefore($('#totalid'));
        
        //the content
        for(var con=0;con<table_data[disp].length;con++)
           {
             new_content=table_data[disp][con];
 
            
               var tr_elem=$('#table_body').children().eq(con);
               var last_td=tr_elem.find(':last-child');
               $(new_content).insertBefore(last_td);
           
           }

        }

       }
       else{
             //update the column instead

             //1. get the column header position
             var col_index=$('#assn').index();
             var all_tr=$('#table_body ').children();
             var count=0;
             //updating the header
             var txt="Assignments /"+agg_maxx;
             
             if(chosen_ass.length>0)
             {
             $('#tablehead').children().eq(col_index).text(txt);


            
             //we loop through the marks table
            for(var my in stud_marks)
            {
               var cell=all_tr.eq(count).children().eq(col_index);
               cell.text(stud_marks[my]);
               count++;


            }

             }
             else
             {

               //means nothing has been selected on the assignments
               //remove the whole column instead
               $('#tablehead').children().eq(col_index).remove();

               for(var del=0;del<all_tr.length;del++)
               {

                all_tr.eq(del).children().eq(col_index).remove();
               }
               
                 //if the assignment is the last

                if(chosen_ass.length==0 && chosen_labs.length==0)
                 {
                 $('#tablehead').html("");
                 $('#table_body').html("");
                 }
                 //if only one remains
                 else if((chosen_ass.length>0 && chosen_labs.length==0) || (chosen_ass.length==0 && chosen_labs.length>0))
               {
                  //the total column is not needed

                  $('#tablehead').find(':last-child').remove();

                  for(var del=0;del<all_tr.length;del++)
                  {

                  all_tr.eq(del).find(':last-child').remove();
                  }
               }
             }

       }
       }
       //we empty the table at each end

       table_data[disp]=[];
       $("#adviser").html("");
       



    }
    //handling labs
    else if(disp=="labs_col" && table_data[disp].length!==0)
    {
       var newth="";
       var new_content="";
       var tb_head=$('#tablehead');
       var tb_body=$('#table_body');

       //if the table is empty we put it, if not we append

       if(tb_head.children().length==0)
       {
      
          newth="<th>S/NO</th><th>Registration no</th><th id='labid'>Labs /"+agg_maxx+"</th>";
          tb_head.html(newth);

          //the content

          for(var cont=0;cont<table_data[disp].length;cont++)
          {
            var sn=cont+1;
            new_content="<tr><td>"+sn+"</td>"+table_data[disp][cont]+"</tr>";
            tb_body.append(new_content);


          }
       }
       else
       {
         var labid=$('#labid');
         if(tb_head.find(labid).length==0)
         {
          newth="<th id='labid'>Labs /"+agg_max+"</th>";
          if(tb_head.find($('#totalid')).length==0)
        {
        
        //if(tb_head.find(labid).length==0)
        tb_head.append(newth);

       //the content
       for(var con=0;con<table_data[disp].length;con++)
          {
            new_content=table_data[disp][con];
            $('#table_body ').children().eq(con).append(new_content);


          }
        }
        else
        {
          //insert it before the total column
          $(newth).insertBefore($('#totalid'));
        
        //the content
        for(var con=0;con<table_data[disp].length;con++)
           {
             new_content=table_data[disp][con];
 
            
               var tr_elem=$('#table_body').children().eq(con);
               var last_td=tr_elem.find(':last-child');
               $(new_content).insertBefore(last_td);
           
           }
        }

       }
       else{
                 //update the column instead

             //1. get the column header position
             var col_index=$('#labid').index();
             var all_tr=$('#table_body').children();
             var count=0;
             //updating the header
             var txt="Labs /"+agg_maxx;
             
             if(chosen_labs.length>0)
             {
             $('#tablehead').children().eq(col_index).text(txt);


            
             //we loop through the marks table
            for(var my in stud_lab_marks)
            {
               var cell=all_tr.eq(count).children().eq(col_index);
               cell.text(stud_lab_marks[my]);
               count++;


            }

             }
             else
             {

               //means nothing has been selected on the assignments
               //remove the whole column instead
               $('#tablehead').children().eq(col_index).remove();

               for(var del=0;del<all_tr.length;del++)
               {

                all_tr.eq(del).children().eq(col_index).remove();
               }

              //if the lab is the last

              if(chosen_ass.length==0 && chosen_labs.length==0)
                 {
                 $('#tablehead').html("");
                 $('#table_body').html("");
                 }
             else if((chosen_ass.length>0 && chosen_labs.length==0) || (chosen_ass.length==0 && chosen_labs.length>0))
               {
                  //the total column is not needed

                  $('#tablehead').find(':last-child').remove();

                  for(var del=0;del<all_tr.length;del++)
                  {

                  all_tr.eq(del).find(':last-child').remove();
                  }
               }
             }

       }
       }
       //we empty the table at each end

       table_data[disp]=[];
      $("#adviser").html("");
     




    }
     //decide to display download button or not
   if($("#table_body").children().length == 0){
  $("#download").css({display:"none"});
  }else{
  $("#download").css({display:"block"});
  }

  

}
  
  
 
  add_totals();
  adviser();
  });
}
adviser();

// $('#download').click(function(e){
//    e.preventDefault();
  
//    var t_content=$('#prevtable').html();
   
//   var form=$('#myform');
//   var container=$('#contain');

//   container.val(t_content);
//   form.submit();
   
//    t_content="";
//  })
$("#download").click(function(){
$("#prevtable").table2excel({
  name:'SHEET1',
  include:'.thead',
  filename:'STUDENTS CA',
  fileext:'.xls'
});
});
//handling the total column
function add_totals()
{
    //about the total column

var headings=$('#tablehead').children();
var totalid=$('#totalid');
if(headings.last().index()>=3 && headings.eq(3)!==totalid)//then we can append the total column
{
  
  //set the heading
  if(headings.last().attr('id')!="totalid")
  {
    //getting the total aggregates
    var total_agg=0;
    for(var agg=2;agg<headings.length;agg++)
    {
      var text=headings.eq(agg).text().split("/");
      var num=parseInt(text[1]);
      total_agg=total_agg+num; 
    }
    
    var newheading="<th id='totalid'>Total /"+total_agg+"</th>";
    $('#tablehead').append(newheading);

    // and the cells

    var body_content=$('#table_body').children();
    var start_ind=2;
    for(var one=0;one<body_content.length;one++)
    {
       var rowcells=body_content.eq(one).children();
       var cellstot=0;
       for(var c=start_ind;c<(rowcells.length);c++)
       {
         cellstot=cellstot+parseFloat(rowcells.eq(c).text());
        
        
       }
       //body_content.eq(one).last().text(cellstot);
       body_content.eq(one).append("<td>"+cellstot+"</td>");
    }
  }
  else
  {
    var total_agg=0;
    for(var agg=2;agg<headings.length-1;agg++)
    {
      var text=headings.eq(agg).text().split("/");
      var num=parseInt(text[1]);
      total_agg=total_agg+num; 
    }
    var newheading="Total /"+total_agg+"";
    $('#tablehead').find(':last-child').text(newheading);

    // and the cells

    var body_content=$('#table_body').children();
    var start_ind=2;
    for(var one=0;one<body_content.length;one++)
    {
       var rowcells=body_content.eq(one).children();
       var cellstot=0;
       for(var c=start_ind;c<(rowcells.length)-1;c++)
       {
         cellstot=cellstot+parseFloat(rowcells.eq(c).text());
        
        
       }
       //body_content.eq(one).last().text(cellstot);
       body_content.eq(one).find(':last-child').text(cellstot);
    }
  }

}
else
{
  //the total does not have to appear
  if($('#tablehead').find(':last-child')==$('#totalid'))
  {
  var total_header=$('#tablehead').find(':last-child');
  var total_col_content=$('#table_body').children();
  for(var rm=0;rm<total_col_content.length;rm++)
  {
    var deleted=total_col_content.eq(rm).find(':last-child');
    deleted.remove();
  }
  total_header.remove();
}
}
}
//the adviser
function adviser()
{

 var total_students="";
 var passed=0;
 var failed=0;
 var failed_percent=0;
 var passed_percent=0;

 //getting the number of students

 
 if($("#table_body").children().length!=0)
 {
 total_students=parseInt($("#table_body").children().last().find(':first-child').text());
 var t_children=$("#table_body").children();
 var totxt=$('#tablehead').find(':last-child').text();
 var totar=totxt.split("/");
var toto=parseInt(totar[1]);
 for(var go=0;go<t_children.length;go++)
 {
   var getlast=t_children.eq(go).find(':last-child');
   var getmarks=parseFloat(getlast.text());

   //if marks greater or equal to 40%, passed

   if((getmarks*100)/toto>=40)
   {
     passed++;
   }
   else
   {
     failed++;
   }

 }

 passed_percent=(passed*100)/total_students;
 failed_percent=(failed*100)/total_students;
 var students_p="<p style='color:blue'>"+total_students+" students</p>";
 var failed_p="<p style='color:red;'>failed: "+failed_percent.toFixed(2)+" %</p>";
 var passed_p="<p style='color:green;'>passed: "+passed_percent.toFixed(2)+" %</p>";
 //var adv="<p style='font-size:20px;font-weight:bold;background-color:#ddd'>Adviser</p>";


 $('#adviser').html(students_p+passed_p+failed_p);




 }
 else
 {
 // $('#adviser').html("<p style='color:blue;font-size:20px;font-weight:bold'>Adviser</p>")
 }




}


});


</script>
<?php
$conn = DB::getConnection();
$mimi = $n;
$code=NULL;
if(isset($_GET['code'])){ 
  $_SESSION['code']=Crypt::decrypt($_GET['code']);
  $code=Crypt::decrypt($_GET['code']);}
else{$code=$_SESSION['code'];}

$q = $conn->prepare("SELECT * FROM `tbl_uploads` where for_course=:for_course  && as_in=:as_in ORDER BY id DESC");
$q->execute([':for_course'=>$code,':as_in'=>'assignment']);
$data = $q->fetchAll(PDO::FETCH_ASSOC);
$assCount = $q->rowCount();
?>
<div class="container-fluid accordion-wrapper mt-1" id="assessment-container">
 <a href="#" class="accordion-title"><span>Generate Coursework Assessment</span></a>
    
    <div class="accordion-content container-fluid" id="AssessmentCollapse">
    
      <div class="row">
        <div class="col-md-4">
          ASSIGNMENT
          <?php
foreach ($data as $d){
                ?>

<div class="checkbox"><input type="checkbox" id="<?php echo $d['total_marks'];?>" name="" value="<?php echo $d['file_name'];?>"  class="ass-checkbox"><?php echo $d['title'];?></div>



                <?php

               }
?>
<?php if($assCount > 0): ?>
<div id="assin_aggmax">
<div class="form-group"><input type="text" id="ass_aggmax" class="form-control" style="width:30%;font-size:11px;padding:5px" placeholder="Reducing factor"></div>
</div>
<?php else: ?>
  <br><strong>No Assignments found</strong>
<?php endif ?>
        </div>
         <div class="col-md-4">
          LABS
          
<?php
$q1 = $conn->prepare("SELECT * FROM `tbl_uploads` where for_course=:for_course && as_in=:as_in ORDER BY id DESC");
$q1->execute([':for_course'=>$code,':as_in'=>'lab']);
$datas = $q1->fetchAll(PDO::FETCH_ASSOC);
$labCount = $q1->rowCount();
foreach ($datas as $d1){

        ?>

<div class="checkbox"><input type="checkbox" id="<?php echo $d1['total_marks'];?>" name="" value="<?php echo $d1['file_name'];?>" class="lab-checkbox"><?php echo $d1['title'];?></div>




        <?php

       }
?>
<?php if($labCount > 0): ?>
<div id="labs_aggmax">
<div class="form-group"><input type="text" id="lab_aggmax" class="form-control" style="width:30%;font-size:11px" placeholder="Reducing factor"></div>
</div>
<?php else: ?>
  <br><strong>No labs found</strong>
<?php endif ?>
</div>
<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <span class="card-title">Performance Summary</span>
    </div>
    <div class="card-body" id="adviser">
      
    </div>
  </div>
</div>
        </div>
        
    
    </div>
    
  </div>



      
  

<div class="container-fluid mt-4">
    <button type="button" id="download" class="btn btn-primary pull-right mb-2" style="display: none;"><i class="fa fa-download"></i><span>Download</span></button>
    
</div>
<div class="container-fluid mt-4">  

    <table id="prevtable" style="width:100%;" class="table table-striped table-bordered table-hover">
<thead>
  <tr id="tablehead" class="thead"></tr>
</thead>
<tbody id="table_body">
</tbody>

</table>
 




</div>



