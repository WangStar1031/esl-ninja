<header>
  <title>ESL Ninja</title>
</header>
<link rel="stylesheet" type="text/css" href="assets/card_game.css?<?= time(); ?>">
<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
<script src="assets/jquery.min.js"></script>

<?php
  session_start();
  if( isset($_SESSION['GameUserName'])){
    $userName = $_SESSION['GameUserName'];
?>
<style type="text/css">
  body{ margin: 0px; }
  .Header{ color: white; background-color: #485aa2; padding: 5px; }
  h1{ color:#485aa2; }
  .Landing{ padding-bottom: 10px; }
</style>
<div class="Landing">
  <div class="Header">ESL Ninja</div>
  <div class="contents">
    <h1>Card Matching Game Maker<span style="text-align: right;position: absolute;right: 20px; top:2em; font-size: 1em;"><?= $userName ?></span></h1>
    </div>
</div>
<div class="ImageEditing">
  <div>
    <div style="cursor: pointer;text-shadow: 2px 2px 2px blue;" class="checkAll" onclick="checkAll()">
      <img class="checkImg0" style="visibility: hidden;" id="checkImg0" src="./assets/img/check.png?<?= time(); ?>">Check All
    </div>
  </div>
  <div class="imageGallery">
    <?php
      $dir = './images/'.$userName.'/';
      if( !file_exists($dir))
        mkdir($dir);
      $files1 = scandir($dir);
      $topicsName = $files1[2];
      $dir .= $topicsName."/";
      $files1 = scandir($dir);
      $cardCount = count($files1) - 2;
    ?>
    <script type="text/javascript">
      editTopicName = "<?= $topicsName ?>";
      var strAdminName = '<?= $userName ?>';
      function arrangeCards(cardCount){
        // console.log(strAdminName);
        // console.log(editTopicName);
        // console.log(cardCount);
        var currentDate = new Date();
        var strHtml = "";
        for( i = 1; i <= cardCount; i++ ){
          var strFix = (i < 10) ? '0' + i.toString() : i.toString();
          var pathName = "./images/"+strAdminName+"/"+editTopicName+"/"+editTopicName +"-" + strFix + ".png";
          // console.log(pathName);
          var strDiv = '<div class="imgGalleryTags" onclick="ImgClicked(' + i + ')">';
          strDiv += '<img class="imgTags" id="imgTags' + i + '" src = "' + pathName + '?' + currentDate.getMinutes() + currentDate.getSeconds() + '">';
          strDiv += '<img class="checkImg" style="visibility:hidden;" id="checkImg' + i + '" src="./assets/img/check.png?<?= time(); ?>">';
          strDiv += '</div>';
          strHtml += strDiv;
        }
        document.getElementsByClassName("imageGallery")[0].innerHTML = strHtml;
      }
      var cardCount = parseInt("<?= $cardCount ?>");
      arrangeCards(cardCount);
    </script>
  </div>
  <div class="cardOperation">
    <div>
      <h1 style="color: black;">Topic</h1>
      <div id="TopicPan">
        <div id="editTopicContainer">
          <?php
            $dir = './images/'.$userName.'/';
            $files = scandir($dir);
            $activeNumber = 0;
            for( $i = 0; $i < count($files); $i++){
              $dirName = $files[$i];
              if( strpos($dirName, '.') === false){
                if($activeNumber == 0){
                  $activeNumber++;
                  echo "<p class='editTopics selected'>". $dirName . "</p>";
                }else{
                  echo "<p class='editTopics'>". $dirName . "</p>";
                }
              }
            }
          ?>
        </div>
        <p class="addTopic topicControl">+</p>
        <p class="delTopic topicControl">-</p>
      </div>
    </div>

    <button onclick="deleteImages()">Delete</button><br>
    <iframe src="" style="display: none;" id="iframeTag" name="iframeTag"></iframe>
    <form id="uploadImageForm" target="iframeTag" action="card_editing.php" enctype="multipart/form-data" method="post">
      <div id="uploadFilePicker">
          <input type="hidden" id="editFormTopic" name="editFormTopic" value=""></input>
          <label for='upload'>Add ImageFiles:</label><br>
          <input id='upload' name="upload[]" accept="image/png" type="file" multiple="multiple" />
          <input type="" name="adminName" value="<?= $userName ?>" style="display: none;">
      </div>
      <p><input type="submit" name="submit" value="Upload" onclick="refreshImages()"></p>
    </form>
  </div>
  <div style="clear: both;"></div>
</div>

<script type="text/javascript">
  $("#editFormTopic").attr("value", editTopicName);
$(".addTopic").on("click", function(){
  var topicTitle = window.prompt("Please type the Topic title!","");
  if( topicTitle){
    var curTitles = document.getElementsByClassName("editTopics");
    for(i = 0; i < curTitles.length; i++){
      if (curTitles[i].innerHTML == topicTitle) {
        alert("Exist Topic!");
        return;
      }
    }
    jQuery.ajax({
      type: 'POST',
      url: 'card_editing.php',
      data: {addTopic: topicTitle, adminName: strAdminName},
      success: function(obj, textstatus){
        var strHtml = "<p class='editTopics'>" + obj + "</p>";
        // console.log(strHtml);
        $("#editTopicContainer").append(strHtml);
        editTopicsFunction();
      }
    });
  } else{
  }
});
$(".delTopic").on("click", function(){
  var result = confirm("Are you sure delete current Topic?");
  if(result){
    var topics = document.getElementsByClassName("editTopics");
    var selectedTopic;
    for( i = 0; i < topics.length; i++){
      var topicClass = topics[i].className;
      if(topicClass.indexOf("selected") != -1){
        selectedTopic =topics[i].innerHTML;
      }
    }

    jQuery.ajax({
      type: 'POST',
      url: 'card_editing.php',
      data: {delTopic: selectedTopic, adminName: strAdminName},
      success: function(obj, textstatus){
        $(".editTopics:contains('"+obj+"')").remove();
      }
    });
  } else{

  }
});
$(".topics").on("click", function(){
  $(".topics").removeClass("selected");
  $(this).addClass("selected");
  dealCards();
});
function editTopicsFunction(){
  $(".editTopics").on("click", function(){
    $(".editTopics").removeClass("selected");
    $(this).addClass("selected");
    editTopicName = $(this).html();
    $("#editFormTopic").attr("value",editTopicName);
    jQuery.ajax({
      type: 'POST',
      url: 'card_editing.php',
      data: {topicChange: editTopicName, adminName: strAdminName},
      success: function(obj, textstatus){
        // console.log("topicChange");
        // console.log(obj);
        cardCount = parseInt(obj)
        arrangeCards( cardCount);
      }
    });
  });
}
editTopicsFunction();
function editCards(){
  document.getElementsByClassName("centerAlign")[0].style.display ="none";
  document.getElementsByClassName("ImageEditing")[0].style.display = "block";
}
function ImgClicked( i ){
  var ele = document.getElementById('checkImg' + i);
  if( ele.style.visibility == 'visible'){
    ele.style.visibility = 'hidden';
  } else{
    ele.style.visibility = 'visible';
  }
}
function checkAll( ){
  var ele = document.getElementById('checkImg0');
  if( ele.style.visibility == 'visible'){
    ele.style.visibility = 'hidden';
  }else{
    ele.style.visibility = 'visible';
  }
  var vis = ele.style.visibility;
  var elems = document.getElementsByClassName("checkImg");
  for( i = 0; i < elems.length; i++){
    elems[i].style.visibility = vis;
  }
}
function deleteImages(){
  var elems = document.getElementsByClassName("checkImg");
  var arrSelElems = [];
  for( i = 0; i < elems.length; i ++){
    if( elems[i].style.visibility == "visible"){
      var strId = elems[i].id;
      var strIndex = strId.substring(8);
      arrSelElems.push(strIndex);
    }
  }
  if( arrSelElems.length == 0){
    alert("No images selected!");
    return;
  }
  var r = confirm('Are you sure DELETE selected images?');
  if( r == true){   // confirm Delete Images
    var strImageIds = arrSelElems.join(",");
    jQuery.ajax({
      type: 'POST',
      url: 'card_editing.php',
      data: {deleteImages: strImageIds, topicName:editTopicName, adminName: strAdminName},
      success: function(obj, textstatus){
        // console.log("deleteImages");
        // console.log(obj);
        cardCount = parseInt(obj)
        arrangeCards( cardCount);
      }
    });
  }
}
function refreshImages(){
  setTimeout( function(){
    jQuery.ajax({
      type: 'POST',
      url: 'card_editing.php',
      data: {getImgFileCount: 'getImgFileCount', topicName: editTopicName, adminName: strAdminName},
      success: function(obj, textstatus){
        // console.log("getImgFileCount");
        // console.log(obj);
        cardCount = parseInt(obj)
        arrangeCards( cardCount);
        var el = $("#upload");
        el.wrap('<form>').closest('form').get(0).reset();
        el.unwrap();
      }
    });
  }, 1000);
}
</script>
<?php
}
?>