<?php
if( isset($_GET['admin'])){
		?>
<script type="text/javascript">
	console.log('<?= $_GET['admin'] ?>')
</script>
		<?php
		$UserName = $_GET['admin'];
		if( $UserName != ""){
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
	 .Games a{ color: white; text-align: center;}
	 .Games div{ background-color: #485aa2; }
	p, .Games{font-size: 1.1em; }
	.Games{ width: 100%; max-width:600px; margin: auto;}
	.Btns { width: 100%; padding-left: 40%; padding-right: 40%;  text-align: center; color: white ! important; }
	.Btns a{ color: white ! important; }
	.Btns div{ background-color: #485aa2; padding: 10px; font-size: 1.2em; }
	.Games div{ padding: 20 10 20 10; border: 2px solid #ccc;  font-weight: bold;}
	.Games div:hover,.Preview:hover, .LinkMainPage:hover { box-shadow: 2px 2px 3px #aaa; border: 1px solid #485aa2; font-size: 1.05em; }
	.Games td { width: 33%; padding: 5px; }
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
		<h1>EAL Ninja <br> <?= $UserName ?>`s activities</h1>
		<br>
		<table class="Games">
			<tr>
				<td>
					<a target="_blank" href="CardMatchingGame/?admin=<?= $UserName ?>"><div>Card matching<br>(Peer to Peer)</div></a>
				</td>
				<td>
					<a target="_blank" href="BoardGame/?admin=<?= $UserName ?>"><div>Board game<br>(Peer to Peer)</div></a>
				</td>
				<td>
					<a target="_blank" href="RandomQuestion/?admin=<?= $UserName ?>"><div>Random<br>Questions</div></a>
				</td>
			</tr>
			<tr>
				<td>
					<a target="_blank" href="CardMatchingGame/offline.php?admin=<?= $UserName ?>"><div>Card matching<br>(offline 1-2 player)</div></a>
				</td>
				<td>
					<a target="_blank" href="BoardGame/offline.php?admin=<?= $UserName ?>"><div>Board game<br>Short Version</div></a>
				</td>
				<td>
					<a target="_blank" href="RandomImage/?admin=<?= $UserName ?>"><div>Random<br>Images</div></a>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<a target="_blank" href="BoardGame/?admin=<?= $UserName ?>"><div>Board game<br>Long Version</div></a>
				</td>
				<td></td>
			</tr>
		</table>	
	</div>	
</div>
<?php
		}
	} else{
		print_r("Not Session UserName Setted.");
	}
	
?>