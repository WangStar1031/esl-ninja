var arrAllAnswers = [];
var isHasAnswer = false;
if( isReq == "X") isHasAnswer = false;
var isConfirmAnswer = false;
var curQuestionNum = -1;
function getAnswers(strTopic){
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		dataType: 'json',
		data: { getAnswers: strTopic, adminName: adminName},
		success: function(obj, textstatus){
			console.log(obj.allAnswers);
			arrAllAnswers = [];
			arrAllAnswers = obj.allAnswers;
		}
	});
}

function setContentsToCards(strTopic, arrQuestions){
	if( strTopic == "")return;
	$("#topicList > option").filter(function(){
		return $(this).html() === strTopic;
	}).prop('selected', true);
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		data: { getContents: strTopic, adminName: adminName},
		success: function(obj, textstatus){
			var arrRet = obj.split("\n");
			var strHtml = "";
			for( i = 0; i < arrRet.length; i++){
				if(arrRet[i] == "")
					continue;
				arrContents.push(arrRet[i]);
			}
			if( !isMaster)return;
			if(arrQuestions.length != 0){
				arrQuestionNumbers = arrQuestions;
			} else{
				if ( arrContents.length < nAllCardCount) {
					for( ii = 1; ii < nAllCardCount; ii++){
						var ran = Math.floor(Math.random()*arrContents.length);
						arrQuestionNumbers.push(ran);
					}
				} else{
					while( arrQuestionNumbers.length < nAllCardCount){
						var ran = Math.floor(Math.random()*arrContents.length);
						if( arrQuestionNumbers.indexOf(ran) == -1){
							arrQuestionNumbers.push(ran);
						}
					}
				}
			}
			setTimeout(function(){
				__user_obj = {'type':'g_card_contents','adminName':adminName, 'gameCode': gameCode, 'masterName':userName, 'cardContents':arrQuestionNumbers.join(",")};
				socket.emit('sentence message', JSON.stringify(__user_obj));
			}, 500);
	
			for( i = 1; i < nAllCardCount; i++){
				$("#cardContainer"+i).find(".questionTxt").html(arrContents[arrQuestionNumbers[i-1]]);
			}
		}
	});
}
function setBackgroundImg(nImgNo){
	$(".game_container").css('background-image', 'url("assets/img/bg-img/background-0' + nImgNo + '.png")');
}
setContentsToCards(g_topicName, arrQuestionNumbers);
getAnswers( g_topicName);

