<?php
	session_start();
	ini_set('display_errors', 'on');
	error_reporting(E_ALL);
	// print_r($_SESSION);
	// print_r(isset($_SESSION['GameUserName']));
	// print_r($_SESSION['GameUserName']);
	// print_r("expression");
	if( isset($_SESSION['GameUserName'])){
		?>
<script type="text/javascript">
	console.log('<?= $_SESSION['GameUserName'] ?>')
</script>
		<?php
		$UserName = $_SESSION['GameUserName'];
		if( $UserName != ""){
?>
<header>
	<title>ESL Ninja</title>
</header>
<style type="text/css">
	body{ margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Landing{ padding-bottom: 10px; }
	.contents{ width: 60%; min-width: 800px; margin: auto; max-width: 1200px; }
	h1, p, h3{ color: #485aa2; text-align: center; }
	 .Games a{ color: white; text-align: center;}
	 .Games div{ background-color: #485aa2; }
	p, .Games{font-size: 1.1em; }
	.Games{ width: 100%; max-width:800px; margin: auto;}
	.Btns { width: 100%; padding-left: 40%; padding-right: 40%;  text-align: center; color: white ! important; }
	.Btns a{ color: white ! important; }
	.Btns div{ background-color: #485aa2; padding: 10px; font-size: 1.2em; }
	.Games div{ padding: 20 10 20 10; border: 2px solid #ccc;  font-weight: bold;}
	.Games div:hover,.Preview:hover, .LinkMainPage:hover { box-shadow: 2px 2px 3px #aaa; border: 1px solid #485aa2; font-size: 1.05em; }
	.Games td { width: 25%; padding: 5px; }
	a{ text-decoration: none; }
	td p{ font-size: 0.8em;  }
	.url{ font-size: 0.7em; border: 1px solid #485aa2; padding: 3px; cursor: pointer; width: 100%; height: 100%; color: #485aa2;}
	.Preview { border: 2px solid #ccc; text-align: center;color: white; background-color: #485aa2; width: 100%; padding: 5 0 5 0; display: inline-block;}
	.LinkMainPage{ border: 2px solid #ccc; margin-top: 40px; background-color: #485aa2; color: white; text-align: center; cursor: pointer; display: inline-table; width: 100%; padding: 8 0 8 0;}
	/*.Preview:hover, .LinkMainPage:hover{ font-size: 1.05em; }*/
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>Welcome!</h1>
		<h3><?= $UserName ?></h3>
		<p>Here you can create various speaking activities</p>
		<br>
		<table class="Games">
			<tr>
				<td>
					<a target="_blank" href="CardMatchingGame/admin.php"><div>Make a card matching game</div></a>
<!-- 					<a target="_blank" href="CardMatchingGame/admin.php"><div>Make a card matching game</div></a>
 -->				</td>
				<td>
					<a target="_blank" href="BoardGame/admin.php"><div>Make a<br>board game</div></a>
<!-- 					<a target="_blank" href="BoardGame/admin.php"><div>Make a<br>board game</div></a>
 -->				</td>
				<td>
					<a target="_blank" href="RandomQuestion/admin.php"><div>Make a Random Question generator</div></a>
				</td>
				<td>
					<a target="_blank" href="RandomImage/admin.php"><div>Make a Random Image generator</div></a>
				</td>
			</tr>
			<tr>
				<td><p>Your URL for your students<br>Click to copy url</p></td>
				<td><p>Your URL for your students<br>Click to copy url</p></td>
				<td><p>Your URL for your students<br>Click to copy url</p></td>
				<td><p>Your URL for your students<br>Click to copy url</p></td>
			</tr>
			<tr>
				<td>
					<input class="url" type="text" id="copyBtn1" name="" readonly value="http://esl-ninja.com/Games/CardMatchingGame/?admin=<?= $UserName ?>" onclick="copyBtnClicked(0)">
				</td>
				<td>
					<input class="url" type="text" id="copyBtn1" name="" readonly value="http://esl-ninja.com/Games/BoardGame/?admin=<?= $UserName ?>" onclick="copyBtnClicked(1)">
				</td>
				<td>
					<input class="url" type="text" id="copyBtn1" name="" readonly value="http://esl-ninja.com/Games/RandomQuestion/?admin=<?= $UserName ?>" onclick="copyBtnClicked(2)">
				</td>
				<td>
					<input class="url" type="text" id="copyBtn1" name="" readonly value="http://esl-ninja.com/Games/RandomImage/?admin=<?= $UserName ?>" onclick="copyBtnClicked(2)">
				</td>
			</tr>
			<tr>
				<td>
					<a target="_blank" class="Preview" href="http://esl-ninja.com/Games/CardMatchingGame/?admin=<?= $UserName ?>">Preview</a>
				</td>
				<td>
					<a target="_blank" class="Preview" href="http://esl-ninja.com/Games/BoardGame/?admin=<?= $UserName ?>">Preview</a>
				</td>
				<td>
					<a target="_blank" class="Preview" href="http://esl-ninja.com/Games/RandomQuestion/?admin=<?= $UserName ?>">Preview</a>
				</td>
				<td>
					<a target="_blank" class="Preview" href="http://esl-ninja.com/Games/RandomImage/?admin=<?= $UserName ?>">Preview</a>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2"><a class="LinkMainPage" target="_blank" href="allactivity.php?admin=<?= $UserName ?>">Link to your <br> all activity page</a></td>
				<td></td>
			</tr>
		</table>	
	</div>	
</div>
<script type="text/javascript">
	function copyBtnClicked(nNumber){
		var elem = document.getElementsByClassName("url")[nNumber];
		elem.select();
		document.execCommand("copy");
	}
</script>
<?php
		}
	} else{
		print_r("Not Session UserName Setted.");
	}
	
?>