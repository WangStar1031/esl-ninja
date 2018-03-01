<header>
	<title>ESL Ninja</title>
</header>
<script src="../assets/jquery.min.js"></script>

<?php
	if( isset($_GET['admin'])){
		$userName = $_GET['admin'];
?>
<style type="text/css">
	body{ margin: 0px; font-size: 1.1em;}
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	h1{ color:#485aa2; text-align: center;}
  p{ color: #485aa2; }
	.Landing{ padding-bottom: 10px; }
  .contents { width: 40%; margin: auto; max-width: 500px;}
  .Button { margin: auto; background-color: #485aa2; color: white; padding: 5px; width: 4em; text-align: center; cursor: pointer;font-size: 2em; }
  #Question { font-size: 2em; text-align: center; width: 100%;}
  .QuestionContainer { width: 50%; padding-top: 55px; height: 300px; margin: auto;vertical-align: middle; text-align: center;}
  .Topics { width: 100%; padding: 10px; border: 1px solid #485aa2; }
  .Topic { border: 2px solid white; width: 4em; margin: 10px; color: #485aa2; display: inline-block; cursor: pointer; text-align: center;}
  .Topic:hover{ background-color: #485aa2; color: white;}
  .selected { border: 2px solid #485aa2 ! important; color: #485aa2!important; background-color: white!important; }
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>Random Image<span style="text-align: right;position: absolute;right: 20px; top:2em; font-size: 1em;"><?= $userName ?></span></h1>
    <div style=" width: 100%; height: 300px; border: 1px solid #485aa2;">
      <div class="QuestionContainer">
        <img id="Question">
      </div>
    </div>
    <br>
    <div class="Button" onclick="nextQuestion()"> Press </div>
    <br>
    <p>Topics</p>
    <div class="Topics">
      <?php
        $dir = './Images/' . $userName . '/';
        $files = scandir($dir);
        for($i = 0, $topicNumber = 0; $i < count($files); $i ++){
          $fName = $files[$i];
          if( $fName != '.' && $fName != '..'){
            // $topicName = substr($fName, 0, $pointPos);
      ?>
        <div class="Topic" onclick="topicClick(<?= $topicNumber ?>)"><?= $fName ?></div>
      <?php
            $topicNumber++;
          }
        }
      ?>
    </div>
	</div>
</div>
<script type="text/javascript">
  var curTopics = "";
  var arrQuestions = [];
  var adminName = '<?= $userName ?>';
  var arrQuestionNumbers = [];
  var nCurQuestion = 0;

  function nextQuestion(){
    if( curTopics == "" || typeof curTopics == 'undefined'){
      alert("Please select the Topic.");
      return;
    }
    var nRandom = arrQuestionNumbers[nCurQuestion % arrQuestionNumbers.length];
    // console.log( arrQuestions[nRandom]);
    $("#Question").attr( "src", "./Images/"+adminName+"/"+curTopics+"/"+curTopics+"-"+(arrQuestions[nRandom] >= 10 ? arrQuestions[nRandom] : "0" + arrQuestions[nRandom]) + ".png");
    nCurQuestion ++;
  }
  function topicClick(nNumber){
    $(".Topic").removeClass("selected");
    $(".Topic").eq(nNumber).addClass("selected");
    curTopics = $(".Topic").eq(nNumber).html();

    jQuery.ajax({
      type: 'POST',
      url: 'utils/topicManager.php',
      data: { getQuestion: curTopics, adminName: adminName },
      success: function(obj, textstatus){
        nCurQuestion = 0;
        arrQuestions = [];
        arrQuestionNumbers = [];
        $("#Question").html("");
        for( i = 1; i < obj * 1+1; i++){
            arrQuestions.push(i);
        }
        for( i = 0; i < arrQuestions.length; i++){
          arrQuestionNumbers.push(i);
        }
        for( i = 0; i < arrQuestions.length; i++){
          var randVal = parseInt( Math.random() * arrQuestions.length);
          var nBuff = arrQuestionNumbers[i];
          arrQuestionNumbers[i] = arrQuestionNumbers[randVal];
          arrQuestionNumbers[randVal] = nBuff;
        }
        console.log(arrQuestionNumbers);
      }
    });
  }
  topicClick(0);
</script>
<?php
}
?>