$(".dice_Btn").on("click", function(){	//NEXT button
	var nCurUserNumber = arrPlayerNames.indexOf(userName);
	if( arrCurStep[nCurUserNumber] == 59){
		sendNextTurnMsg("");
		return;
	}
	// if( arrCurStep[])
	if( $("#myAnswer").val() == "" && document.getElementById("myAnswer").disabled == false){
		alert("Please enter the answer.");
		return;
	}
	if( isHasAnswer && !isConfirmAnswer){
		alert("Please select answer and press confirm");
		return;
	}
	isConfirmAnswer = false;
	var _answer = $("#myAnswer").val();
	$("#myAnswer").val("");
	$(".flip-container").removeClass("hover");
	sendNextTurnMsg(_answer);
});
function sendNextTurnMsg(_answer){
	if( gameState == false)	{
		var strHtml = '<p>A:' + _answer +'</p>';
		$(".answerList").append(strHtml);
		isCanPlay = true;
		return;
	}
	nCurrentUserNumber ++;
	nCurrentUserNumber %= nAllUserCount;
	setUserTurn( arrPlayerNames[nCurrentUserNumber], _answer);
}
function getUserPanelStep(userStep){
	if( userStep < 16) return 1;
	if( userStep < 19 + 16) return 2;
	if( userStep < 19 + 16 + 13) return 3;
	return 4;
}
function setProgress(){
	for( var i = 0; i < nAllUserCount; i++){
		var car_pro = $("#player_prog"+(i+1));
		if( arrCurStep[i] == -1) continue;
		var tblElem = $("#barCell" + [arrCurStep[i]]);
		var curStep = arrCurStep[i];
		var eqCount = 1;
		for( var j = 0; j < i; j++){
			if( arrCurStep[j] == curStep){
				eqCount ++;
			}
		}
		var nleft = tblElem.position().left - 25;
		var ntop = tblElem.position().top - eqCount * 50;
		car_pro.css({top:ntop, left:nleft, position:'absolute'});
	}
}
function gotoOtherStep(carName, number){
	var nCurUserNumber = arrPlayerNames.indexOf(carName);
	if(arrCurStep[nCurUserNumber] >= nAllCardCount+1)
		return;
	var prevStep = arrCurStep[nCurUserNumber];
	arrCurStep[nCurUserNumber] += number;
	if(arrCurStep[nCurUserNumber] >= nAllCardCount){
		arrCurStep[nCurUserNumber] = nAllCardCount;
		$(".ani-gif").removeClass("HideItem");
		$(".ani-gif").addClass("ShowItem");
		setTimeout(function(){
			$(".ani-gif").removeClass("ShowItem");
			$(".ani-gif").addClass("HideItem");
		}, 5000);
		var audio = $("audio")[1];
		try{
			audio.pause();
			audio.currentTime = 0;
			audio.play();
		} catch(e){
			console.log(e);
		}
	}
	for( i = 0; i < nAllUserCount; i++){
		if( getUserPanelStep(arrCurStep[myNumber]) != getUserPanelStep(arrCurStep[i])){
			arrCars[i].removeClass("ShowItem");
			arrCars[i].addClass("HideItem");
		} else {
			arrCars[i].removeClass("HideItem");
			arrCars[i].addClass("ShowItem");
		}
	}
	var car = arrCars[nCurUserNumber];
	if( arrCurStep[nCurUserNumber] != 0 && arrCurStep[nCurUserNumber]!= nAllCardCount && number != -1){
		var curCardElem = $("#cardContainer"+arrCurStep[nCurUserNumber]);
		curCardElem.toggleClass('hover');	
	}
	var carPos = calcCarPosition(nCurUserNumber, arrCurStep[nCurUserNumber], true);
	var nleft = carPos.left;
	var ntop = carPos.top;
	car.css({top:ntop, left:nleft, position:'absolute'});
	// if(number == 0)return;
	for( i = 0; i < nAllUserCount; i++){
		if( (arrCurStep[i] == prevStep) && (arrCurStep[i] < nAllCardCount+1)){
		// if( (arrCurStep[i] == prevStep) && (arrCurStep[i] < nAllCardCount+1)){
			car = arrCars[i];
			arrCarPosInCard[i]--;
			carPos = calcCarPosition(i, arrCurStep[i], false);
			car.css({top:carPos.top, left:carPos.left, position:'absolute'});
		} else{
			car = arrCars[i];
			// arrCarPosInCard[i]--;
			carPos = calcCarPosition(i, arrCurStep[i], false);
			car.css({top:carPos.top, left:carPos.left, position:'absolute'});
		}
	}
	setProgress();
	return arrCurStep[nCurUserNumber];
}
function gotoStep(carName, number){
	isCanPlay = false;
	if(nAllUserCount == 0) return;
	nCurrentUserNumber = arrPlayerNames.indexOf(carName);
	if(arrCurStep[nCurrentUserNumber] >= nAllCardCount+1)
		return;
	var prevStep = arrCurStep[nCurrentUserNumber];
	arrCurStep[nCurrentUserNumber] += number;
	if( carName == userName){
		$("#boardPanel0").removeClass("DisplayBlock").addClass("DisplayNone");
		$("#boardPanel1").removeClass("DisplayBlock").addClass("DisplayNone");
		$("#boardPanel2").removeClass("DisplayBlock").addClass("DisplayNone");
		$("#boardPanel3").removeClass("DisplayBlock").addClass("DisplayNone");
		if( arrCurStep[nCurrentUserNumber] < 16){
			$("#boardPanel0").removeClass("DisplayNone").addClass("DisplayBlock");
		} else if( arrCurStep[nCurrentUserNumber] < 19+16){
			$("#boardPanel1").removeClass("DisplayNone").addClass("DisplayBlock");
		} else if( arrCurStep[nCurrentUserNumber] < 19+16+13){
			$("#boardPanel2").removeClass("DisplayNone").addClass("DisplayBlock");
		} else {
			$("#boardPanel3").removeClass("DisplayNone").addClass("DisplayBlock");
		}
		setBackgroundImg( getUserPanelStep(arrCurStep[nCurrentUserNumber]));
	}
	if(arrCurStep[nCurrentUserNumber] >= nAllCardCount){
		arrCurStep[nCurrentUserNumber] = nAllCardCount;
		$(".ani-gif").removeClass("HideItem");
		$(".ani-gif").addClass("ShowItem");
		setTimeout(function(){
			$(".ani-gif").removeClass("ShowItem");
			$(".ani-gif").addClass("HideItem");
		}, 5000);
		var audio = $("audio")[1];
		try{
			audio.pause();
			audio.currentTime = 0;
			audio.play();
		} catch(e){
			console.log(e);
		}
	}
	for( i = 0; i < nAllUserCount; i++){
		if( getUserPanelStep(arrCurStep[myNumber]) != getUserPanelStep(arrCurStep[i])){
			arrCars[i].removeClass("ShowItem");
			arrCars[i].addClass("HideItem");
		} else {
			arrCars[i].removeClass("HideItem");
			arrCars[i].addClass("ShowItem");
		}
	}
	var car = arrCars[nCurrentUserNumber];
	if( arrCurStep[nCurrentUserNumber] != 0 && arrCurStep[nCurrentUserNumber]!= nAllCardCount && number != -1 && number != 1){
		var curCardElem = $("#cardContainer"+arrCurStep[nCurrentUserNumber]);
		curCardElem.toggleClass('hover');	
	}
	var carPos = calcCarPosition(nCurrentUserNumber, arrCurStep[nCurrentUserNumber], true);
	var nleft = carPos.left;
	var ntop = carPos.top;
	car.css({top:ntop, left:nleft, position:'absolute'});
	// if(number == 0)return;
	for( i = 0; i < nAllUserCount; i++){
		if( (arrCurStep[i] == prevStep) && (arrCurStep[i] < nAllCardCount+1)){
		// if( (arrCurStep[i] == prevStep) && (arrCurStep[i] < nAllCardCount+1)){
			car = arrCars[i];
			arrCarPosInCard[i]--;
			carPos = calcCarPosition(i, arrCurStep[i], false);
			car.css({top:carPos.top, left:carPos.left, position:'absolute'});
		} else{
			car = arrCars[i];
			// arrCarPosInCard[i]--;
			carPos = calcCarPosition(i, arrCurStep[i], false);
			car.css({top:carPos.top, left:carPos.left, position:'absolute'});
		}
	}
	setProgress();
	return arrCurStep[nCurrentUserNumber];
}
for( var _i = 0; _i < nAllUserCount; _i ++){
	gotoStep(arrPlayerNames[_i], 1);
}
isCanPlay = (arrPlayerNames[0] == userName) ? true : false;
function refreshAnswers(nQNumber){
	$("#answerTable").html("");
	if( typeof arrAllAnswers[nQNumber] == undefined || typeof arrAllAnswers[nQNumber] == 'undefined' || typeof arrAllAnswers[nQNumber].answerVal == undefined || typeof arrAllAnswers[nQNumber].answerVal == 'undefined'){
		console.log("undefined:" + nQNumber);
		isHasAnswer = false;
		$("#answerTable").html("undefined answer")
		return;
	}
	isHasAnswer = true;
	if( isReq == "X") isHasAnswer = false;
	for(var i = 0; i < arrAllAnswers[nQNumber].answerVal.length; i++){
		var answer = arrAllAnswers[nQNumber].answerVal[i];
		addAnswer();
		$("#answerTable tr").eq(i).find(".answerText").val(answer.answer);
	}
}
function chkClick( nNumber){
	$("#answerTable tr .chkArea").removeClass("chk");
	$("#answerTable tr").eq(nNumber).find(".chkArea").addClass("chk");
}
function addAnswer(){
	var nAnswerCount = $("#answerTable tr").length;
	var strHtml = "";
	strHtml += "<tr>";
	strHtml += "<td><div class='chkArea' onclick='chkClick("+nAnswerCount+")'></div></td>";
	strHtml += "<td><input type='text' class='answerText' readonly></td>";
	strHtml += "</tr>";
	$("#answerTable").append(strHtml);
}
function createTable(curQuestionNum){
	console.log("curQuestionNum : " + curQuestionNum);
	refreshAnswers(curQuestionNum);
}
function rolledDice(number1, number2){
	var stepNumber = gotoStep(userName, number1 + number2);
	curQuestionNum = arrQuestionNumbers[stepNumber-1] * 1;
	createTable( curQuestionNum);
	console.log("Rolled Number : "+stepNumber);
	var question = $("#cardContainer"+stepNumber).find(".questionTxt").html();
	var strHtml = '<p>Q:' + question +'</p>';
	$(".answerList").append(strHtml);
	sendMyDiceNumber(number1, number2);
}
function rolledDiceNameNumber(_name, number1, number2){
	console.log(_name + ":" + number1 + ":" + number2);
	nCurrentUserNumber++;
	nCurrentUserNumber %= nCurPlayingCount;
	var stepNumber = gotoStep(_name, number1 + number2);
	curQuestionNum = arrQuestionNumbers[stepNumber-1] * 1;
	createTable( curQuestionNum);
	var question = $("#cardContainer"+stepNumber).find(".questionTxt").html();
	var strHtml = '<p >' + question +'</p>';
	$(".answerList").append(strHtml);
}
function calcCarPosition( nCurrentUser, nCardNumber, isNew){
	if( nCardNumber < 0) return {left:0,top:0};
	var nleft;
	var ntop;
	var samePosCount = -1;
	for ( i = 0; i < nAllUserCount; i++){
		if(arrCurStep[i] == nCardNumber){
			samePosCount++;
		}
	}
	if( isNew)
		arrCarPosInCard[nCurrentUser] = samePosCount;
	var cardElem = $("#cardContainer"+nCardNumber);
	var position = cardElem.position();
	console.log(nCardNumber);
	nleft = position.left;// - 500;
	ntop = position.top;

	col = cardElem.parent().parent().children().index(cardElem.parent());
	if( col == 0){
		nleft -= 60;
		ntop += 50 * parseInt( arrCarPosInCard[nCurrentUser] / 2);
		nleft -= 50 * parseInt(arrCarPosInCard[nCurrentUser] % 2);
	} else if( col == 6){
		nleft += 150;
		ntop += 50 * parseInt( arrCarPosInCard[nCurrentUser] / 2);
		nleft += 50 * parseInt(arrCarPosInCard[nCurrentUser] % 2);
	} else {
		ntop -= 50;
		ntop += 50 * parseInt( arrCarPosInCard[nCurrentUser] / 2);
		nleft += 50 * parseInt(arrCarPosInCard[nCurrentUser] % 2);
	} 
	return {left:nleft, top:ntop};
}
function fillImageCards(){
	for ( i =  0; i < nAllCardCount+1; i++){
		$("#cardContainer"+i).find(".front").css('background-image', 'url("assets/img/card-img/card-img-0'+(i % 6+ 1)+'.png")');
	}
	$("#cardContainer0").find(".front").html('Start');
	$("#cardContainer"+nAllCardCount).find(".front").html('Finish');
}
fillImageCards();

