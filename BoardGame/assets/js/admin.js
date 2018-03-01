var totalQuestionAndAnswrs = {};
var arrAllAnswers = [];
function refreshTopicList(){
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		dataType: 'json',
		data: { getTopics: "getTopics", adminName:adminName },
		success: function(obj, textstatus){
			var strHtml = "";
			for( i = 0; i < obj.length; i++){
				strHtml += "<option>" + obj[i] + "</option>";
			}
			$("#topics").html(strHtml);
		}
	});
}
refreshTopicList();
$("#topicDel").on("click", function(){
	var el = document.getElementById("topics");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){
			jQuery.ajax({
				type: 'POST',
				url: 'topicManager.php',
				data: {delTopic: opt.text, adminName:adminName },
				success: function(obj, textstatus){
					setTimeout(function(){
						refreshTopicList();
					}, 2000);
				}
			});
			return;
		}
	}
})
$("#topicModify").on("click", function(){
	var el = document.getElementById("topics");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){
			var topicName = prompt("Please enter the new topic Name.", "");
			if( topicName != null){
				var el = document.getElementById("topics");
				var options = el && el.options;
				for( var i = 0, iLen = options.length; i<iLen; i++){
					opt = options[i];
					if( opt.selected){
						jQuery.ajax({
							type: 'POST',
							url: 'topicManager.php',
							data: {modigyTopic:opt.text, adminName:adminName, newTopic:topicName},
							success: function(obj, textstatus){
								setTimeout(function(){
									refreshTopicList();
								}, 2000);
								
							}
						});
						return;
					}
				}
			}
		}
	}
})
function refreshTopics(){
	setTimeout(function(){
		refreshTopicList();
	}, 2000);	
}
$("#topicAdd").on("click", function(){
	var topicName = prompt("Please enter the new topic Name.", "");
	if( topicName != null){
		var el = document.getElementById("topics");
		var options = el && el.options;
		for( var i = 0, iLen = options.length; i<iLen; i++){
			opt = options[i];
			if( opt.txt == topicName){
				alert("Exist Topic Name!");
				return;
			}
		}
		jQuery.ajax({
			type: 'POST',
			url: 'topicManager.php',
			data: {addTopic:topicName, adminName:adminName },
			success: function(obj, textstatus){
				setTimeout(function(){
					refreshTopicList();
				}, 2000);
				
			}
		});
	}
})
function getSelectedTopicName(){
	console.log("getSelectedTopicName");
	var el = document.getElementById("topics");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){
			return opt.text;
		}
	}
	return "";
}

