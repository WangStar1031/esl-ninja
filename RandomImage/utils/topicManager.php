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
	if( isset($_POST['getQuestion'])){
		$TopicName = $_POST['getQuestion'];
		$adminName = $_POST['adminName'];
		$dir = '../Images/'.$adminName.'/'.$TopicName;
		$files = scandir($dir);
		$count = count($files) - 2;
		echo $count;
	}
?>