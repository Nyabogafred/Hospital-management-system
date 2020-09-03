<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
		header("Location: index.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		
		// clean user inputs to prevent sql injections
		$fname = trim($_POST['fname']);
		$fname = strip_tags($fname);
		$fname = htmlspecialchars($fname);

		$lname = trim($_POST['lname']);
		$lname = strip_tags($lname);
		$lname = htmlspecialchars($lname);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$phone = trim($_POST['phone']);
		$phone = strip_tags($phone);
		$phone = htmlspecialchars($phone);

		$address = trim($_POST['address']);
		$address = strip_tags($address);
		$address = htmlspecialchars($address);

		$date_of_birth = trim($_POST['date_of_birth']);
		$date_of_birth = strip_tags($date_of_birth);
		$date_of_birth = htmlspecialchars($date_of_birth);

		$speciality = trim($_POST['speciality']);
		$speciality = strip_tags($speciality);
		$speciality = htmlspecialchars($speciality);

		$department = trim($_POST['department']);
		$department = strip_tags($department);
		$department = htmlspecialchars($department);

		$username = trim($_POST['username']);
		$username = strip_tags($username);
		$username = htmlspecialchars($username);

		$password = trim($_POST['password']);
		$password = strip_tags($password);
		$password = htmlspecialchars($password);
		
		// basic name validation
		if (empty($fname)) {
			$error = true;
			$fnameError = "Please enter your full name.";
		} else if (strlen($fname) < 3) {
			$error = true;
			$fnameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$fname)) {
			$error = true;
			$fnameError = "Name must contain alphabets.";
		}

		if (empty($lname)) {
			$error = true;
			$lnameError = "Please enter your full name.";
		} else if (strlen($lname) < 3) {
			$error = true;
			$lnameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$lname)) {
			$error = true;
			$lnameError = "Name must contain alphabets.";
		}
		
		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM doctors WHERE email='$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($password)){
			$error = true;
			$passwordError = "Please enter password.";
		} else if(strlen($password) < 6) {
			$error = true;
			$passwordError = "Password must have atleast 6 characters.";
		}
		
		// password encrypt using SHA256();
		$password = hash('sha256', $password);
		
		// if there's no error, continue to signup
		if( !$error ) {
			
			$query = "INSERT INTO doctors(fname,lname,email,phone,address,date_of_birth,speciality,department,username,password) VALUES('$fname','$lname','$email','$phone','$address','$date_of_birth','$speciality
				','$department','$username','$password')";
			$res = mysql_query($query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($fname);
				unset($lname);
				unset($email);
				unset($phone);
				unset($address);
				unset($date_of_birth);
				unset($speciality);
				unset($department);
				unset($username);
				unset($password);
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}	
				
		}
		
		
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign up</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container-fluid ">

	<div id="login-form" >
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" class="form-container">
    
    	<div class="col-md-">
        
        	<div class="form-group">
            	<h2 class="">Create your account</h2>
            </div>
        
        	<div class="form-group">
            	<hr />
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	
            	<input type="text" name="fname" class="form-control" placeholder="First Name" maxlength="50"" />
               
                <span class="text-danger"><?php echo $fnameError; ?></span>
            </div>  

              <div class="form-group">
            	
            	<input type="text" name="lname" class="form-control" placeholder="Last Name" maxlength="50" value="" />
               
                <span class="text-danger"><?php echo $lnameError; ?></span>
            </div>
            
            <div class="form-group">
           
            	<input type="email" name="email" class="form-control" placeholder="Email" maxlength="40" value="" />
               
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
              <div class="form-group">
           
            	<input type="text" name="phone" class="form-control" placeholder="Phone Number" maxlength="50" value="" />
               
                <span class="text-danger"><?php echo $phoneError; ?></span>
            </div>

             <div class="form-group">
            	
            	<input type="text" name="address" class="form-control" placeholder="Address" maxlength="50" value="" />
                
                <span class="text-danger"><?php echo $addressError; ?></span>
            </div>

             <div class="form-group">
            	
            	<input type="text" name="date_of_birth" class="form-control" placeholder="Date of birth (YYYY/MM/DD)" maxlength="50" value="" />
                
                <span class="text-danger"><?php echo $date_of_birthError; ?></span>
            </div>


 <div class="form-group">
            	
            	<input type="text" name="speciality" class="form-control" placeholder="Speciality" maxlength="50" value="" />
                
                <span class="text-danger"><?php echo $specialityError; ?></span>
            </div>

 <div class="form-group">
            	
            	<input type="text" name="department" class="form-control" placeholder="Department" maxlength="50" value="" />
                
                <span class="text-danger"><?php echo $departmentError; ?></span>
            </div>


 <div class="form-group">
            	
            	<input type="text" name="username" class="form-control" placeholder="Username" maxlength="50" value="" />
                
                <span class="text-danger"><?php echo $usernameError; ?></span>
            </div>


            <div class="form-group">
            	
            	<input type="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15" />
               
                <span class="text-danger"><?php echo $passwordError; ?></span>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<button type="submit" class="btn btn-primary" name="btn-signup">Sign Up</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
            
            <div class="form-group">
            	<a href="login.php">Log in Here...</a>
            </div>
        
        </div>
   
    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>