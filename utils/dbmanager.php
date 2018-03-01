<?php
	function getConnection(){
		$DBservername = 'localhost';
		
		// $DBusername = 'root';
		// $DBpassword = '';
		// $DBname = 'eslninja';
		
		$DBusername = 'earthso6_wang';
		$DBpassword = '123guraud!';
		$DBname = 'earthso6_eslninja';
		
		$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
		return $conn;
	}
	function RegisterUser( $name, $eMail, $pass){
		$conn = getConnection();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return;
		}
		$sql = "SELECT Id FROM users WHERE UserName='".$name."' OR UserMail='".$eMail."';";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			// echo "<h4 style='color:red;'>Already exist UserName!</h4>";
			return "0"; // Existing User
		}
		$VerifyCode = crypt($name.$pass,'');
		$sql = "INSERT INTO users(UserName, UserMail, Password, VerifyCode, VerifyStates) VALUES('$name','$eMail', '$pass','$VerifyCode', 'No')";
		if( $conn->query($sql) === TRUE){
			return $VerifyCode;
			// header("Location: index.php");
		}
		$conn->close();
		return "1";
	}
	function VerifyUserFromCode($verifyCode){
		$conn = getConnection();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return;
		}
		$sql = "SELECT UserName FROM users WHERE VerifyCode='$verifyCode' AND VerifyStates='No';";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = $result->fetch_assoc();
			$UserName = $row['UserName'];
			$sql = "UPDATE users SET VerifyStates='Yes' WHERE VerifyCode='$verifyCode'";
			$conn->query($sql);
			return $UserName;
		}
		return "";
	}
	function VerifyUserFromNamePass($name, $pass){
		$conn = getConnection();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return;
		}
		$sql = "SELECT UserName FROM users WHERE (UserName='$name' OR UserMail='$name') AND Password='$pass' AND VerifyStates='Yes';";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = $result->fetch_assoc();
			$UserName = $row['UserName'];
			return $UserName;
		}
		return "";
	}
	function getUserNameFromEmail($mail){
		$conn = getConnection();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return "";
		}
		$sql = "SELECT UserName FROM users WHERE UserMail='$mail' AND VerifyStates='Yes';";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = $result->fetch_assoc();
			$UserName = $row['UserName'];
			return $UserName;
		}
		return "";
	}
	function getPasswordFromEmail($mail){
		$conn = getConnection();
		if( $conn->connect_error){
			echo("Connection failed: " . $conn->connect_error);
			return "";
		}
		$sql = "SELECT Password FROM users WHERE UserMail='$mail' AND VerifyStates='Yes';";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = $result->fetch_assoc();
			$Password = $row['Password'];
			return $Password;
		}
		return "";
	}
?>