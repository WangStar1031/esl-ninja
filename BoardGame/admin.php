<header>
	<title>ESL Ninja</title>
</header>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="assets/css/admin.css?<?= time(); ?>">

<?php
	session_start();
	if( isset($_SESSION['GameUserName'])){
		$userName = $_SESSION['GameUserName'];
	// $fileContents = file_get_contents("assets/adminInfo/adminInfo.txt");
?>
<script type="text/javascript">
	var adminName = '<?= $userName ?>';
</script>
<iframe src="" style="display: none;" id="iframeTag" name="iframeTag"></iframe>
<style type="text/css">
  body{ margin: 0px; }
  .Header{ color: white; background-color: #485aa2; padding: 5px; }
  h1{ color:#485aa2; text-align: center; }
  .Landing{ padding-bottom: 10px; }
</style>
<div class="Landing">
  <div class="Header">ESL Ninja</div>
  <div class="contents">
	<h1>Board Game Maker<span style="text-align: right;position: absolute;right: 20px; top:2em; font-size: 1em; background-color: white; color:#485aa2!important;"><?= $userName ?></span></h1>
	</div>
</div>
<div style="width: 90%; margin: auto;">
	<div class="row">
		<div class="topicContainer col-lg-2 col-md-2 col-xs-3">
			<h2>topics</h2>
			<select id = "topics" name="topics" multiple class="topicList" onchange="topicChanged()">
			</select>
			<p><span id="topicAdd">add</span><span id="topicDel">del</span><span id="topicModify">modify</span></p>
		</div>
		<div class="questionContainer col-lg-4 col-md-4 col-xs-9">
			<h2>questions</h2>
			<textarea id="questions" class="questionList"></textarea>
			<p><span id="questionAdd">confirm</span></p>
		</div>
		<div class="bgImages col-lg-3 col-md-3 col-xs-6">
			<h2>BG Images</h2>
			<div class="bgImgDiv">
				<?php
					$dir = 'assets/'.$userName.'/bg-img/';
					if( !file_exists('assets/'.$userName)){
						mkdir('assets/'.$userName);
					}
					if( !file_exists('assets/'.$userName.'/bg-img')){
						mkdir('assets/'.$userName.'/bg-img');
					}
					$files = scandir($dir);
					$arrRet = array();
					$nNumber = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
				?>
					<div class="bgImgs" style="background-image: url('<?= $dir.$fName."?".time() ?>')" onclick="bgImgsClicked(<?= $nNumber ?>)">
					</div>
				<?php
							$nNumber++;
						}
					}
				?>
			</div>
			<form id="uploadBgForm" target="iframeTag" action="bgImgCollecting.php" enctype="multipart/form-data" method="post">
				<div id="uploadFilePicker">
					<label for="file-uploadBg" class="custom-file-upload" style="border: none">
						<i class="fa fa-cloud-upload"></i><span id="gbImgAdd">add</span>
					</label>
					<span id="gbImgDel" onclick="bgImgsDelete()">del</span>
					<input id="file-uploadBg" name="upload" type="file"/>
					<input type="text" name="adminName" value="<?= $userName ?>" style="display: none;">
				</div>
			</form>
		</div>
		<div class="gbImages col-lg-3 col-md-3 col-xs-6">
			<h2>GB Images</h2>
			<div class="gbImgDiv">
				<?php
					$dir = 'assets/'.$userName.'/card-img/';
					if( !file_exists('assets/'.$userName)){
						mkdir('assets/'.$userName);
					}
					if( !file_exists('assets/'.$userName.'/card-img')){
						mkdir('assets/'.$userName.'/card-img');
					}
					$files = scandir($dir);
					$arrRet = array();
					$nNUmber = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
				?>
					<div class="gbImgs" style="background-image: url('<?= $dir.$fName."?".time() ?>')" onclick="gbImgsClicked(<?= $nNUmber ?>)">
					</div>
				<?php
						$nNUmber++;
						}
					}
				?>
			</div>
			<form id="uploadGbForm" target="iframeTag" action="gbImgCollecting.php" enctype="multipart/form-data" method="post">
				<div id="uploadFilePicker">
					<label for="file-uploadGb" class="custom-file-upload" style="border: none">
						<i class="fa fa-cloud-upload"></i><span id="gbImgAdd">add</span>
					</label>
					<span id="gbImgDel" onclick="gbImgsDelete()">del</span>
					<input id="file-uploadGb" name="upload" type="file"/>
					<input type="text" name="adminName" value="<?= $userName ?>" style="display: none;">
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="topicContainer col-lg-4 col-md-4 col-xs-12">
			<h2>Select Questions</h2>
			<select id = "selQuestion" multiple name="selQuestion" class="questionList" onchange="questionChanged()">
			</select>
		</div>
		<div class="questionContainer col-lg-4 col-md-4 col-xs-12">
			<h2>Answers</h2>
			<div class="AnswerPannel">
				<table id="answerTable">
				</table>
			</div>
			<p><span onclick="addAnswer()">add Answer</span>
				<span onclick="confirmAnswer()">confirm</span></p>
		</div>
		<div class="playerImgPan col-lg-4 col-md-4 col-xs-12">
			<h2>player Images</h2>
			<div class="plrImgDiv">
				<?php
					$dir = 'assets/'.$userName.'/birds/';
					if( !file_exists('assets/'.$userName)){
						mkdir('assets/'.$userName);
					}
					if( !file_exists('assets/'.$userName.'/birds')){
						mkdir('assets/'.$userName.'/birds');
					}
					$files = scandir($dir);
					$arrRet = array();
					$nNumber = 0;
					for( $i = 0; $i < count($files); $i ++){
						$fName = $files[$i];
						if( $fName != '.' && $fName != '..'){
				?>
					<div class="playerImgs" style="background-image: url('<?= $dir.$fName."?".time() ?>')" onclick="playerImgsClicked(<?= $nNumber ?>)">
					</div>
				<?php
							$nNumber++;
						}
					}
				?>
			</div>
			<form id="uploadBirdForm" target="iframeTag" action="birdImgCollecting.php" enctype="multipart/form-data" method="post">
				<div id="uploadFilePicker">
					<label for="file-uploadBird" class="custom-file-upload" style="border: none">
						<i class="fa fa-cloud-upload"></i><span id="birdImgAdd">add</span>
					</label>
					<span id="birdImgDel" onclick="playerImgsDelete()">del</span>
					<input id="file-uploadBird" name="upload" type="file"/>
					<input type="text" name="adminName" value="<?= $userName ?>" style="display: none;">
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-xs-3"></div>
		<div class="col-lg-1 col-md-1 col-xs-1">
			<p><span onclick="saveAnswers()">Save</span></p>
		</div>
		<div class="col-lg-3 col-md-3 col-xs-3">
			<form id="uploadExcelForm" target="iframeTag" action="excelParsing.php" enctype="multipart/form-data" method="post">
				<div id="uploadFilePicker">
					<label for="file-upload" class="custom-file-upload">
						<i class="fa fa-cloud-upload"></i>From Excel File
					</label>
					<input id="file-upload" name="upload" type="file"/>
				</div>
				<input type="text" name="adminName" value="<?= $userName ?>" style='display: none;'>
			</form>
		</div>
		<div class="col-lg-4 col-md-4 col-xs-3"></div>
	</div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script  src="assets/js/admin.js?<?= time() ?>"></script>