function initAllCurrentUsers(){
	$("#playingUsers").html("");
	arrPlayerNames = [];
	nCurPlayingCount = 0;
	if( userName != "")
		addUser(userName);
	else
		addUser("ME");
}
function userAccepted(_userName) {
	addUser(_userName);
}
$(".exit_Btn").on('click', function(){
	if( gameState == false)return;
	gameState = false;
	isPlaying = false;
	__user_obj = {'type':'g_exit_game', 'adminName': adminName, 'gameCode': gameCode, 'masterName':masterUserName, 'userName':userName};
	socket.emit('sentence message', JSON.stringify(__user_obj));
	$("#playingUsers").html("");
	$(".answerList").html("");
	nAllUserCount = 0;
	nCurPlayingCount = 0;
	arrPlayerNames = [];
	arrCarPosInCard = [];
	arrCurStep = [];
})
function setUserTurn(_name, _answer){
	if(isMaster == false){
		__user_obj = {'type':'g_user_Turn_Slave', 'adminName':adminName, 'gameCode': gameCode, 'masterName':masterUserName, 'curUserName': userName,'answer':_answer};
		socket.emit('sentence message', JSON.stringify(__user_obj));
		return;
	}
	__user_obj = {'type':'g_user_Turn', 'adminName':adminName, 'gameCode': gameCode, 'masterName':userName, 'nextUserName':_name, 'answer':_answer};
	socket.emit('sentence message', JSON.stringify(__user_obj));
}
function sendMyDiceNumber(_number1, _number2){
	if( gameState == false)return;
	__user_obj = {'type':'g_dice_Number', 'adminName':adminName, 'gameCode': gameCode, 'masterName':masterUserName, 'curUserName': userName, 'diceNumber': _number1+","+_number2};
	socket.emit('sentence message', JSON.stringify(__user_obj));
}
function checkHandle(checkboxElem){
	if( checkboxElem.checked){
		document.getElementById("myAnswer").disabled=false;
	} else {
		document.getElementById("myAnswer").disabled=true;
	}
}
function sendAnswreState( _number, _isCorrect){
	if( gameState == false)return;
	__user_obj = {'type':'g_answerNumber', 'adminName': adminName, 'gameCode': gameCode, 'masterName':masterUserName, 'curUserName': userName, 'answerNumber': _number, 'isCorrect': _isCorrect};
	socket.emit('sentence message', JSON.stringify(__user_obj));
}
function checkOthersAnswer( _name, _number){
	var _nCurNumber = arrPlayerNames.indexOf(_name);
	// var arrCurStep[_nCurNumber]
	if( arrAllAnswers[arrCurStep[_nCurNumber]-1].answerVal[_number].isCorrect == "false"){
		gotoStep(_name, -1);
	}
}
function confirmAnswer(){
	// if( isCanPlay == false){
	// 	alert("It's not your turn.");
	// 	return;
	// }
	if( !isHasAnswer)return;
	if( isConfirmAnswer) return;
	var elemTrs = $("#answerTable tr");
	var selectedAnswer = -1;
	for( var i = 0; i < elemTrs.length; i++){
		if( elemTrs.eq(i).find(".chkArea").hasClass("chk")){
			selectedAnswer = i;
			break;
		}
	}
	if( selectedAnswer == -1){
		alert("Please select the answer.");
		return;
	}
	if( curQuestionNum == -1)return;
	if( arrAllAnswers[curQuestionNum].answerVal[selectedAnswer].isCorrect == "false"){
		gotoStep(userName, -1);
		sendAnswreState(selectedAnswer, false);
		$(".wrongMessage").removeClass("HideItem").addClass("ShowItem");
		setTimeout(function(){
			$(".wrongMessage").removeClass("ShowItem").addClass("HideItem");
		}, 1000);
	} else {
		gotoStep(userName, 1);
		sendAnswreState(selectedAnswer, true);
		$(".correctMessage").removeClass("HideItem").addClass("ShowItem");
		setTimeout(function(){
			$(".correctMessage").removeClass("ShowItem").addClass("HideItem");
		}, 1000);
	}
	isConfirmAnswer = true;
}