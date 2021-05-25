<?php require_once '../includes/header.php'; 
if(hasAuthority('9')){
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Add Department <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
	<form action="" method="POST">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dname">Department Name</label><input class="form-control py-4" id="inputFirstName" type="text" name="deptName" placeholder="Enter Department Name" /></div>
                </div>
                
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcode">Department Code</label><input class="form-control py-4" id="inputPassword" type="text" name="deptCode" placeholder="Enter Department Code" /></div>
                </div>                
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group"><label class="small mb-1" for="dcolege">Department College</label><input class="form-control py-4" id="inputPassword" type="text" name="deptCollege" placeholder="Enter Department college" /></div>
                </div>                
            </div>
            <div class="form-group mt-4 mb-0">
            	<button class="btn btn-primary" name="deptAdd" type="submit">Add Department</button>
            </div>
        </form>
	</div>


<?php require_once '../includes/footer.php'; }
else { logOut(); }?>