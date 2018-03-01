<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/css/questionMaker.css?<?= time(); ?>">


</head>
<body>
<div class="HOutLine container">		
</div>
<div class="BOutLine container">
	<div class="fBody">
		<div class="Header">
			<h1>Questionnaire Maker</h1>
				<p>Topic <input type="text" name="Travel" placeholder="Please enter the Topic" id="idTopic"></p>
		</div>
		<div class="addQuestion">
			<div class="col-lg-3 col-md-2 col-xs-1"></div>
			<div class="addQuestionBtn col-lg-3 col-md-4 col-xs-5 btnShape" onclick="addQuestion()">Add Question</div>
			<div class="saveQuestionsBtn col-lg-3 col-md-4 col-xs-5 btnShape" onclick="saveQuestion()">Save Questions</div>
			<div class="col-lg-4 col-md-2 col-xs-1"></div>
			<input class="btnShape" action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
<?php
	$fileName = $_GET['title'];
	$new = "new";
	$contents = "";
	if( !isset($_GET['new'])){
		$new = "";
		$contents = file_get_contents("assets/topics/".$fileName.".txt");
	}
?>
<script type="text/javascript">
	var isNew = "<?= $new ?>" == "" ? false : true;	
	var fileName = "<?= $fileName ?>";
</script>
<div class="HideItem">
	<div class="Questions" id="Questions">
		<div class="QuestionHeader container">
			<div class="QuestionNumber  col-md-6 col-lg-6 col-xs-12">Question1</div>
		</div>
		<div class="multiChoiceSection row">
			<div class="row">
				<p class="Title btnShape">Add multiple choice</p>
			</div>
			<div class="row">
				<div class="Question col-md-6 col-lg-6 col-xs-12">
					<table>
						<tr>
							<td>Q</td>
							<td colspan="3"><input type="text" name="mylQuestion" class="inputQuestion"></td>
						</tr>
					</table>
					<p class="MulMoreBtn btnShape fLeft">Add more choices</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="./assets/js/questionMaker.js?<?= time(); ?>"></script>
<?php
	if( $new == ""){
?>
<script type="text/javascript">
	var contents;
	if( isNew != true){
		contents = <?= $contents?>;
		console.log(contents);
		parseContents(contents);
	}
</script>
<?php
	}
?>
</body>