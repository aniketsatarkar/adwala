<?php
	
	// include external files.
	include_once "dbcred.php";
	include_once "phpmailer/class.phpmailer.php";
	include_once "phpmailer/class.smtp.php";

	
	
	// function to generate random string of specified length.
	function randomStr($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$charactersLength = strlen($characters);
		$randomString = '';
		
		for ($i = 0; $i < $length; $i++) 
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		return $randomString;
	}
	
	// function to email to user, notifying the changed
	// password.
	function sendEmail($to, $password)
	{
		// code to send password to the user
		// via e-mail.
		// $to => email address or receiver.
		// $password => resetten un-encrypted password.
		$mail = new PHPMailer;

		//Enable SMTP debugging.
		$mail->SMTPDebug = 3;

		//Set PHPMailer to use SMTP.
		$mail->isSMTP();

		//Set SMTP host name
		$mail->Host = "smtp.gmail.com";

		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;

		//Provide username and password
		$mail->Username = "aniketsatarkar9@gmail.com";
		$mail->Password = "aniket420";

		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "tls";

		//Set TCP port to connect to
		$mail->Port = 587;

		$mail->From = "aniketsatarkar9@gmail.com";
		$mail->FromName = "Aniket Satarkar";

		// ---- reciepents address ----
		$mail->addAddress($to, " "); // <---

		// set if the contents of the email are html or not.
		$mail->isHTML(false);

		$mail->Subject = "Subject to password recovery.";
		$mail->Body = "Your new password is" . $password;
		$mail->AltBody = "Your new password is " . $password;
		
		// send email >>
		
		//if(!$mail->send())
		//	echo "Mailer Error: " . $mail->ErrorInfo;
		//else
		//	echo "Message has been sent successfully";
		
		// return true or false based on execution of send function.
		return $mail->send();
	}
	
	// function to reset password for user using email.
	function resetPassword($user_fullname, $user_username, $user_email, $user_mobile)
	{
		$randomPass = randomStr(8);
		$randomPass_md5 = md5($randomPass);
		
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT usr_id FROM user 
				WHERE usr_name='$user_fullname' 
				AND usr_username='$user_username' 
				AND usr_email='$user_email' 
				AND usr_mobile='$user_mobile'";
				
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		// check if $resultArray is really an array and
		// its size is 1.
		if(!is_array($resultArray) || sizeof($resultArray) != 1)
		{
			echo "Data did not match to any user !";
			die();
		}
		
		// get user primary id >>
		$user_id = $resultArray[0]['usr_id'];
		
		$query = "UPDATE user SET usr_password ='$randomPass_md5' WHERE usr_id = '$user_id'";
		
		$result = mysqli_query($_CONN, $query);
		
		if($result)
		{
			 if(sendEmail($user_email, $randomPass))
				 echo "An email is send to your email id.";
			 else
				 echo "Password is generated but faild to send an email.";
		}
		else
		{
			echo "Failed To reest password, please verify your email !";
		}
	}

	
	// check and run script for request -------
	if(is_array($_POST) 
		&& isset($_POST['user_fullname'])
		&& isset($_POST['user_username'])
		&& isset($_POST['user_email'])
		&& isset($_POST['user_mobile'])
	)
	{
		resetPassword($_POST['user_fullname'], 
					  $_POST['user_username'], 
					  $_POST['user_email'], 
					  $_POST['user_mobile']
					  );
	}

	
?>