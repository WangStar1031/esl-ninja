<?php
	$arrCards = array();
	$category = "";
	function getImageCount($topic, $admin){
		$dir = './Images/'.$admin.'/'.$topic.'/';
		$files1 = scandir($dir);
		return count($files1) - 2;
	}
	function fileRename($topic, $admin){
		$nFiles = getImageCount($topic, $admin);
		$dir = './Images/'.$admin.'/'.$topic.'/';
		$files1 = scandir($dir);
		for( $i = 0, $fileFix = 0; $i < count($files1); $i++){
			$fName = $files1[$i];
			if(!( $fName == "." || $fName == "..")){
				$fileFix ++;
				$fNewName = './Images/'.$admin.'/'.$topic.'/'.$topic.'-temp' . str_pad($fileFix, 2, "0", STR_PAD_LEFT) . '.png';
				$fOldName = "./Images/".$admin.'/'.$topic.'/' . $fName;
				rename( $fOldName, $fNewName);
			}
		}
		$files1 = scandir($dir);
		for( $i = 0, $fileFix = 0; $i < count($files1); $i++){
			$fName = $files1[$i];
			if(!( $fName == "." || $fName == "..")){
				$fileFix ++;
				$fOldName = './Images/'.$admin.'/'.$topic.'/'.$topic.'-temp' . str_pad($fileFix, 2, "0", STR_PAD_LEFT) . '.png';
				$fNewName = "./Images/".$admin.'/'.$topic."/".$topic."-" . str_pad($fileFix, 2, "0", STR_PAD_LEFT) . '.png';

				list($width, $height) = getImagesize($fOldName);
				$newWidth = 100;
				$newHeight = 75;
				$thumb = imagecreatetruecolor($newWidth, $newHeight);
				$source = imagecreatefrompng($fOldName);
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				imagepng($thumb, $fNewName);
				unlink($fOldName);
				// rename( $fOldName, $fNewName);
			}
		}
	}
	if( isset($_POST['deleteImages'])){
		$topic = $_POST['topicName'];
		$deleteImgs = $_POST['deleteImages'];
		$adminName = $_POST['adminName'];
		$arrIds = explode(",", $deleteImgs);
		for ( $i = 0; $i < count($arrIds); $i ++){
			$fName = './Images/'.$adminName.'/'.$topic.'/'.$topic.'-' . str_pad($arrIds[$i], 2, "0", STR_PAD_LEFT) . '.png';
			unlink($fName);
		}
		fileRename($topic, $adminName);
		$nFiles = getImageCount($topic, $adminName);
		echo $nFiles;
	}
	if( isset($_POST['getImgFileCount'])){
		$topic = $_POST['topicName'];
		$adminName = $_POST['adminName'];
		echo getImageCount($topic, $adminName);
	}
	if(isset($_POST['submit'])){
		if(count($_FILES['upload']['name']) > 0){
			$topic = $_POST['editFormTopic'];
			$adminName = $_POST['adminName'];
			var_dump($topic);
			if( $topic != '.' && $topic != '..' && $topic != ''){
				for($i=0; $i<count($_FILES['upload']['name']); $i++) {
					$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
					if($tmpFilePath != ""){
						$shortname = $_FILES['upload']['name'][$i];
						$filePath = "./Images/".$adminName.'/'.$topic."/" . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
						if(move_uploaded_file($tmpFilePath, $filePath)) {
							$files[] = $shortname;
						}
					}
				}
				fileRename($topic, $adminName);
			}
		}
	}
	if(isset($_POST['topicChange'])){
		$topic = $_POST['topicChange'];
		$adminName = $_POST['adminName'];
		$dir = './Images/'.$adminName.'/'.$topic.'/';
		// echo $dir;
		$files1 = scandir($dir);
		echo count($files1) - 2;
	}
	if(isset($_POST['addTopic'])){
		$topicName = $_POST['addTopic'];
		$adminName = $_POST['adminName'];
		mkdir('./Images/'.$adminName.'/'.$topicName);
		echo $topicName;
	}
	if(isset($_POST['delTopic'])){
		$topicName = $_POST['delTopic'];
		$adminName = $_POST['adminName'];
		rmdir('./Images/'.$adminName.'/'.$topicName);
		echo $topicName;
	}
?>