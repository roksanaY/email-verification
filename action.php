<?php 
	
	//Database connention
	$conn = mysqli_connect("localhost", "root", "", "email_varification");

	if(!$conn){
		die("Could not connect to database.".mysqli_connect_error());		
	}
	else{
		//Grabing form data
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$repeatPassword = md5($_POST['repeatPassword']);
		$code = substr(md5(mt_rand()), 0, 15);
		
		//Password checking
		if($password == $repeatPassword){
			$sql = "INSERT INTO users (firstName, lastName, email, password, code)VALUES('$firstName', '$lastName', '$email', '$password', '$code')";
			
				//Inserting data into users table
				if(mysqli_query($conn, $sql)){
					$to = $email;
					$subject = "Activation link from Roksana";
					
					$body = "<h3>Hi ".$firstName.",<br />Your activation code is ".$code."<br />Please click on bellow link to verify your email : <br /><a href='https://emailvarification.roksana.me/verify.php?email=".$email."&code=".$code."'>http://localhost/email_varification/verify.php?email=".$email."&code=".$code."</a></h3>";
					
					$headers = "Content-type:text/html; charset=UTF-8";
					
					//Sending activation link to email
					if(mail($to, $subject, $body, $headers)){
						echo"<h5>An activation link was sent to your email. Please verify your email.</h5>";
					}
					else{
						echo"<h5 class='text-danger'>Something went wrong.</h5>";
					}
				}

		}
		else{
			echo"<h5 class='text-danger'>Password not matched.</h5>";
		}
		
		
	}




?>