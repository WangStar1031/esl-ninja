<header>
	<title>ESL Ninja</title>
</header>
<script src="../assets/jquery.min.js"></script>

<?php
	session_start();
	if( isset($_SESSION['GameUserName'])){
		$userName = $_SESSION['GameUserName'];
?>
<style type="text/css">
	body{ margin: 0px; font-size: 1.1em;}
	.Header{ color: white; background-color: #485aa2; padding: 5px; }
	h1{ color:#485aa2; text-align: center;}
	.Landing{ padding-bottom: 10px; }
  .Topics, .Question { height: 200px; width: 100%; margin: auto; padding: 10px;}
  .contents { width: 40%; margin: auto; max-width: 500px;}
  .Button { margin: 5 5 5 0; display: inline-block; background-color: #485aa2; color: white; padding: 5px; width: 4em; text-align: center; cursor: pointer;}
  .TopicName{ font-size: 1.1em; }
</style>
<div class="Landing">
	<div class="Header">ESL Ninja</div>
	<div class="contents">
		<h1>Random Questions<span style="text-align: right;position: absolute;right: 20px; top:2em; font-size: 1em;"><?= $userName ?></span></h1>
		<p>Topic</p>
		<select class="Topics" id="topics" multiple onchange="selectionChanged()">
      <?php
        if( !file_exists('assets/' . $userName)){
          mkdir('assets/' . $userName);
        }
        $dir = 'assets/' . $userName . '/';
        $files = scandir($dir);
        for( $i = 0; $i < count($files); $i++){
          $fName = $files[$i];
          if( $fName != '.' && $fName != '..'){
            $pointPos = strrpos($fName, '.');
            $TopicName = substr($fName, 0, $pointPos);
      ?>
        <option class="TopicName"><?= $TopicName ?></option>
      <?php
          }
        }
      ?>
		</select>
    <div class="Button" onclick="addTopic()"> Add </div>
    <div class="Button" onclick="editTopic()"> Edit </div>
    <div class="Button" onclick="delTopic()"> Del </div>
    <p>Questions</p>
    <textarea class="Question" id="Question"></textarea>
    <div class="Button" onclick="saveQuestions()"> Save </div>
	</div>
</div>
<script type="text/javascript">
  function getSelectedTopicName(){
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
  var adminName = '<?= $userName ?>';
  function refreshTopicList(){
    jQuery.ajax({
      type: 'POST',
      url: 'utils/topicManager.php',
      dataType: 'json',
      data: { getTopics: "getTopics", adminName:adminName },
      success: function(obj, textstatus){
        var strHtml = "";
        for( i = 0; i < obj.length; i++){
          strHtml += "<option class='TopicName'>" + obj[i] + "</option>";
        }
        $("#topics").html(strHtml);
      }
    });
  }
  function addTopic(){
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
        url: 'utils/topicManager.php',
        data: {addTopic:topicName, adminName:adminName },
        success: function(obj, textstatus){
          setTimeout(function(){
            refreshTopicList();
          }, 1000);
        }
      });
    }
  }
  function editTopic(){
    var curTopicName = getSelectedTopicName();
    if( curTopicName == ""){
      alert("Please select topic!");
      return;
    }
    var topicName = prompt("Please enter the new topic Name.", curTopicName);
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
        url: 'utils/topicManager.php',
        data: {modifyTopic: curTopicName, newTopicName: topicName, adminName:adminName },
        success: function(obj, textstatus){
          setTimeout(function(){
            refreshTopicList();
          }, 1000);
        }
      });
    }
  }
  function delTopic(){
    var topicName = getSelectedTopicName();
    if( topicName == ""){
      alert("Please select topic!");
      return;
    }
    var r = confirm("Are you sure delete current topic?");
    if( r != true)return;
    jQuery.ajax({
      type: 'POST',
      url: 'utils/topicManager.php',
      data: {delQuestion: topicName, adminName:adminName},
      success: function(obj, textstatus){
        setTimeout(function(){
          refreshTopicList(topicName);
        }, 1000);
      }
    });
  }
  function saveQuestions(){
    var topicName = getSelectedTopicName();
    if( topicName == ""){
      alert("Please select topic!");
      return;
    }
    jQuery.ajax({
      type: 'POST',
      url: 'utils/topicManager.php',
      data: {saveQuestion: topicName, adminName:adminName, question: $("#Question").val()},
      success: function(obj, textstatus){
        if( obj == "OK")
          alert("Successfully saved.");
        else
          alert("Doesn't saved.");
      }
    });
  }
  function selectionChanged(){
    var topicName = getSelectedTopicName();
    if( topicName == ""){
      $("#Question").val("");
      return;
    }
    jQuery.ajax({
      type: 'POST',
      url: 'utils/topicManager.php',
      data: {getQuestion: topicName, adminName:adminName},
      success: function(obj, textstatus){
        $("#Question").val( obj);
      }
    });
  }
</script>
<?php
}
?>