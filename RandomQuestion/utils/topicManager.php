<?php

	if( isset($_POST['getTopics'])){
		$adminName = $_POST['adminName'];
		$dir = '../assets/' . $adminName;
		$files = scandir($dir);
		$arrRet = array();
		for( $i = 0; $i < count($files); $i++){
			$fName = $files[$i];
			if( $fName != '.' && $fName != '..'){
				$pointPos = strrpos($fName, '.');
				$TopicName = substr($fName, 0, $pointPos);
				array_push($arrRet, $TopicName);
			}
		}
		echo json_encode($arrRet);
	}
	if( isset($_POST['addTopic'])){
		$TopicName = $_POST['addTopic'];
		$adminName = $_POST['adminName'];
		$myFile = fopen("../assets/".$adminName.'/'.$TopicName.".txt", "w");
		fclose($myFile);
	}
	if( isset($_POST['delQuestion'])){
		$TopicName = $_POST['delQuestion'];
		$adminName = $_POST['adminName'];
		unlink('../assets/'.$adminName.'/'.$TopicName.'.txt');
	}
	if( isset($_POST['modifyTopic'])){
		$curTopicName = $_POST['modifyTopic'];
		$newTopicName = $_POST['newTopicName'];
		$adminName = $_POST['adminName'];
		rename( '../assets/'.$adminName.'/'.$curTopicName.'.txt', '../assets/'.$adminName.'/'.$newTopicName.'.txt');
	}
	if( isset($_POST['getQuestion'])){
		$TopicName = $_POST['getQuestion'];
		$adminName = $_POST['adminName'];
		echo file_get_contents('../assets/'.$adminName.'/'.$TopicName.'.txt');
	}
	if( isset($_POST['saveQuestion'])){
		$TopicName = $_POST['saveQuestion'];
		$adminName = $_POST['adminName'];
		$question = $_POST['question'];
		$file = fopen('../assets/'.$adminName.'/'.$TopicName.'.txt', 'w');
		fwrite($file, $question);
		fclose($file);
		echo "OK";
	}
?>