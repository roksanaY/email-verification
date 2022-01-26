<?php 

	//Database connention
	$conn = mysqli_connect("localhost", "root", "", "email_varification");

	if(!$conn){
		die("Could not connect to database.".mysqli_connect_error());		
	}
	else{
		//Grabing data from URL
		if(isset($_GET['email']) && isset($_GET['code'])){

			$email = $_GET['email'];
			$code = $_GET['code'];

			//Getting data from users table
			$sql = "SELECT * FROM users WHERE email='$email' AND code='$code'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);

			//Assignning data from users table to new variable
		    $v_first_name = $row['firstName'];
			$v_last_name = $row['lastName'];
			$v_email = $row['email'];
			$v_pass = $row['password'];
			$v_code = $row['code'];


			if($code == $v_code){

				$query = "INSERT INTO varified_users(v_first_name, v_last_name, v_email, v_pass)VALUES('$v_first_name', '$v_last_name', '$v_email', '$v_pass')";

				//Delete data from users table
				mysqli_query($conn, "DELETE FROM users WHERE email='$email' AND code='$code'");

				//Inserting data to varified_users table
				if(mysqli_query($conn, $query)){
					
					//Re-directing with value
					header("location:profile.php?name=$v_first_name");
				}
				else{
					echo"<h5 class='text-danger'>Something went wrong.</h5>";
				}
			}
			else{
				echo"<h5 class='text-danger'>Code does not matched.</h5>";
			}
		}
	}

?>