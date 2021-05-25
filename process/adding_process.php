<?php  
require_once('../includes/db/db.php');
		use App\DB;

	//adding department mechanism
	if (isset($_POST['deptAdd'])) {
		$conn = DB::getConnection();
		$pn = $_POST['deptName'];
		$pc =$_POST['deptCode'];
		$p_c = $_POST['deptCollege'];

		if (!empty($pn) && !empty($pc) && !empty($p_c)) {
			$q = $conn->prepare("INSERT INTO `tbl_department`(department_name,department_code,department_college) VALUES(:department_name,:department_code,:department_college) ");
			$q->execute([':department_name'=>$pn, ':department_code'=>$pc, ':department_college'=>$p_c]);
			?>
				<script>
					alert("Department Added successfull!");
				</script>
			<?php
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}

	//updating department mechanism
	if (isset($_POST['deptUpdate'])) {
		$conn = DB::getConnection();
		$dn = $_POST['deptName'];
		$dc = $_POST['deptCode'];
		$d_c = $_POST['deptCollege'];
		$idd =$_POST['idd'];

		if (!empty($dn) && !empty($dc) && !empty($d_c)) {
			
			$q = $conn->prepare("UPDATE `tbl_department` SET department_name=:department_name, department_code=:department_code,department_college=:department_college WHERE id=:id");
			$success = $q->execute([':department_name'=>$dn, ':department_code'=>$dc, ':department_college'=>$d_c, ':id'=>$idd]);
			if($success){
	
			?>
				<script>
					alert("Department Updated successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}
	
	// *********************************************************** //
	// programs //
	// ************************************************************//
	//adding program mechanism
	if (isset($_POST['AddProg'])) {
		$conn = db::getConnection();
		$pn = $_POST['progName'];
		$pc = $_POST['progCode'];
		$p_c = $_POST['progCollege'];
		$pd = $_POST['progDept'];
		$yos = $_POST['yos'];

		if (!empty($pn) && !empty($pc) && !empty($p_c) && !empty($pd) && !empty($yos)) {
			$q = $conn->prepare("INSERT INTO `tbl_programs`(program_name,program_code,duration,program_college,program_department,assigned_to) VALUES(:program_name,:program_code, :duration, :program_college, :program_department,:assigned_to) ");
			$success = $q->execute([':program_name'=>$pn, ':program_code'=>$pc, ':program_college'=>$p_c, ':duration'=>$yos, ':program_department'=>$pd, ':assigned_to'=>'']);
			if($success){
			?>
				<script>
					alert("Program Added successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}
	//udate program mechanism
	if (isset($_POST['UpdateProg'])) {
		$conn = DB::getConnection();
		$pn = $_POST['progName'];
		$pc = $_POST['progCode'];
		$p_c = $_POST['progCollege'];
		$pd = $_POST['progDept'];
		$yos = $_POST['yos'];
		$idd = $_POST['iddd'];

		if (!empty($pn) && !empty($pc) && !empty($p_c) && !empty($pd) && !empty($yos)) {
			//$q = "INSERT INTO `tbl_programs` VALUES('','$pn','$pc','$yos','$p_c','$pd','') ";
			$q = $conn->prepare("UPDATE `tbl_programs` SET program_name=:program_name,program_code=:program_code,program_college=:program_college,duration=:duration,program_department=:program_department WHERE id = :id ");
			$success = $q->execute([':program_name'=>$pn, ':program_code'=>$pc, ':program_college'=>$p_c, ':duration'=>$yos, ':program_department'=>$pd, ':id'=>$idd]);
			if($success){
		
			?>
				<script>
					alert("Program Updated successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}

	// *********************************************************** //
	// Course //
	// ************************************************************//

	//adding course mechanism
	if (isset($_POST['AddCourse'])) {
		$conn = DB::getConnection();
		$cn = $_POST['courseName'];
		$cc = $_POST['courseCode'];
		$c_c =$_POST['courseCredit'];
		//$pd = $_POST['courseCredit'];
		$sem = $_POST['semester'];
		$sts = $_POST['status'];
		$dept = $_POST['dept'];

		if (!empty($cn) && !empty($cc) && !empty($c_c)  && !empty($sem) && !empty($sts) && !empty($dept)) {
			$q = $conn->prepare("INSERT INTO `tbl_course`(course_name,course_semester,course_code,course_credits,department,status,assigned_to) VALUES(:course_name,:course_semester,:course_code,:course_credits,:department,:status, :assigned_to) ");
			$success = $q->execute([':course_name'=>$cn, ':course_semester'=>$sem, ':course_code'=>$cc, ':course_credits'=>$c_c, ':department'=>$dept, ':status'=>$sts, ':assigned_to'=>'']);
			if($success){
		
			?>
				<script>
					alert("Course Added successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}
	//udate course mechanism
	if (isset($_POST['UpdateCourse'])) {
		$conn = DB::getConnection();
		$cn = $_POST['courseName'];
		$cc = $_POST['courseCode'];
		$c_c = $_POST['courseCredit'];
		//$pd = $_POST['courseCredit'];
		$sem = $_POST['semester'];
		$sts = $_POST['status'];
		$dept = $_POST['dept'];
		$idd = $_POST['id1'];

		if (!empty($cn) && !empty($cc) && !empty($c_c)  && !empty($sem) && !empty($sts) && !empty($dept)) {
			//$q = "INSERT INTO `tbl_programs` VALUES('','$pn','$pc','$yos','$p_c','$pd','') ";
			$q = $conn->prepare("UPDATE `tbl_course` SET course_name=:course_name,course_code=:course_code,course_credits=:course_credits,course_semester=:course_semester,status=:status,department=:department WHERE id = :id ");
			$success = $q->execute([':course_name'=>$cn, ':course_code'=>$cc, ':course_credits'=>$c_c, ':course_semester'=>$sem, ':status'=>$sts, ':department'=>$dept, ':id'=>$idd]);
			if($success){
			?>
				<script>
					alert("Course Updated successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}

// *********************************************************** //
	// Student //
	// ************************************************************//

	//udate student mechanism
	if (isset($_POST['UpdateStd'])) {
	
		$conn = DB::getConnection();
		$name = $_POST['Name'];
		$loginName =$_POST['logName'];
		$id = $_POST['id2'];
		$p = explode(' ', $name);
		$pass = md5(end($p));

		if (!empty($name) && !empty($loginName)) {
			//$q = "INSERT INTO `tbl_programs` VALUES('','$pn','$pc','$yos','$p_c','$pd','') ";
			$q = $conn->prepare("UPDATE `tbl_students` SET student_name=:student_name,registration_no=:registration_no,password=:password WHERE id = :id ");
			$success = $q->execute([':student_name'=>$name, ':registration_no'=>$loginName, ':password'=>$pass, ':id'=>$id]);
			if($success){
		
			?>
				<script>
					alert("Student Updated successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}
	// *********************************************************** //
	// System User //
	// *********************************************************//
	//adding program mechanism
	if (isset($_POST['AddUser'])) {
		$conn = DB::getConnection();
		$n =$_POST['Name'];
		$un =$_POST['username'];
		$p =$_POST['pass'];
		$e = $_POST['email'];
		$role = $_POST['role'];
		$dept = $_POST['dept'];
		

		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $p);
		$lowercase = preg_match('@[a-z]@', $p);
		$number    = preg_match('@[0-9]@', $p);
		$specialChars = preg_match('@[^\w]@', $p);

		if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($p) < 8) {

		    echo "<script>alert('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');</script>";
		}else{
		    //echo 'Strong password.';
		//}
		$p = md5($p);
		if($role === '9'){
			$dept = "Admin";
		}

		if (!empty($n) && !empty($un) && !empty($p) && !empty($e) && !empty($role) && !empty($dept)) {
			if(exists('tbl_users', 'user', $un) ||exists('tbl_users', 'user', $e)){
				echo "<script>alert('This user already exists!')</script>";
			}else{
			$stmt = $conn->prepare("INSERT INTO `tbl_users`(user,password,name,email,level,notify,created_by,active,account_requested,account_denied,max_file_size,department) VALUES(:user,:password,:name,:email,:level,:notify,:created_by,:active,:account_requested,:account_denied,:max_file_size,:department)");
			$success = $stmt->execute([':user'=>$un, ':password'=>$p, ':name'=>$n, ':email'=>$e, ':level'=>$role, ':notify'=>0, ':created_by'=>'Admin', ':active'=>1, ':account_requested'=>0, ':account_denied'=>0, ':max_file_size'=>2048, ':department'=>$dept]);
			if($success){
			
			?>
				<script>
					alert("User Added Successfull!");
				</script>
			<?php
		}
	}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}//else for new codes
	}

	// ********************************** //
	//  Upload List Of Std2              //
	// ********************************** //
	if(isset($_POST['astf'])){
		$conn = DB::getConnection();
		include 'vendor/autoload.php';
		//$dept = $_POST['deptName'];
		if ($_FILES["excels"]["name"] != '') {
			$extension = pathinfo($_FILES["excels"]["name"], PATHINFO_EXTENSION);
			if (in_array($extension, ['csv','xls','xlsx'])) {
				$fr = 0;
				$fn = time() .'.'. $extension;
				move_uploaded_file($_FILES['excels']['tmp_name'], $fn);
		        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($fn);
		        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
		        $spreadsheet = $reader->load($fn);
		        unlink($fn);
		        $data = $spreadsheet->getActiveSheet()->toArray();
		        $counter = 0;
		        foreach ($data as $row) {
		        	$fr++;
		        	if($fr != 1){
		        	$fullname = $row[1];
        			$names = explode(" ",$fullname);
        			$last = end($names);
        			$last = md5($last);
        			$c = "";
        			if(strtolower($row[3]) == "instructor"){
        				$role = 7;
        			}elseif(strtolower($row[3]) == "administrator"){
        				$role = 9;
        				$row[4] = "Admin";
        			}elseif(strtolower($row[3]) == "hod"){
        				$role = 8;
        			}else{
        				$role = 0;
        			}
        			$notify = 0;
        			$ad = "Admin";
        			$active = 1;
        			$mx = 2048;
		        	
        			if(exists('tbl_users', 'user', $row[0])){
        				continue;
        			}else{
		        	$statement = $conn->prepare("INSERT INTO tbl_users(user,password,name,email,level,notify,created_by,active,account_requested,account_denied,max_file_size,department) VALUES(:user, :password, :name, :email, :level, :notify, :created_by, :active, :account_requested, :account_denied, :max_file_size, :department)");
		        	$statement->execute([':user'=>$row[0], ':password'=>$last, ':name'=>$row[1], ':email'=>$row[2], ':level'=>$role, ':notify'=>$notify, ':created_by'=>$ad, ':active'=>$active, ':account_requested'=>$notify, ':account_denied'=>$notify, ':max_file_size'=>$mx, ':department'=>$row[4]]);
		        	$counter++;
		        }
	
		        }
		    	}
		    	if($counter > 0){
		        echo "<script>alert('".$counter." Users Successfull Uploaded')</script>";
		    }else{
		    	echo "<script>alert( ' No any User uploaded, May be all users you are trying to upload already exist in the system')</script>";
		    }
		    }else{
		    	echo "<script>alert('Unsoported File Extension')</script>";
		    }
		}else{
			echo "<script>alert('please select a file')</script>";
		}

		
	}


	//udate user mechanism
	if (isset($_POST['UpdateUser'])) {
		$conn = DB::getConnection();
		$n = $_POST['Name'];
		$un =$_POST['username'];
		$e = $_POST['email'];
		$role = $_POST['role'];
		$dept = $_POST['dept'];
		$id = $_POST['id3'];
		//$us = $_POST['actUser']; // hii nayo iapdetiwe
		$p = md5($p);

		if (!empty($n) && !empty($un) && !empty($e) && !empty($role) && !empty($dept)) {
			//$q = "INSERT INTO `tbl_programs` VALUES('','$pn','$pc','$yos','$p_c','$pd','') ";
			$stmt = $conn->prepare("UPDATE `tbl_users` SET name=:name,user=:user,email=:email,level=:level,department=:department WHERE id = :id");
			$success = $stmt->execute([':name'=>$n, ':user'=>$un, ':email'=>$e, ':level'=>$role, ':department'=>$dept, ':id'=>$id]);
			if($success){
			
			?>
				<script>
					alert("User Updated successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}

	//setting mechanism
	if (isset($_POST['setAcc'])) {
		$conn = DB::getConnection();
		$oldp = $_POST['oldpass'];
	   $newp = md5($_POST['newpass']);
	   $role = $_SESSION['level'];
		//$em = $_POST['email'];
	   $username = $_SESSION['user'];
	   if($role === '0'){
	   	 $stmt = $conn->prepare("SELECT password FROM tbl_students WHERE registration_no=:registration_no");
	   $stmt->execute([':registration_no'=>$username]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
         $oldBDpassword = $user->password;
	   }else{
	   $stmt = $conn->prepare("SELECT password FROM tbl_users WHERE user=:user");
	   $stmt->execute([':user'=>$username]);
	   $user = $stmt->fetch(PDO::FETCH_OBJ);
	   $oldBDpassword = $user->password;
	}
	   
		
		// $dept = $_POST['dept'];
		//$id3 = mysqli_real_escape_string($con,$_POST['id']);
		//$us = $_POST['actUser']; // hii nayo iapdetiwe

		if (!empty($oldp) || !empty($newp)) {
			if($oldBDpassword != md5($oldp)){
				echo "<script>alert('Incorrect Old Password')</script>";
			}else{
			//$q = "INSERT INTO `tbl_programs` VALUES('','$pn','$pc','$yos','$p_c','$pd','') ";
			if($role === '9' OR $role === '8' OR $role === '7'){
				$q = $conn->prepare("UPDATE `tbl_users` SET password=:password WHERE user = :user");
				$q->execute([':password'=>$newp, ':user'=>$username]);
			}elseif($role === '0'){
				$q = $conn->prepare("UPDATE `tbl_students` SET password=:password WHERE registration_no = :registration_no ");
				$q->execute([':registration_no'=>$username, ':password'=>$newp]);
			}
			
			?>
				<script>
					alert("Account Updated successfull!");
				</script>
			<?php
		}
		}else{
			
			?>
			<script type="text/javascript">
				alert("Fill In All Fields");
			</script>
			<?php
		}
	}



	// ********************************** //
	//  Upload List Of Std2              //
	// ********************************** //
	if(isset($_POST['astd'])){

        $conn = DB::getConnection();
		include 'vendor/autoload.php';
		$dept = $_POST['deptName'];
		if ($_FILES["excel"]["name"] != '') {
			$extension = pathinfo($_FILES["excel"]["name"], PATHINFO_EXTENSION);
			if (in_array($extension, ['csv','xls','xlsx'])) {
				$fr = 0;
				$fn = time() .'.'. $extension;
				move_uploaded_file($_FILES['excel']['tmp_name'], $fn);
		        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($fn);
		        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
		        $spreadsheet = $reader->load($fn);
		        unlink($fn);
		        $data = $spreadsheet->getActiveSheet()->toArray();

		        foreach ($data as $row) {
		        	$fr++;
		        	if($fr != 1){
		        	$fullname = $row[1];
        			$names = explode(" ",$fullname);
        			$last = end($names);
        			$last = md5($last);
        			$c = "";
		        	$data = array(
		        	':student_name'		=> $row[1],
		        	':sex'				=> $row[2],
				':f4_index_number'     =>$row[3],
		        	':registration_no'	=> $row[4],
		        	':regNo'	=> $row[4],
		        	':password'			=> $last,
		        	':year_of_study'	=> $row[5],
		        	':programme_name'	=> $row[6],
		        	':programme_code'	=> $row[7],
		        	':study_level'		=> $row[8],
		        	':registered_on'	=> $row[9],
		        	':status'			=> $row[10],
		        	':courses'			=> '',
		        	':department'		=> $dept
		        	);
		        	if(exists('tbl_students', 'registration_no', $row[3])){
		        	continue;
		        	}else{

		        	$query = "INSERT INTO tbl_students(student_name,sex, f4_index_number, registration_no,password,year_of_study,programme_name,programme_code,study_level,registered_on,status,courses,department) VALUES(:student_name,:sex, :f4_index_number, :registration_no,:password,:year_of_study, :programme_name, :programme_code,:study_level, :registered_on, :status, :courses, :department) ON DUPLICATE KEY UPDATE registration_no=:regNo";
		        	$statement = $conn->prepare($query);
		        	$statement->execute($data);
		        }
		        	
		        }
		    	}
		        echo "<script>alert('Successfull Uploaded')</script>";
		    }else{
		    	echo "<script>alert('Unsoported File Extension')</script>";
		    }
		}else{
			echo "<script>alert('please select a file')</script>";
		}

		
	}

	// ********************************** //
	//  Upload single Std              //
	// ********************************** //
	if (isset($_POST['AddStd'])) {
		$conn = DB::getConnection();
		$stdName =$_POST['stdName'];
		$stdRegNo = $_POST['regNo'];
		$deptName = $_POST['deptName'];
		$progName = $_POST['progName'];
		$stdYos = $_POST['yos'];
		$stdGender =$_POST['gender'];
		if(empty($stdName) || empty($stdRegNo) || empty($deptName) ||empty($progName) || empty($stdYos) || empty($stdGender)){
			echo "<script>alert('Fill all fields')</script>";

		}else{
		$status = "Registered";
		$c = "";
		// password getting and encryptiing
		$names = explode(" ",$stdName);
		$last = end($names);
		$pass = md5($last);

		//what else to get from the input
		//1. program code
		$stmt = $conn->prepare("SELECT * FROM `tbl_programs` WHERE program_name=:program_name");
		$stmt->execute([':program_name'=>$progName]);

		$x = $stmt->fetch(PDO::FETCH_ASSOC);
		$progCode=$x['program_code'];
		//2. study level
		$programs = explode(" ", $progName);
		$studyLevel = $programs[0];
		
		//3. registered on
		$regOn = date('F d, Y');

			if(exists('tbl_students', 'registration_no', $stdRegNo)){
				echo "<script>alert('This student already exists!')</script>";
			}else{
			$query = $conn->prepare("INSERT INTO tbl_students(student_name,sex,registration_no,password,year_of_study,programme_name,programme_code,study_level,registered_on,status,courses,department) VALUES(:student_name, :sex, :registration_no, :password, :year_of_study, :programme_name, :programme_code, :study_level, :registered_on, :status, :courses, :department)");
			$query->execute([':student_name'=>$stdName, ':sex'=>$stdGender, ':registration_no'=>$stdRegNo, ':password'=>$pass, ':year_of_study'=>$stdYos, ':programme_name'=>$progName, ':programme_code'=>$progCode, ':study_level'=>$studyLevel, ':registered_on'=>$regOn, ':status'=>$status, ':courses'=>$c, ':department'=>$deptName]);
    	?>
				<script>
					alert("Student Added successfull!");
				</script>
			<?php
		}
		
	}
}
//CA configuration
if(isset($_POST['configCA'])){
	$conn = DB::getConnection();
	$ccode = $_POST['course'];
	$asin = $_POST['as_in'];
	$outof = $_POST['outof'];
	$assid = $_POST['assid'];
	$instructor = $_POST['inst'];
	$stmt = $conn->prepare("INSERT INTO tbl_coursework (ass_id, outof, course_code, instructor, as_in) VALUES (:ass_id, :outof, :course_code, :instructor, :as_in)");
	$success = $stmt->execute([':ass_id'=>$assid, ':outof'=>$outof, ':course_code'=>$ccode, ':instructor'=>$instructor, ':as_in'=>$asin]);
	if($success){
		echo "<script>
		alert('Assignment configured');
		if(window.history.replaceState){
			window.history.replaceState(null, null, window.location.href);
		}
		</script>";

	}



}


		
	

?>
