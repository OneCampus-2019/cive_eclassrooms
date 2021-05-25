<?php

//this file only works when includes in multigrading file

$assid=Crypt::decrypt($_GET['assid']);
$sql="select * from ass_questions where assID=:assID";
$stmt = $conn->prepare($sql);
$stmt->execute([':assID'=>$assid]);
if($stmt->rowCount() > 0)
{
$a=1;
while($q = $stmt->fetch(PDO::FETCH_ASSOC))
{
    print('<b>Q'.$a.'</b>');
    
?>
<div id="qmxs" style="width:90%; height:fit-content;height:moz-fit-content;height:webkit-fit-content">
<input id="qmarks" type="text" placeholder="" value=0 name="q_score[]" style="width:35px;height:35px;border-color:white; color:blue; font-weight:bold; border-radius:7px;float:left;text-align:center" />
<input id="maxima" type="text" value="<?php print $q['Q_max'];?>" placeholder="" name="q_score[]" style="width:37px;height:35px;border-color:#white;background-color:black;color:white;font-weight:bold; border-radius:7px;float:left;text_align:center" readonly/>
</div>
<?php

$a++;

}



}
?>