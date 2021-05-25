<?php require_once '../includes/header.php'; 
use App\DB;
if(hasAuthority('9')){

$conn = DB::getConnection();
?>
<script type="text/javascript">
    function deptingi(txtx) {
        var btc = document.getElementById('deptings');
        if (txtx.value == 9) {
            btc.style.display = 'none';
        }
        else {
            btc.style.display = 'block';
        }
    }
  </script>
  <style type="text/css">
      #deptings{
        display: block;
      }
  </style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        	<h2 class="mt-4">Add System User <i class="pull-right muted" style="font-size: 18px;"><?php echo date("F d, Y h:i:s A"); ?></i></h2>
        	<hr>
    <div class="row" >
    <div class="col-xl-3 col-md-3" >
        <h4>Upload List By Excel</h4>
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group"><label class="small mb-1" for="dname">Upload By Excel File</label>
                        <input class="form-control-file py-2" id="Excel" type="file" name="excels" placeholder="Enter Course Name" /></div> <!-- the name should be fetched -->
                </div>                              
            </div>
            <div class="form-group mt-4 mb-0">
                <button class="btn btn-primary" name="astf" type="submit">Upload Staffs</button>
            </div>
        </form>
    </div>
    <div class="col-xl-2 col-md-2" style="border-right: 1px solid #bbb;">
        <h5>Download format</h5>
        <a href="../upload/template/Add_users_template.xlsx" class="btn btn-primary">
            <i class="fa fa-4x fa-download"></i>
        </a>        
    </div>

    <div class="col-xl-7 col-md-7" >
        <h4>Add Single Staff</h4>
	<form action="" id="add_user_form" method="POST" onsubmit="return validateForm();">
        <!-- this div is for javascript validation -->
        <div id="errorDiv" align="center"></div>
        <!-- //this div is for javascript validation -->
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dname">Name</label>
                    <input class="form-control" id="inputFirstName" type="text" name="Name" placeholder="Enter Name" />
                    <p class="help-block errFB errorSpan" id="inputFirstNameError">Fullname is Required</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dcode">Login Username</label>
                    <input class="form-control" id="inputUsername" type="text" name="username" placeholder="Enter Login Username" />
                    <p class="help-block errFB errorSpan" id="inputUsernameError">Username is Required</p>
                </div>
            </div> 
        </div>
        
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dcolege">Password</label>
                    <input class="form-control" id="inputPassword" type="pass" name="pass" placeholder="Enter Password" />
                    <!-- <p class="help-block errFB errorSpan" id="inputPasswordError">Password is Required</p> -->
                    <div class="help-block errFB errorSpan" id="inputPasswordError"></div>
                </div>
            </div> 
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dcolege">Email</label>
                    <input class="form-control" id="email" type="email" name="email" placeholder="Enter email" />
                    <p class="help-block errFB errorSpan" id="emailError">Email is Required</p>
                </div>
            </div>                 
        </div>
        
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="small mb-1" for="dcolege">Role</label>
                    
                    <select id="role" name="role" class="form-control" onchange="deptingi(this);">
                        <option value="">Choose...</option>
                        <option value="9">Administrator</option>
                        <option value="7">Instructor</option>
                        <option value="8">HOD</option>
                    </select>
                    <p class="help-block errFB errorSpan" id="roleError">Role is Required</p>
                </div>
            </div>  
            <div class="col-md-6" id="deptings">
                <div class="form-group">
                    <label class="small mb-1" for="dcolege">Department</label>
                    
                    <select id="dept" name="dept" class="form-control">
                        <option value="">Choose From The List...</option>
                        <?php  
                        $r = $conn->prepare("SELECT *  FROM `tbl_department`");
                        $r->execute();
                        while($rk = $r->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <option value="<?php echo $rk['department_code']; ?>"><?php echo $rk['department_name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <p class="help-block errFB errorSpan" id="deptError">Department is Required</p>
                </div>
            </div>             
        </div>
        
        <div class="form-group mt-4 mb-0">
        	<button class="btn btn-primary" name="AddUser" type="submit">Add User</button>
        </div>
    </form>
    </div>


	</div>


<?php require_once '../includes/footer.php'; 
} else { logOut(); }?>