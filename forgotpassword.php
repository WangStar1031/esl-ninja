<?php
	require_once('utils/dbmanager.php');
?>
<header>
	<title>ESL Ninja</title>
</header>
<style type="text/css">
	body{ margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Landing{ padding-bottom: 10px; }
	.contents{ width: 50%; min-width: 600px; margin: auto; max-width: 1200px; }
	h1, p, h3{ color: #485aa2; text-align: center; }
	input{ margin: auto; width: 30%; margin-left: 35%; font-size: 1em; }
	.SubmitBtn{ text-align: center; cursor: pointer; background-color: #485aa2; width: 5em; margin: auto;padding: 5px; color: white;}
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>Welcome to ESL Ninja!</h1>
		<p>If you want to get your passowrd,<br> please enter your email in bellow input box and press Enter or Button.</p>
		<br>
		<input type="email" name="email" placeholder="Enter your Email address." id="email">
		<br>
		<br>
		<div class="SubmitBtn" onclick="submitEmail()">Submit</div>
	</div>
</div>
<script src="BoardGame/assets/js/jquery.min.js"></script>
<script type="text/javascript">
	function submitEmail(){
		var strUserMail = document.getElementById("email").value;
		console.log(strUserMail);
		jQuery.ajax({
			type: 'POST',
			url: 'utils/mail.php',
			data: { forgotMail: strUserMail},
			success: function(obj, textstatus){
				console.log(obj);
				if( obj == "YES"){
					alert("We sent your password to your Email.\n Please check your email.");
				} else{
					alert("There is not your account.\n Please signup or verify your code.");
				}
				
			}
		});

	}
</script>