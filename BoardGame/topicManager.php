<?php
	function addTopic($topicName, $admin){
		if( !file_exists('assets/'. $admin)){
			mkdir('assets/' . $admin);
		}
		if( !file_exists('assets/'.$admin.'/topics')){
			mkdir('assets/'.$admin.'/topics');
		}
		if( !file_exists('assets/'.$admin.'/answers')){
			mkdir('assets/'.$admin.'/answers');
		}
		$myFile = fopen("assets/".$admin."/topics/".$topicName.".txt", "w");
		fclose($myFile);
	}
	function getTopics($admin){
		if( !file_exists('assets/'. $admin)){
			mkdir('assets/' . $admin);
		}
		if( !file_exists('assets/'.$admin.'/topics')){
			mkdir('assets/'.$admin.'/topics');
		}
		if( !file_exists('assets/'.$admin.'/answers')){
			mkdir('assets/'.$admin.'/answers');
		}
		$dir = 'assets/'.$admin.'/topics/';
		$files = scandir($dir);
		$arrRet = array();
		for( $i = 0; $i < count($files); $i ++){
			$fName = $files[$i];
			if( $fName != '.' && $fName != '..'){
				$pos = strpos($fName, ".");
				$buff = substr($fName, 0, $pos);
				array_push($arrRet, $buff);
			}
		}
		return $arrRet;
	}
	function deleteTopics($topicName, $admin){
		$fName = 'assets/'.$admin.'/topics/'.$topicName.'.txt';
		unlink($fName);
		$fName = 'assets/'.$admin.'/answers/'.$topicName.'.txt';
		unlink($fName);
	}
	function modifyTopics($topicName, $newTopicName, $admin){
		$topicName = 'assets/'.$admin.'/topics/'.$topicName.'.txt';
		$newTopicName = 'assets/'.$admin.'/topics/'.$newTopicName.'.txt';
		rename($topicName, $newTopicName);
	}
	if(isset($_POST['delQuestion'])){
		$topicName = $_POST['delQuestion'];
		$question = $_POST['question'];
		$adminName = $_POST['adminName'];
		$fName = 'assets/'.$adminName.'/topics/'.$topicName.'.txt';
		$contents = file_get_contents($fName);
		$arrQuestions = array();
		$arrQuestions = explode("\n", $contents);
		$newContents = "";
		for ($i=0; $i < count($arrQuestions); $i++) { 
			if( $arrQuestions[$i] == $question)
				continue;
			$newContents .= $arrQuestions[$i]."\n";
		}
		file_put_contents($fName, $newContents);
	}
	if(isset($_POST['addQuestion'])){
		$topicName = $_POST['addQuestion'];
		$question = $_POST['question'];
		$adminName = $_POST['adminName'];
		$fName = 'assets/'.$adminName.'/topics/'.$topicName.'.txt';
		file_put_contents($fName, $question);
	}
	if(isset($_POST['modigyTopic'])){
		$topicName = $_POST['modigyTopic'];
		$newTopicName = $_POST['newTopic'];
		$adminName = $_POST['adminName'];
		modifyTopics($topicName, $newTopicName, $adminName);
	}
	if( isset($_POST['delTopic'])){
		$topicName = $_POST['delTopic'];
		$adminName = $_POST['adminName'];
		deleteTopics($topicName, $adminName);
	}
	if(isset($_POST['getTopics'])){
		$adminName = $_POST['adminName'];
		echo json_encode(getTopics($adminName));
	}
	if(isset($_POST['addTopic'])){
		$topicName = $_POST['addTopic'];
		$adminName = $_POST['adminName'];
		addTopic($topicName, $adminName);
	}
	if(isset($_POST['getContents'])){
		$topicName = $_POST['getContents'];
		$adminName = $_POST['adminName'];
		echo file_get_contents('assets/'.$adminName.'/topics/'.$topicName.'.txt');
	}
	if( isset($_POST['saveAnswers'])){
		$title = $_POST['saveAnswers'];
		$datas = $_POST['datas'];
		$adminName = $_POST['adminName'];
		file_put_contents("assets/".$adminName."/answers/".$title.".txt", json_encode($datas));
		echo "Saved";
	}
	if( isset($_POST['getAnswers'])){
		$title = $_POST['getAnswers'];
		$adminName = $_POST['adminName'];
		echo file_get_contents("assets/".$adminName."/answers/".$title.".txt");
	}
?>