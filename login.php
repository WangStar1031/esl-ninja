<style type="text/css">
	body{ margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Landing{ padding-bottom: 10px; }
	.contents{ width: 50%; min-width: 600px; margin: auto; }
	h1, p, a{ color: #485aa2; text-align: center; }
	form { margin: auto; width: 40%; font-size: 1.2em;}
	form input { width: 100%; margin-top: 10px; margin-bottom: 10px; font-size: 1.2em;}
	#submitBtn{ background-color: #485aa2; border: none; color: white; padding: 5px;}
</style>


<?php
	$isFirst = true;
	require_once('utils/dbmanager.php');
	if(isset($_GET['verifyCode'])){
		$UserName = VerifyUserFromCode($_GET['verifyCode']);
		if( $UserName != ""){
			session_start();
			$_SESSION['GameUserName'] = $UserName;
			echo "<h1 style='text-align:center;'>Welcome to verify ESL Ninja!</h1>";
?>
<script type="text/javascript">
	setTimeout( function(){
		document.location.href = "main.php";
	}, 1000);
	
</script>
<?php
		}else{
?>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>ESL Ninja</h1>
		<br>
		<p>Unfortunately your verify code is invalid.</p>
		<p>Please recheck your code and mailbox.</p>
	</div>
</div>
<?php
		}
?>

<?php
	}else {
	if( isset($_POST['UserName']) && isset($_POST['Password'])){
		$UserName = VerifyUserFromNamePass($_POST['UserName'], $_POST['Password']);
		if( $UserName != ""){
			session_start();
			$_SESSION['GameUserName'] = $UserName;
?>
<script type="text/javascript">
	setTimeout( function(){
		document.location.href = "main.php";
	}, 1000);
</script>
<?php
		} else{
			$isFirst = false;
		}
?>

<?php
	} else{
?>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>ESL Ninja</h1>
<?php
	if( $isFirst == false){
		echo "<p style='color:red;'>Invalid User Information.</p>";
	}
?>		
		<form action="" method="POST">
			<label for="UserName">UserName or User Email</label><br>
			<input type="text" name="UserName" autofocus required><br>
			<label for="Password">Password</label><br>
			<input type="password" name="Password" required><br>
			<input type="submit" name="submit" value="Log in" id="submitBtn">
			<p onclick="document.location.href='signup.php'" style="cursor: pointer;">SignUp</p>
			<p onclick="document.location.href='forgotpassword.php'" style="cursor: pointer;">Forgot Password</p>
		</form>
	</div>
</div>
<!-- Advertisement
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<ins class="adsbygoogle"
style="display:inline-block;width:728px;height:90px;border: 1px solid black;"
data-ad-client="ca-pub-1234567890123456"
data-ad-slot="1234567890"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
 -->
<?php	
	}
}
?>