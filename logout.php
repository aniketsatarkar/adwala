<?php
	session_start();
?>

<?php
	
	if(is_array($_POST) && isset($_POST['logout']))
	{
		session_unset();
		
		if(session_destroy())
		{
			$output = array("status" => "success", 
							"message" => "Successfully Logout !");
			echo json_encode($output);
		}
		else
		{
			$output = array("status" => "failed", 
							"message" => "Faild To Logout !");
			echo json_encode($output);
		}
	}	
?>