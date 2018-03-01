<header>
	<title>ESL Ninja</title>
</header>
<?php
if(isset($_GET['admin'])){
  $adminName = $_GET['admin'];
?>
<style type="text/css">
	body{ margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Landing{ padding-bottom: 10px; }
	.contents{ width: 50%; min-width: 600px; margin: auto; }
	h1, p, .Games a{ color: #485aa2; text-align: center; }
	h1{ padding: 40 0 40 0; font-size: 3em; }
	.Btns { width: 100%; padding-left: 30%; padding-right: 30%;  text-align: center; color: white ! important; }
	.Btns a{ color: white ! important; }
	.Btns div{ background-color: #485aa2; padding: 10px; font-size: 1.2em; }
	.Btns td { width: 49%; padding: 5px; font-size: 1.1em; }
	a{ text-decoration: none; }
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>Board Game<span style="text-align: right;position: absolute;right: 20px; top:2em; font-size: 0.6em;"><?= $adminName ?>`s Game</span></h1>
		<table class="Btns">
			<tr>
				<td>
					<a href="student.php?admin=<?= $adminName ?>"><div>Student</div></a>
				</td>
				<td>
					<a href="leader.php?admin=<?= $adminName ?>"><div>Leader</div></a>
				</td>
			</tr>
		</table>	
	</div>	
</div>
<?php
} else{
  echo "<h1>You have to get your admin name.</h1>";
}
?>