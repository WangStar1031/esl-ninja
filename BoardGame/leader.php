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
	h1, p, .Games a{ color: #485aa2; text-align: center; }
	h1{ padding: 40 0 40 0; font-size: 3em; }
	.Btns { width: 100%; padding-left: 30%; padding-right: 30%;  text-align: center; color: white ! important; }
	.Btns a{ color: white ! important; }
	.Btns div{ background-color: #485aa2; padding: 10px; font-size: 1.2em; }
	.Btns td { width: 49%; padding: 5px; font-size: 1.1em; }
	a{ text-decoration: none; }
	.Title{ width: 100px; margin: auto; background-color: #4960A4; color: white; padding: 10 20 10 20; border-radius: 1em; font-size: 1.5em; text-align: center; margin-top: 2em; }
	label{ color: #485aa2; font-size: 1.4em;}
	.leftPan, .centerPan, .rightPan{ width: 50%; margin: auto; }
	.rightPan{ text-align: center;}
	.CharacterArea{ border: 2px solid #485aa2; height: 100px; overflow: auto;}
	.ThemeArea, .CardArea{ border: 2px solid #485aa2; height: 130px; overflow: auto;}
	#name, #code{ float: left; font-size: 1.5em; width: 100%; border: 2px solid #485aa2;}
	.TopicContainer{ border: 2px solid #485aa2; height: 150px; background-color: white; padding: 10px;}
	.KindArea{ border: 2px solid #485aa2; padding: 10px;}
	.KindArea table td{ font-size: 1.2em; cursor: pointer;}
	.KindArea table{ margin-left: 20px; }
	.Topics { width: 100%; height: 100%!important; overflow: auto; font-size: 1.5em; border:none!important;}
	.Users { width: 100%; overflow: auto; font-size: 1.5em; border:none!important; }
	.TitleForCode{ background-color: #485aa2; padding: 5 10 5 10; margin: auto; color: white; width: 100%; margin-bottom: 10px; margin-top: 10px;}
	.UserArea{ border: 2px solid #485aa2; padding: 10px; height: 200px; margin-bottom: 10px; }
	input{ color: red; text-align: center; }
	#check{ width: 15px; height: 15px; margin-left: 15px; color: red; background-color: white; font-weight: bold; }
	.BtnPlay{ color: white; background-color: #2D3084; width: 2.5em; text-align: center; margin: auto; margin-top: 20px; border-radius: 10px; }
	.myBtn{ cursor: pointer; color: white; background-color: #485aa2; font-size: 1.5em; padding: 3px;}
	.OKBtn{ float: left; margin-left: 5px; padding-left: 10px; padding-right: 10px;}
	.bgImgs{ width: 90px; height: 60px;}
	.bgImgs, .gbImgs, .playerImgs{ margin: 5 5 5 0; background-size: cover; float: left; }
	.gbImgs{ width: 90px; height: 45px;}
	.playerImgs{ width: 40px; height: 40px;}
	.HideItem{ display: none; }
	.QuestionChk, .ChoiceChk{ border: 1px solid #485aa2; right: 0px;}
	.ImgSelected{ border: 2px solid red; }
	.Users {  }
</style>
<div class="Landing">
	<div class="Header">ESL Ninja<span class="GameTitle">Board Game - Leader Page</span></div>
	<div class="contents">
		<br>
		<div class="row col-lg-12 col-md-12 col-xs-12">
			<div class="col-lg-3 col-md-3"></div>
			<div class="col-lg-6 col-md-6 col-xs-12">
				<img src="./assets/img/logo.png" style="width: 100%;">
			</div>
			<div class="col-lg-3 col-md-3"></div>
		</div>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="leftPan">
				<label>Name</label><br>
				<div class="NameArea">
					<input id="name" type="text" name="name" onkeypress="nameEntered(event)">
					<!-- <div class="myBtn OKBtn" onclick="nameClicked()">OK</div> -->
				</div>
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
				<label>Topic</label>
				<div class="TopicContainer">
					<select class="Topics" multiple="">
						
					</select>
				</div>
				<label>Kind of Board Game</label><br>
				<div class="col-lg-12 col-md-12 col-xs-12 KindArea">
					<table>
						<tr onclick="QuestionClicked()">
							<td>Question Only</td>
							<td class="QuestionChk">X</td>
						</tr>
						<tr onclick="ChoiceClicked()">
							<td>Multiple Choice</td>
							<td class="ChoiceChk"></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="centerPan">
				<br><br><br>
				<label>Background Theme</label><br>
				<div class="col-lg-12 col-md-12 col-xs-12 ThemeArea">
				<?php
					$dir = 'assets/'.$adminName.'/bg-img/';
					$files = scandir($dir);
					$arrRet = array();
					$nNumber = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
				?>
					<div class="bgImgs" style="background-image: url('<?= $dir.$fName ?>')" onclick="bgImgsClicked(<?= $nNumber ?>)">
						<div class="HideItem">X</div>
					</div>
				<?php
							$nNumber++;
						}
					}
				?>
						
				</div>
				<label>Card Design</label><br>
				<div class="col-lg-12 col-md-12 col-xs-12 CardArea">
				<?php
					$dir = 'assets/'.$adminName.'/card-img/';
					$files = scandir($dir);
					$arrRet = array();
					$nNUmber = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
				?>
					<div class="gbImgs" style="background-image: url('<?= $dir.$fName ?>')" onclick="gbImgsClicked(<?= $nNUmber ?>)">
						<div class="HideItem">
							X
						</div>
					</div>
				<?php
						$nNUmber++;
						}
					}
				?>					
				</div>	
			</div>
			<div class="rightPan">
				<div>
					<br><br><br>
					<label class="TitleForCode" onclick="genCode()">Generate code</label>
					<input id="code" type="text" name="code" onkeypress="codeEntered(event)">
				</div>
				<label>Active Users<span id="myName"></span></label><br>
				<div class="col-lg-12 col-md-12 col-xs-12 UserArea">
					<div class="UsersContainer">
						<table class="Users">
							
						</table>
					</div>
				</div>
				<div style="clear: both;"></div>
				<div class="myBtn" onclick="onPlay()">Play</div>
			</div>
		</div>	
	</div>	
</div>

<!-- <script src="assets/js/socket.io-1.2.0.js"></script> -->
<script src="assets/js/socket.io-1.4.5.js"></script>
<script type="text/javascript">
		var socket = io.connect('http://stctravel.herokuapp.com:80');
</script>
<script type="text/javascript">
	var isRequire = false;
	var userName = "";
	var strCode = "";
	var strTopic = "";
	var arrUserInfos = [];
	var arrUsers = [];
	var arrCharacters = [];
	var strTopic = "";
	var isSentMessage = false;
	var finalUsers = [];
	var activeCharacter = 0;
	var adminName =  '<?= $adminName ?>';
	function QuestionClicked(){
		isRequire = false;
		$(".QuestionChk").html("X");
		$(".ChoiceChk").html("");
	}
	function ChoiceClicked(){
		isRequire = true;
		$(".QuestionChk").html("");
		$(".ChoiceChk").html("X");
	}
	$("#code").inputmask({"mask":"9 9 9 - 9 9 9"});
	function nameEntered(event){
		if(event.keyCode == 13){
			nameClicked();
		}
	}
	function nameClicked(){
		// document.getElementById("code").focus();
		userName = document.getElementById("name").value;
		// if( userName == "") return;
		if( arrUsers.indexOf(userName) != -1){
			alert("Duplicated UserName");
			document.getElementById("name").value = "";
			userName = "";
			return;
		}
		document.getElementById("myName").innerHTML = " *" + userName;
	}
	function codeEntered(event){
		if( event.keyCode == 13){
			var code = $("#code").val();
			strCode = code.replace(/(\d)\s(\d)\s(\d)\s-\s(\d)\s(\d)\s(\d)/, "$1$2$3$4$5$6");
		}
		console.log(strCode);
	}
	function RequireClick(){
		isRequire = !isRequire;
		var reqVal = "";
		if( isRequire)
			reqVal = "O";
		else
			reqVal = "X";
		document.getElementById("check").innerHTML = reqVal;
	}
	function refreshTopicList(){
		jQuery.ajax({
			type: 'POST',
			url: 'topicManager.php',
			dataType: 'json',
			data: { getTopics: "getTopics", adminName: adminName},
			success: function(obj, textstatus){
				var strHtml = "";
				for( i = 0; i < obj.length; i++){
					strHtml += "<option>" + obj[i] + "</option>";
				}
				$(".Topics").html(strHtml);
			}
		});
	}
	refreshTopicList();
	$(".Topics p").on("click", function(){
		console.log(this);
	});
	function genCode(){
		userName = document.getElementById("name").value;
		strCode = "";
		for( var i = 0; i < 6; i++){
			var rand = parseInt(Math.random() * 10);
			strCode += rand;
		}
		console.log(strCode);
		$("#code").val(strCode);
	}
	function refreshUserName(){
		$(".Users").html("");
		var strHtml = "";
		for( var i = 0; i < arrUsers.length; i++){
			strHtml += "<option style='background-image=url(assets/"+adminName+"/birds/birds-"+ ( arrCharacters[i] > 10 ? arrCharacters[i] : "0" + arrCharacters[i] ) +".png" +")'>" + arrUsers[i]+"</option>";
		}
		$(".Users").html( strHtml);
	}
	function __insert_user(__user, __charaNum){
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
			__new_user.nChara = parseInt(__charaNum);
			__new_user.live_time = __n;
			arrUserInfos[arrUserInfos.length] = __new_user;
			return true;
		}
		return false;
	}
	function addUser(strUserName, strCharaNum){
		return(__insert_user(strUserName, strCharaNum));
	}
	function __refresh_users(){
		if( isSentMessage == true)return;
		var __d = new Date();
		var __n = __d.getTime();
		arrUsers = [];
		arrCharacters = [];
		for ( i = 0; i < arrUserInfos.length; i++){
			if((__n - arrUserInfos[i].live_time < 4000) && (arrUserInfos[i].name != userName)){
				arrUsers[arrUsers.length] = arrUserInfos[i].name;
				arrCharacters[arrCharacters.length] = arrUserInfos[i].nChara;
			}
		}
		var el = document.getElementsByClassName("Users")[0];
		var strHtml = "";
		for( i = 0; i < arrUsers.length; i++){
			strHtml += '<tr><td><img src="assets/'+adminName+'/birds/birds-' + ( arrCharacters[i] > 10 ? arrCharacters[i] : '0' + arrCharacters[i] ) + '.png' + '"></td><td>' + arrUsers[i] + '</td></tr>';
		}
		console.log( strHtml);
		el.innerHTML = strHtml;
	}
	setInterval(function(){
		// __refresh_users();
		if( isSentMessage == true){
			// var req = "X";
			// if(isRequire)req = "O";
			// 	window.location.href = "online.php?Name=" + userName + "&gameCode="+strCode+"&topic="+strTopic+"&users="+finalUsers+"&req="+req;
		} else{
			__refresh_users();
		}
	}, 5000);
	var nCount = 0;
	setInterval(function(){
		if( isSentMessage == true){
			nCount++;
			if( nCount < 2)return;
			var req = "X";
			if(isRequire)req = "O";
			var charaField = "";
			if( arrCharacters.length != 0)
				charaField = activeCharacter + "," + arrCharacters.join(",");
			else charaField = activeCharacter;
				window.location.href = "online.php?adminName="+adminName+"&Name=" + userName + "&gameCode="+strCode+"&topic="+strTopic+"&users="+finalUsers+"&req="+req+"&chara="+charaField;
		}
	}, 2000);
	socket.on('sentence message', function(msg){
		if(strCode == "")return;
		msgObj = JSON.parse(msg);
		if(msgObj.adminName != adminName) return;
		if( msgObj.type == 'g_init'){
			if( msgObj.gameCode != strCode)return;
			if( addUser(msgObj.Name, msgObj.Character) == true){
				__refresh_users();
				__user_obj = {'type':'g_game_joined', 'gameCode': strCode, 'Name':msgObj.Name, 'adminName': adminName};
				socket.emit('sentence message', JSON.stringify(__user_obj));
			}
		} else if(msgObj.type == 'g_game_play'){
		} else if(msgObj.type == 'g_game_played'){
			if( msgObj.Name != userName){
				var req = "X";
				if(isRequire)req = "O";
				var usersField = "";
				if(arrUsers.length != 0)
					usersField = userName+","+arrUsers.join(',');
				else
					usersField = userName;
				var charaField = "";
				if( arrCharacters.length != 0)
					charaField = activeCharacter + "," + arrCharacters.join(",");
				else charaField = activeCharacter;
				window.location.href = "online.php?adminName="+adminName+"&Name=" + userName + "&gameCode="+strCode+"&topic="+strTopic+"&users="+usersField+"&req="+req+"&chara="+charaField;
			}
		}
	});
	setInterval( function joinGame(){
		if( (userName == "") || (strCode == "")) return;
		__user_obj = {'type':'g_init', 'gameCode': strCode, 'Name':userName, 'adminName':adminName};
		socket.emit('sentence message', JSON.stringify(__user_obj));
	}, 2000);
	function onPlay(){
		if( usersField == ""){
			alert("You have to enter your Name.");
			return;
		}
		var charaField = "";
		if( arrCharacters.length != 0)
			charaField = activeCharacter + "," + arrCharacters.join(",");
		else charaField = activeCharacter;
		if( charaField == ""){
			alert("Please select your Character!");
			return;
		}
		var el = document.getElementsByClassName("Topics")[0];
		console.log(el);
		arrSelUsers = [];
		var options = el && el.options;
		var opt;
		for( var i = 0, iLen = options.length; i<iLen; i++){
			opt = options[i];
			if( opt.selected){
				strTopic = opt.text;
				break;
			}
		}
		console.log(strTopic);
		if( strTopic == ""){
			alert("You have to select a Topic for game.");
			return;
		}
		var req = "X";
		if(isRequire)req = "O";
		var usersField = "";
		if(arrUsers.length != 0)
			usersField = userName+","+arrUsers.join(',');
		else
			usersField = userName;
		finalUsers = usersField;
		__user_obj = {'type':'g_game_play', 'gameCode': strCode, 'Name':userName, 'topic':strTopic,'users': usersField, 'req':req, 'chara':charaField, 'adminName':adminName};
		socket.emit('sentence message', JSON.stringify(__user_obj));
		isSentMessage = true;
		// setTimeout( function(){
		// 	window.location.href = "online.php?Name=" + userName + "&gameCode="+strCode+"&topic="+strTopic+"&users="+usersField+"&req="+req;
		// }, 1000);
	}
	$("#name").focus();
	function playerImgsClicked(nNumber){
		activeCharacter = nNumber+1;
		$(".playerImgs").removeClass("ImgSelected");
		$(".playerImgs").eq(nNumber).addClass("ImgSelected");
	}
	function bgImgsClicked( nNumber){
		$(".bgImgs").removeClass("ImgSelected");
		$(".bgImgs").eq(nNumber).addClass("ImgSelected");
		
	}
	function gbImgsClicked( nNumber){
		$(".gbImgs").removeClass("ImgSelected");
		$(".gbImgs").eq(nNumber).addClass("ImgSelected");
		
	}
</script>
<?php
}else{
  echo "<h1>You have to get your admin name.</h1>";
}
?>