<script type="text/javascript">
	document.getElementById("file-upload").onchange = function() {
		document.getElementById("uploadExcelForm").submit();
		setTimeout( function(){
			location.reload();
		}, 1000);
		
	};
	document.getElementById("file-uploadBg").onchange = function() {
		document.getElementById("uploadBgForm").submit();
		setTimeout( function(){
			location.reload();
		}, 1000);
		
	};
	document.getElementById("file-uploadGb").onchange = function() {
		document.getElementById("uploadGbForm").submit();
		setTimeout( function(){
			location.reload();
		}, 1000);
		
	};
	document.getElementById("file-uploadBird").onchange = function() {
		document.getElementById("uploadBirdForm").submit();
		setTimeout( function(){
			location.reload();
		}, 1000);
		
	};
	function bgImgsClicked( nNumber ){
		$(".bgImgs").eq(nNumber).toggleClass("borderRect");
	}
	function bgImgsDelete(){
		var elems = $(".bgImgs");
		var arrChecked = [];
		for( var i = elems.length - 1; i >= 0; i--){
			if( elems.eq(i).hasClass("borderRect"))
				arrChecked.push(i);
		}
		$.ajax({
			method: "POST",
			url: 'bgImgCollecting.php',
			data: { deleteBgImgs: arrChecked.join(","), adminName:adminName }
		}).done( function(msg){
			if( msg == "YES"){
				$(".bgImgs").filter(function(_index){
					return $(".bgImgs").eq(_index).hasClass("borderRect");
				}).remove();
				for( var i = 0; i < elems.length; i++){
					elems.eq(i).attr("onclick", "bgImgsClicked(" + i + ")");
				}
			}
		});
	}
	function gbImgsClicked( nNumber ){
		$(".gbImgs").eq(nNumber).toggleClass("borderRect");
	}
	function gbImgsDelete(){
		var elems = $(".gbImgs");
		var arrChecked = [];
		for( var i = elems.length - 1; i >= 0; i--){
			if( elems.eq(i).hasClass("borderRect"))
				arrChecked.push(i);
		}
		$.ajax({
			method: "POST",
			url: 'gbImgCollecting.php',
			data: { deleteGbImgs: arrChecked.join(","), adminName:adminName }
		}).done( function(msg){
			if( msg == "YES"){
				$(".gbImgs").filter(function(_index){
					return $(".gbImgs").eq(_index).hasClass("borderRect");
				}).remove();
				for( var i = 0; i < elems.length; i++){
					elems.eq(i).attr("onclick", "gbImgsClicked(" + i + ")");
				}
			}
		});
	}
	function playerImgsClicked( nNumber ){
		$(".playerImgs").eq(nNumber).toggleClass("borderRect");
	}
	function playerImgsDelete(){
		var elems = $(".playerImgs");
		var arrChecked = [];
		for( var i = elems.length - 1; i >= 0; i--){
			if( elems.eq(i).hasClass("borderRect"))
				arrChecked.push(i);
		}
		$.ajax({
			method: "POST",
			url: 'birdImgCollecting.php',
			data: { deletebirdImgs: arrChecked.join(","), adminName:adminName }
		}).done( function(msg){
			if( msg == "YES"){
				$(".playerImgs").filter(function(_index){
					return $(".playerImgs").eq(_index).hasClass("borderRect");
				}).remove();
				for( var i = 0; i < elems.length; i++){
					elems.eq(i).attr("onclick", "playerImgsClicked(" + i + ")");
				}
			}
		});
	}
</script>
<?php
	}		
?>