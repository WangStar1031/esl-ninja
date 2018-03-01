<?php
	require_once('dbmanager.php');

	if(isset($_POST['confirmMail'])){
		$UserName = $_POST['confirmMail'];
		$UserMail = $_POST['eMail'];
		$confirmUrl = $_POST['confirmUrl'];
		$msg = "<!DOCTYPE html><html lang='en'><body><h1>Hello, <span style='font-weight:bolder;'> $UserName! </span></h1><br><br> Thank you for joining ESL Ninja. <br> Please click this Button to verify your email. <br><br> <div style='padding:5px;background-color:#485aa2;width:5em;text-align:center;'><a href='http://esl-ninja.com/Games/login.php?verifyCode=$confirmUrl' style='color:white;'>Click Me</a></div></body></html>";
		// $msg = wordwrap($msg, 70);
		$headers = "From: support@quizninja.com" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		ini_set("SMTP","ssl://smtp-mail.outlook.com");
		ini_set("smtp_port","587");
		if( mail($UserMail, "Welcome to ESL Ninja", $msg, $headers)){
			echo "OK Sent.";
		} else{
			echo "Not Send.";
		}
	}
	if (isset($_POST['forgotMail'])) {
		$UserMail = $_POST['forgotMail'];
		$UserName = getUserNameFromEmail($UserMail);
		$Password = getPasswordFromEmail($UserMail);
		if( $UserName == "" || $Password == ""){
			echo "NO";
		} else{
			$msg = "<!DOCTYPE html><html lang='en'><body><h1>Hello, <span style='font-weight:bolder;'> $UserName! </span></h1><br><br> Welcome to ESL Ninja. <br> Your password is '$Password'. <br>Please enjoy ESL Ninja with your authentication.<br> Thanks.</body></html>";

			$headers = "From: support@quizninja.com" . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			ini_set("SMTP","ssl://smtp-mail.outlook.com");
			ini_set("smtp_port","587");
			if( mail($UserMail, "Welcome to ESL Ninja", $msg, $headers)){
				echo "YES";
			} else{
				echo "NO";
			}
		
		}
	}
//auth_username=wangstar1031@hotmail.com
//auth_password=123guraud!
?>
