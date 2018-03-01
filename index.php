<header>
	<title>ESL Ninja</title>
</header>
<?php
	session_start();
	if(!isset($_SESSION['GameUserName'])){
?>
<script type="text/javascript">
	document.location.href = "login.php";
</script>
<?php
	}
?>
<style type="text/css">
	body{ margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Landing{ padding-bottom: 10px; }
	.contents{ width: 50%; min-width: 600px; margin: auto; }
	h1, p, .Games a{ color: #485aa2; text-align: center; }
	p, .Games{font-size: 1.1em; }
	.Games{ width: 100%; padding-left: 20%; padding-right: 20%; max-width:600px; margin: auto;}
	.Btns { width: 100%; padding-left: 40%; padding-right: 40%;  text-align: center; color: white ! important; }
	.Btns a{ color: white ! important; }
	.Btns div{ background-color: #485aa2; padding: 10px; font-size: 1.2em; }
	.Games div{ padding: 20 10 20 10; border: 2px solid #eee; }
	.Games div:hover { box-shadow: 2px 2px 3px #485aa2; border: 1px solid #485aa2; }
	.Games td { width: 33%; padding: 5px; }
	a{ text-decoration: none; }
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>ESL Ninja</h1>
		<p>Register to become an admin and create custom activities</p>
		<table class="Btns">
			<tr><td>
				<a href="signup.php"><div>Sign up</div></a>
			</td></tr>
			<tr><td>
				<a href="login.php"><div>Login</div></a>
			</td></tr>
		</table>
		<p>Peer to peer online education activities</p>
		<table class="Games">
			<tr>
				<td>
					<a target="_blank" href="CardMatchingGame/?admin=Wang"><div>Matching<br>Game</div></a>
				</td>
				<td>
					<a target="_blank" href="BoardGame/?admin=Wang"><div>Board<br>Game</div></a>
				</td>
				<td>
					<a target="_blank" href="RandomQuestion/?admin=Wang"><div>Random<br>Questions</div></a>
				</td>
			</tr>
		</table>	
	</div>	
</div>