$("#questionDel").on("click", function(){
	var topicName = getSelectedTopicName();
	if( topicName == ""){
		alert("Please select topic!");
		return;
	}
	var el = document.getElementById("question");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){
			jQuery.ajax({
				type: 'POST',
				url: 'topicManager.php',
				data: {delQuestion: topicName, adminName:adminName, question: opt.text},
				success: function(obj, textstatus){
					console.log(obj);
					setTimeout(function(){
						refreshContents(topicName);
					}, 2000);
				}
			});
			return;
		}
	}
})
$("#questionAdd").on("click", function(){
	var topicName = getSelectedTopicName();
	if( topicName == ""){
		alert("Please select topic!");
		return;
	}
	var el_q = document.getElementById("questions");
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		data: {addQuestion:topicName, adminName:adminName, question:$("#questions").val()},
		success: function(obj, textstatus){
			setTimeout(function(){
				refreshContents(topicName);
			}, 2000);			
		}
	});
})
function refreshContents(strTopic){
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		data: { getContents: strTopic, adminName:adminName },
		success: function(obj, textstatus){
			var arrRet = obj.split("\n");
			$("#selQuestion").html("");
			arrAllAnswers = [];
			for( var i = 0; i < arrRet.length; i++){
				if( arrRet[i] == "")continue;
				var strHtml = "<option>" + arrRet[i] + "</option>";
				$("#selQuestion").append(strHtml);
			}
			$("#questions").val(obj);
		}
	});
}
function topicChanged(){
	var el = document.getElementById("topics");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){
			totalQuestionAndAnswrs.topicName = opt.text;
			refreshContents(opt.text);
			setTimeout(function(){
				getAnswers(opt.text);
			}, 1000);			
			return;
		}
	}
}
function refreshAnswers(nQNumber){
	$("#answerTable").html("");
	if( typeof arrAllAnswers[nQNumber] == 'undefined' || typeof arrAllAnswers[nQNumber] == undefined ){
		return;
	}
	if( typeof arrAllAnswers[nQNumber].answerVal == 'undefined' || typeof arrAllAnswers[nQNumber].answerVal == undefined){
		return;
	}
	if( typeof arrAllAnswers[nQNumber].answerVal.length == 'undefined' || typeof arrAllAnswers[nQNumber].answerVal.length == undefined){
		return;
	}
	for(var i = 0; i < arrAllAnswers[nQNumber].answerVal.length; i++){
		var answer = arrAllAnswers[nQNumber].answerVal[i];
		addAnswer();
		$("#answerTable tr").eq(i).find(".answerText").val(answer.answer);
		if( answer.isCorrect != "false")
			$("#answerTable tr").eq(i).find(".chkArea").addClass("chk");
	}
}
function questionChanged(){
	var el = document.getElementById("selQuestion");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){
			refreshAnswers(i);
			return;
		}
	}	
}
function chkClick( nNumber){
	$("#answerTable tr .chkArea").removeClass("chk");
	$("#answerTable tr").eq(nNumber).find(".chkArea").addClass("chk");
}
function reArrange(){
	var elemTrs = $("#answerTable tr");
	for( var i = 0; i < elemTrs.length; i++){
		$("#answerTable tr").eq(i).find(".chkArea").attr("onclick", "chkClick("+i+")");
		$("#answerTable tr").eq(i).find(".delArea").attr("onclick", "onDelClick("+i+")");
	}
}
function onDelClick( nNumber){
	$("#answerTable tr").eq(nNumber).remove();
	reArrange();
}
function addAnswer(){
	var nAnswerCount = $("#answerTable tr").length;
	var strHtml = "";
	strHtml += "<tr>";
	strHtml += "<td><div class='chkArea' onclick='chkClick("+nAnswerCount+")'></div></td>";
	strHtml += "<td><input type='text' class='answerText'></td>";
	strHtml += "<td><div class='delArea' onclick='onDelClick("+nAnswerCount+")'>X</div></td>";
	strHtml += "</tr>";
	$("#answerTable").append(strHtml);
}
function confirmAnswer(){
	var nQNumber = -1;
	var el = document.getElementById("selQuestion");
	var options = el && el.options;
	for( var i = 0, iLen = options.length; i<iLen; i++){
		opt = options[i];
		if( opt.selected){nQNumber = i;}
	}
	if( nQNumber == -1){
		alert("Please select the Question.");
		return;
	}
	var answer = {};
	var elemTrs = $("#answerTable tr");
	answer.questionNumber = nQNumber;
	answer.answerVal = [];
	for( var i = 0; i < elemTrs.length; i++){
		var arrBuff = {};
		var answerBuf = elemTrs.eq(i).find(".answerText").val();
		arrBuff.answer = answerBuf;
		arrBuff.isCorrect = elemTrs.eq(i).find(".chkArea").hasClass("chk") ? "true" : "false";
		answer.answerVal.push(arrBuff);
	}
	arrAllAnswers[nQNumber] = answer;
}
function getAnswers(strTopic){
	arrAllAnswers = [];
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		dataType: 'json',
		data: { getAnswers: strTopic, adminName:adminName },
		success: function(obj, textstatus){
			console.log(obj.allAnswers);
			arrAllAnswers = obj.allAnswers;
			totalQuestionAndAnswrs.allAnswers = obj;
			// for( var i = 0; i < obj.allAnswers.length; i++){
			// 	var answer = {};
			// 	answer.questionNumber = obj.allAnswers[i].questionNumber;
			// }
		}
	});
}
function saveAnswers(){
	totalQuestionAndAnswrs.allAnswers = arrAllAnswers;
	jQuery.ajax({
		type: 'POST',
		url: 'topicManager.php',
		data: { saveAnswers: totalQuestionAndAnswrs.topicName, datas:totalQuestionAndAnswrs, adminName:adminName },
		success: function(obj, textstatus){
			alert(obj);
		}
	});
}
