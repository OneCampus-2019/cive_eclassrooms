<?php require_once('process/process_login.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CIVE e-CLASSROOM | Login</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/x.png">
        <link href="assets/css/styles.css" rel="stylesheet" />
        	
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        
        <link href="assets/css/custom.css" rel="stylesheet" />
        <script src="assets/vendor/jquery/jquery.min.js"></script>
	    <!-- Bootstrap Core JavaScript -->
	    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        
    </head>
    <body class="bg-primary">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
           <a class="navbar-brand" href="#">
            <img src="assets/img/logo.PNG" alt="Logo" style="width:40px; border-radius: 50%;">
          </a>
          <a class="navbar-brand ml-auto mr-auto" href="#">CIVE e-CLASSROOM</a>
        </nav>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                    	<center><img src="assets/img/logo.PNG" style="border-radius: 50%;" width="100px"></center>
                                    </div>
                                    <div align="center">
                                    	<?php if(isset($_POST['log'])){
							            	echo '
							            <div class="alert alert-danger alert-dismissible col-md-10">
							            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									    	<strong>';
									    	echo $error;
									    	echo '
									    	</strong>
									  	</div>';
									  }
									 ?>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" type="text" placeholder="Enter Username" name="username" /></div>
                                            <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" name="password"/></div>
                                         
                                        	<div align="center">
                                            	<button type="submit" name="log" class="btn btn-primary" >Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>
        
        <script src="assets/js/scripts.js"></script>
    </body>
</html>
