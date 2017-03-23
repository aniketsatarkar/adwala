<?php
	session_start();
?>

<?php
	
	include_once "dbcred.php";
	
	global $_CONN;
	
	if(!$_CONN)
	{
		echo "Failed to connect to the database !";
		die();
	}
	
	if(is_array($_POST))
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$query = "SELECT * FROM adwala.user WHERE usr_username='$username' OR usr_email='$username' OR usr_mobile='$username'";
			
			$result = mysqli_query($_CONN, $query);
			$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
			if(sizeof($resultArray) == 0)
			{
				$output = array("status" => "failed",
								"message" => "u_nv"); // <----
				echo json_encode($output);
			}
			else
			{
				$retrived_pass = $resultArray[0]['usr_password'];
				
				if($retrived_pass == $password)
				{
					$_SESSION['user_username'] = $username;
					$_SESSION['user_id'] = $resultArray[0]['usr_id'];
					$_SESSION['user_role'] = $resultArray[0]['usr_role'];
					
					$output = array("status" => "success",
									"message" => "ls"); // <----
					echo json_encode($output);
				}
				else
				{
					$output = array("status" => "failed",
								"message" => "p_nv"); // <----
					echo json_encode($output);
				}
			}
		}
	}

?>