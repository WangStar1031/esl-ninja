<?php

	require('php-excel-reader/excel_reader2.php');

	require('SpreadsheetReader.php');
	function parseExcel($PathName, $FileName, $admin){
		$Reader = new SpreadsheetReader($PathName);
		$pos = strripos($FileName, '.');
		echo $pos;
		$topicName = substr( $FileName, 0, $pos);
		$topicFName = './assets/'.$admin.'/topics/'.$topicName.'.txt';
		$answerFName = './assets/'.$admin.'/answers/'.$topicName.'.txt';
		file_put_contents($topicFName, '');
		echo $topicFName;
		echo "<br>";
		$questionNumber = 0;
		$allAnswers = array();
		foreach ($Reader as $Row)
		{
			$Answers->questionNumber = $questionNumber;
			$questionNumber++;
			$answerVal = array();
			$question = $Row[0];
			$correctAnswer = $Row[1];
			file_put_contents($topicFName, $question."\r\n", FILE_APPEND);
			for( $i = 2; $i < count($Row); $i++){
				if( $Row[$i] == '')continue;
				// $oneAnswer = {};
				$oneAnswer->answer = $Row[$i];
				if( $Row[$i] == $correctAnswer)
					$oneAnswer->isCorrect = "true";
				else
					$oneAnswer->isCorrect = "false";
				print_r($oneAnswer);
				array_push($answerVal, clone $oneAnswer);
			}
			$Answers->answerVal = $answerVal;
			array_push($allAnswers, clone $Answers);
		}
		// $fileConntents = {};
		$fileConntents->topicName = $topicName;
		$fileConntents->allAnswers = $allAnswers;
		file_put_contents($answerFName, json_encode($fileConntents));
		print_r($fileConntents);
	}
	if(isset($_FILES['upload'])){
		if(count($_FILES['upload']['name']) > 0){
			echo count($_FILES['upload']['name']);
			$tmpFilePath = $_FILES['upload']['tmp_name'];
			$adminName = $_POST['adminName'];
			echo $_FILES['upload']['tmp_name'];
			if($tmpFilePath != ""){
				$shortname = $_FILES['upload']['name'];
				$filePath = "./assets/temp/" .$_FILES['upload']['name'];
				echo "<br>";
				echo $tmpFilePath;
				echo "<br>";
				echo $filePath;
				if(move_uploaded_file($tmpFilePath, $filePath)) {
					parseExcel($filePath, $_FILES['upload']['name'], $adminName);
					// unlink($filePath);
				} else{
					echo "Don't copy.";
				}
			}
		}
	}
?>