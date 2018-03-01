<header>
	<title>ESL Ninja</title>
</header>
<style type="text/css">
	body{ margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Landing{ padding-bottom: 10px; }
	.contents{ width: 50%; min-width: 600px; margin: auto; }
	h1, p{ color: #485aa2; text-align: center; }
</style>
<?php
	require_once('utils/dbmanager.php');
	$registerStates = "";
	if( isset($_POST['UserName']) && isset($_POST['Email']) && isset($_POST['Password'])){
		$UserName = $_POST['UserName'];
		$Email = $_POST['Email'];
		$Password = $_POST['Password'];
		$registerStates = RegisterUser( $UserName, $Email, $Password);
	}
	if( $registerStates == "0" || $registerStates == "1" || $registerStates == ""){
		if($registerStates == "0"){
			echo "<h1>Existing UserName or Email.";
		}
		if($registerStates == "1"){
			echo "<h1>Cannot Register.";
		}
?>
<style type="text/css">
	form { margin: auto; width: 40%; font-size: 1.2em;}
	form input { width: 100%; margin-top: 10px; margin-bottom: 10px; font-size: 1.2em;}
	#submitBtn{ background-color: #485aa2; border: none; color: white; padding: 5px;}
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>ESL Ninja</h1>
		<form action="" method="POST">
			<label for="UserName">UserName</label><br>
			<input type="text" name="UserName" autofocus required><br>
			<label for="">Email</label><br>
			<input type="email" name="Email" required><br>
			<label for="Password">Password</label><br>
			<input type="password" name="Password" required><br>
			<input type="submit" name="submit" value="Sign Up" id="submitBtn">
			<p onclick="document.location.href='login.php'" style="cursor: pointer;">Login</p>
		</form>
	</div>
</div>
<?php
	}
	else{
?>
<style type="text/css">
	.contents{ text-align: center; }
	#ConfirmBtn{ width: 4em; margin: auto; text-align: center; background-color: #485aa2; border: none; color: white; padding: 5px; cursor: pointer;}
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>ESL Ninja</h1>
		Thank you for joing ESL Ninja.<br> Please click the button and confirm your email.
		<div id="ConfirmBtn" onclick="onConfirm()">Confirm</div>
	</div>
</div>
<script src="BoardGame/assets/js/jquery.min.js"></script>
<script type="text/javascript">
	function onConfirm(){
		var strConfirmUrl = "<?= $registerStates ?>";
		console.log(strConfirmUrl);
		var strUserName = "<?= $UserName ?>";
		console.log(strUserName);
		var strUserMail = "<?= $Email ?>";
		console.log(strUserMail);
		jQuery.ajax({
			type: 'POST',
			url: 'utils/mail.php',
			data: { confirmMail: strUserName, eMail: strUserMail, confirmUrl: strConfirmUrl},
			success: function(obj, textstatus){
				console.log(obj);
				alert("Verify Email sent.");
			}
		});
	}
</script>
<?php
	}
?>