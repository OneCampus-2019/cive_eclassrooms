+++++++<?php 
	session_start();
	include('includes/db/db.php');
	use App\DB;
//login functionality
	if (isset($_POST['log'])) {
		$un = $_POST['username'];
		$pass = md5($_POST['password']);

		//strip away to escape mysql injection
		//$un = mysqli_real_escape_string($con,$un);
		//$pass = mysqli_real_escape_string($con,$pass);
		//$passhash = md5($pass);// tutajadili hash mpya kwenye phase 2
		$error = "";

		if (isset($un) && isset($pass)) {
			//cheking if the username field has been filled
			if(isset($un) && !empty($un)){
				if(isset($pass) && !empty($pass)){
					//checking the user from the database
					$conn = DB::getConnection();
					$stmt1 = $conn->prepare("SELECT * FROM tbl_users WHERE (email = :email OR user=:user) AND password=:password ");
					$stmt2 = $conn->prepare("SELECT * FROM tbl_students WHERE registration_no = :registration_no AND password=:password ");
					$stmt1->execute([':email'=>$un, ':user'=>$un, ':password'=>$pass]);
					$stmt2->execute([':registration_no'=>$un, ':password'=>$pass]);
					$user = $stmt1->fetch(PDO::FETCH_OBJ);
					$student = $stmt2->fetch(PDO::FETCH_OBJ);
					
					//counting rows returned
					$rows_count = $stmt1->rowCount();
					$rows_count2 = $stmt2->rowCount();

					//checking the returned rows
					if ($rows_count == 1) {
						//fetching the details from database
						//$get = mysqli_fetch_assoc($check);
						
						if ($user->active === '1') {
							$db_username = $user->user;
							$db_email = $user->email;
							$db_level = $user->level;
							$db_name = $user->name;
							$db_dpt = $user->department;

							//creating session from the aquired details from the datase
							$_SESSION['user'] = $db_username;
							$_SESSION['level'] = $db_level;
							$_SESSION['email'] = $db_email;
							$_SESSION['name'] = $db_name;
							$_SESSION['department'] = $db_dpt;
							$stm = $conn->prepare("INSERT INTO tbl_logs SET username=:username, action=:action, Description=:Description");
							$stm->execute([':username'=>$db_name, ':action'=>'loggedin', ':Description'=>'Logged In into the System']);
							//if its 
							if ($db_level === '9') {
								header('location: ./admin/index ');
							}elseif ($db_level === '7' OR $db_level === '8') {
								if($db_level === '7'){
									header('location: ./instructor/index');
								}elseif($db_level === '8'){
									header('location: ./instructor/prog_config ');
								}
							}
							
						}else $error = "Account is Not Active / User Not Found";
					}elseif($rows_count2 == 1){
						//$get = mysqli_fetch_assoc($check2);
							$db_username = $student->registration_no;
							$db_email = $student->registration_no;
							$db_level = '0';
							$db_name = $student->student_name;

							//creating session from the aquired details from the datase
							$_SESSION['user'] = $db_username;
							$_SESSION['level'] = $db_level;
							$_SESSION['email'] = $db_email;
							$_SESSION['name'] = $db_name;
							$studentLog = $conn->prepare("INSERT INTO tbl_logs SET username=:username, action=:action, Description=:Description");
							$studentLog->execute([':username'=>$db_name, ':action'=>'loggedin', ':Description'=>'Logged In into the System']);
							//if its 
							header('location: ./student/index');
					} else $error = "Either Password or Username is wrong!";

				}else $error = "Please Fill in The Password";

			}else $error = "Please Fill in The Username";
			
		}else $error = "Please Fill in All Details Required!";
	}


 ?>