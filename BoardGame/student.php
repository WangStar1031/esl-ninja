<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="assets/js/jquery.min.js"></script>
<script src='assets/js/jquery.inputmask.bundle.js'></script>
<header>
	<title>ESL Ninja</title>
</header>
<?php
if( isset($_GET['admin'])){
	$adminName = $_GET['admin'];
?>
<style type="text/css">
	body{ color: #485aa2; margin: 0px; }
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	.Header .GameTitle{ text-align: center; position: absolute; width: 100%; left: 0px;}
	.Landing{ padding-bottom: 10px; position: relative; }
	.contents{ width: 50%; min-width: 680px; margin: auto; }
	.Btns { width: 100%; padding-left: 30%; padding-right: 30%;  text-align: center; color: white ! important; }
	.Btns a{ color: white ! important; }
	.Btns div{ background-color: #485aa2; padding: 10px; font-size: 1.2em; }
	.Btns td { width: 49%; padding: 5px; font-size: 1.1em; }
	a{ text-decoration: none; }
	.Title{ width: 100px; margin: auto; background-color: #4960A4; color: white; padding: 10 20 10 20; border-radius: 1em; font-size: 1.5em; text-align: center; margin-top: 2em; }
	label{ color: #485aa2; font-size: 1.4em;}
	.leftPan, .centerPan, .rightPan{ padding: 5px; float: left;}
	.leftPan{ width: 32%; }
	.centerPan{ width: 40%; }
	.rightPan{ width: 28%;  padding: 10px; text-align: center;}
	.CharacterArea{ border: 2px solid #485aa2; height: 100px; overflow: auto;}
	.ThemeArea, .CardArea{ border: 2px solid #485aa2; height: 130px; overflow: auto;}
	#name, #code{ float: left; font-size: 1.5em; width: 100%; border: 2px solid #485aa2;}
	input{ color: red; text-align: center; }
	.myBtn{ cursor: pointer; color: white; background-color: #485aa2; font-size: 1.5em; padding: 3px; text-align: center; margin-top: 10px;margin-bottom: 10px;}
	.bgImgs{ width: 90px; height: 60px;}
	.bgImgs, .gbImgs, .playerImgs{ margin: 5 5 5 0; background-size: cover; float: left; }
	.gbImgs{ width: 90px; height: 45px;}
	.playerImgs{ width: 40px; height: 40px;}
	.HideItem{ display: none; }
	.ImgSelected{ border: 2px solid red; }
</style>
<div class="Landing">
	<div class="Header">ESL Ninja<span class="GameTitle">Board Game - Student Page</span></div>
	<div class="contents">
		<br>
		<div class="row col-lg-12 col-md-12 col-xs-12">
			<div class="col-lg-3 col-md-3"></div>
			<div class="col-lg-6 col-md-6 col-xs-12">
				<img src="./assets/img/logo.png" style="width: 100%;">
			</div>
			<div class="col-lg-3 col-md-3"></div>
		</div>
		<div class="row col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
			<div class="col-lg-4 col-md-4 col-xs-12"></div>
			<div class="col-lg-4 col-md-4 col-xs-12">
				<label>Name</label>
				<input id="name" type="text" name="name" onkeypress="nameEntered(event)"><br>
				<label>Character</label><br>
				<div class="col-lg-12 col-md-12 col-xs-12 CharacterArea">
				<?php
					$dir = 'assets/'.$adminName.'/birds/';
					$files = scandir($dir);
					$arrRet = array();
					$nNumber = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
				?>
					<div class="playerImgs" style="background-image: url('<?= $dir.$fName ?>')" onclick="playerImgsClicked(<?= $nNumber ?>)">
						<div class="HideItem">X</div>
					</div>
				<?php
							$nNumber++;
						}
					}
				?>					
				</div>
				<input id="code" type="text" name="code" onkeypress="codeEntered(event)" style="margin-top: 15px;">
				<div style="clear: both;"></div>
				<div onclick="onJoin()" id="btnJoin" class="myBtn">Join</div>
			</div>
			<div class="col-lg-4 col-md-4 col-xs-12"></div>
		</div>	
	</div>	
</div>
<style type="text/css">
	.StudentLanding{
		width: 215px;
		margin: auto;
	}
	.StudentLanding p{
		background-color: #BA774A;
		color: white;
		padding: 10 20 10 20;
		border-radius: 1em;
		font-size: 1.5em;
		margin: 2em;
		text-align: center;
		margin-bottom: 1em; 
	}
	.StudentInfo{
		background-color: #647DB8;
		padding: 20px;
		border-radius: 20px;
	}
	.button{
		float: left;
		margin: auto !important;
		padding: 5px !important;
		margin-left: 0.3em !important;
	}
</style>

<!-- <script src="assets/js/socket.io-1.2.0.js"></script> -->
<script src="assets/js/socket.io-1.4.5.js"></script>
<script type="text/javascript">
		var socket = io.connect('http://stctravel.herokuapp.com:80');
</script>
<script type="text/javascript">
	$("#code").inputmask({"mask":"9 9 9 - 9 9 9"});
	var strName = "";
	var strCode = "";
	var isJoined = false;
	var arrUserInfos = [];
	var arrUsers = [];
	var activeNumber = -1;
	var adminName = '<?= $adminName ?>';
	function nameEntered(event){
		if(event.keyCode == 13){
			nameClicked();
		}
	}
	function nameClicked(){
		strName = document.getElementById("name").value;
		if( arrUsers.indexOf(strName) != -1){
			alert("Duplicated Name.");
			strName = document.getElementById("name").value = "";

		}
		document.getElementById("code").focus();
	}
	function onJoin(){
		nameClicked();
		code = $("#code").val();
		strCode = code.replace(/(\d)\s(\d)\s(\d)\s-\s(\d)\s(\d)\s(\d)/, "$1$2$3$4$5$6");
	}
	function codeEntered(event){
		if( event.keyCode == 13){
			onJoin();
		}
	}
	function __insert_user(__user){
		var __d = new Date();
		var __n = __d.getTime();
		__user_index = -1;
		for(i=0; i<arrUserInfos.length; i++){
			if(arrUserInfos[i].name == __user){
			__user_index = i;
			arrUserInfos[i].live_time = __n;
			break;
			}
		}
		if(__user_index == -1){
			__new_user = {};
			__new_user.name = __user;
			__new_user.live_time = __n;
			arrUserInfos[arrUserInfos.length] = __new_user;
			return true;
		}
		return false;
	}
	function __refresh_users(){
		var __d = new Date();
		var __n = __d.getTime();
		arrUsers = [];
		for ( i = 0; i < arrUserInfos.length; i++){
			if((__n - arrUserInfos[i].live_time < 4000) && (arrUserInfos[i].name != strName)){
				arrUsers[arrUsers.length] = arrUserInfos[i].name;
			}
		}
	}
	setInterval(function(){
		__refresh_users();
	}, 5000);
	function addUser(strUserName){
		if( strUserName == strName) return;
		return(__insert_user(strUserName));
	}
	setInterval( function joinGame(){
		if( (strName == "") || (strCode == "")) return;
		if( activeNumber == 0 ){
			alert("Please select Character!");
			return;
		}
		__user_obj = {'type':'g_init', 'gameCode': strCode, 'Name':strName, 'Character' : activeNumber, 'adminName':adminName};
		socket.emit('sentence message', JSON.stringify(__user_obj));
	}, 2000);
	socket.on('sentence message', function(msg){
		msgObj = JSON.parse(msg);
		if( msgObj.adminName != adminName) return;
		// console.log(msgObj);
		if( msgObj.type == 'g_game_joined'){
			if( msgObj.Name == strName){
				console.log("Successful Joined!");
			}
		} else if(msgObj.type == 'g_game_play'){
			if( msgObj.gameCode != strCode)return;
			var arrUserNames = [];
			arrUserNames = msgObj.users.split(',');
			if( arrUserNames.indexOf(strName) == -1){
				alert("You are denied.");
				return;
			}
			// __user_obj = {'type':'g_game_played', 'gameCode': strCode, 'Name':strName};
			// socket.emit('sentence message', JSON.stringify(__user_obj));

			window.location.href = "online.php?adminName="+adminName+"&Name=" + strName + "&gameCode="+strCode+"&topic="+msgObj.topic+"&users="+msgObj.users+"&req="+msgObj.req+"&chara="+msgObj.chara;
		} else if( msgObj.type == 'g_init'){
			if( msgObj.gameCode != strCode)return;
			if( addUser(msgObj.Name) == true){
				__user_obj = {'type':'g_game_joined', 'gameCode': strCode, 'Name':msgObj.Name, 'adminName':adminName};
				socket.emit('sentence message', JSON.stringify(__user_obj));
			}
		}
	});
	function playerImgsClicked(nNumber){
		activeNumber = nNumber+1;
		$(".playerImgs").removeClass("ImgSelected");
		$(".playerImgs").eq(nNumber).addClass("ImgSelected");
	}
</script>
<?php
} else{
	echo "<h1>You have to get your admin name.</h1>";
}
?>