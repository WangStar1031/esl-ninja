<?php
	function getImageCount($admin){
		$dir = './assets/'.$admin.'/card-img/';
		$files1 = scandir($dir);
		return count($files1) - 2;
	}
	function fileRename($admin){
		$nFiles = getImageCount($admin);
		$dir = './assets/'.$admin.'/card-img/';
		$files1 = scandir($dir);
		for( $i = 0, $fileFix = 0; $i < count($files1); $i++){
			$fName = $files1[$i];
			if(!( $fName == "." || $fName == "..")){
				$fileFix ++;
				$fNewName = './assets/'.$admin.'/card-img/card-img-temp' . str_pad($fileFix, 2, "0", STR_PAD_LEFT) . '.png';
				$fOldName = "./assets/".$admin."/card-img/" . $fName;
				rename( $fOldName, $fNewName);
			}
		}
		$files1 = scandir($dir);
		for( $i = 0, $fileFix = 0; $i < count($files1); $i++){
			$fName = $files1[$i];
			if(!( $fName == "." || $fName == "..")){
				$fileFix ++;
				$fOldName = './assets/'.$admin.'/card-img/card-img-temp' . str_pad($fileFix, 2, "0", STR_PAD_LEFT) . '.png';
				$fNewName = "./assets/".$admin."/card-img/card-img-" . str_pad($fileFix, 2, "0", STR_PAD_LEFT) . '.png';
				rename( $fOldName, $fNewName);
			}
		}
	}
	if(isset($_FILES['upload'])){
		if(count($_FILES['upload']['name']) > 0){
			echo count($_FILES['upload']['name']);
			$tmpFilePath = $_FILES['upload']['tmp_name'];
			$adminName = $_POST['adminName'];
			echo $_FILES['upload']['tmp_name'];
			if($tmpFilePath != ""){
				$filePath = "./assets/".$adminName."/card-img/xxx.png";
				echo "<br>";
				echo $tmpFilePath;
				echo "<br>";
				echo $filePath;
				if(move_uploaded_file($tmpFilePath, $filePath)) {
					fileRename($adminName);
				} else{
					echo "Don't copy.";
				}
			}
		}
	}
	if(isset($_POST['deleteGbImgs'])){
		$strDelImgs = $_POST['deleteGbImgs'];
		$arrImgNumbers = array();
		$arrImgNumbers = explode(',', $strDelImgs);
		$adminName = $_POST['adminName'];
		for( $i = 0; $i < count($arrImgNumbers); $i++){
			$fileName = './assets/'.$adminName.'/card-img/card-img-'. str_pad($arrImgNumbers[$i]+1, 2, '0', STR_PAD_LEFT).'.png';
			unlink($fileName);
		}
		fileRename($adminName);
		echo "YES";
	}
?>