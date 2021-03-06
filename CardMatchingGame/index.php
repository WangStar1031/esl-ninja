<header>
  <title>ESL Ninja</title>
</header>
<?php
if( isset($_GET['admin'])){
  $adminName = $_GET['admin'];
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
    <h1>Card Matching Game<span style="text-align: right;position: absolute;right: 20px; top:2em; font-size: 1em;"><?= $adminName ?>`s Game</span></h1>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="assets/card_game1.css?<?= time(); ?>">
<script src="assets/jquery.min.js"></script>
<!-- <script src="assets/socket.io-1.2.0.js"></script> -->
<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>

<script type="text/javascript">
  var arrCards = [];
  var IsBegin = false;
  var arrSelUsers = [];
  var gmTime;
  var timeSpend = 0;
  var clickCount = 0;
  var remainCount = 18;
  var onlineGameId = 0;
  var onlineGameEnd = false;
  var isMyturn = false;
  var onlineMasterName = "";
  var onlineClientName = "";
  var onlineMyMatchCount = 0; 
  var onlineOtherMatchCount = 0;
  var onlineOtherName = "";
  var topicName;
  var userName = "";
  var arrUsers = [];
  var adminName = '<?= $adminName ?>';
  function setCardImgs(arrCardContents){
    console.log("setCardImgs");
    console.log(arrCardContents);
    document.getElementById("animationTag").style.visibility = "hidden";
    clearInterval(gmTime);
    remainCount = 18;
    IsBegin = false;
    var currentDate = new Date();
    for( i = 0; i < arrCardContents.length; i++){
      var cardId = "cardContainer" + i;
      var imgId = "img" + i;
      document.getElementById(imgId).src = "./images/" + adminName + "/" + topicName + "/" + topicName + "-" + arrCardContents[i] + ".png";
    }
    $(".flip-container").removeClass("hover");
    $(".flip-container").css("visibility", "visible");
    $(".flip-container").find(".front").css("visibility", "visible");

  }
  function dealCards(){
    console.log("dealCards()");
    onlineGameId = 0;
    onlineMyMatchCount = 0;
    onlineOtherMatchCount = 0;
    document.getElementById("animationTag").innerHTML = "";
    document.getElementById("animationTag").style.visibility = "hidden";
    topicName = $(".topics.selected").html();
    jQuery.ajax({
      type: 'POST',
      url: 'card_deal.php',
      dataType: 'json',
      data: {topic: topicName, adminName: adminName},
      success: function(obj, textstatus){
        arrCards = obj;
        setCardImgs(arrCards);
      }
    });
  }
  function joinToGame(){
    var userList = document.getElementById("curUsers");
    var elem = document.getElementById("myName");
    console.log(elem.value);
    for(i=0; i<arrUsers.length; i++){
      if(arrUsers[i].name == elem.value){
        alert("Exist user name!")
        return;
      }
    }
    userName = elem.value;
  }
  function runScript(event){
    if( event.keyCode == 13){
      joinToGame();
    }
  }
</script>
<div class="centerAlign"> 
  <div class="GameBoard">
    <div class="stepPanel">
      <div>
        <div>
          <p class="stepContent">Step1</p>
          <h2>Name</h2>
          <input type="text" name="myName" id="myName" onkeypress="runScript(event)">
        </div>
      </div>
      <div>
        <p class="stepContent">Step2</p>
        <h2>Choose a Topic</h2>
        <div id="TopicPan">
          <div id="topicContainer">
            <?php
              $dir = './images/' . $adminName . '/';
              $files = scandir($dir);
              $activeNumber = 0;
              for( $i = 0; $i < count($files); $i++){
                $dirName = $files[$i];
                if( strpos($dirName, '.') === false){
                  if($activeNumber == 0){
                    $activeNumber++;
                    echo "<p class='topics selected'>". $dirName . "</p>";
                  }else{
                    echo "<p class='topics'>". $dirName . "</p>";
                  }
                }
              }
            ?>
          </div>
        </div>
      </div>
      <p class="stepContent">Step3</p>
      <select id="curUsers" name="users" multiple>
      </select>
      <div id="cmdSendInvite">Send invite</div>
      <div id="cmdRetry" onclick="dealCards()">play again</div>
    </div>
    <div style="float: left;">
      <p id="animationTag"></p>
      <table id="cardTable">
        <?php
          for( $row = 0; $row < 3; $row++){
            echo "<tr>";
            for($col = 0; $col < 6; $col++){
              echo "<td>";
              ?>
                <div id="cardContainer<?= $row * 6 + $col ?>" cardid="<?= $row * 6 + $col ?>" class="flip-container">
                  <div class="flipper">
                    <div class="front"><img src="./assets/img/card_back.png" width="100%" height="100%"></div>
                    <div class="back">
                      <img id="img<?= $row*6+$col ?>" src="./images/images-01.png" width="100%" height="100%">
                    </div>
                  </div>
                </div>
              <?php
              echo "</td>";
            }
            echo "</tr>";
          }
        ?>
      </table>
      <p id="yourTurnTag" class="yourturnHidden">It's your turn.</p>
    </div>
    <div class="FullScore" style=" float: left;">
      <div id="ScorePan">
        <p style="padding-top: 10px;">Score</p>
      </div>
      <br>
      <div class="onlineGameScorePan">
        <table>
          <tr>
            <td id="masterName"></td>
            <td>:</td>
            <td id="masterScore"></td>
          </tr>
        </table>
      </div>
      <br>
      <div class="onlineGameScorePan">
        <table>
          <tr>
            <td id="clientName"></td>
            <td>:</td>
            <td id="clientScore"></td>
          </tr>
        </table>
      </div>
    </div>
    <div style="clear: both;"></div>
  </div>
</div>
<script type="text/javascript">dealCards();</script>
<script type="text/javascript">
function gameTimer(){
  if( onlineGameId != 0) return;
  timeSpend ++;
//  document.getElementById("timeSpend").innerHTML = timeSpend;
}
var dump_Buff;
var socket;
var arrUsers_total;
$(function () {
  arrUsers_total = [];
  socket = io.connect( 'http://cardgamemsg.herokuapp.com:80' );
  function __insert_user(__user){
    var __d = new Date();
    var __n = __d.getTime();
    __user_index = -1;
     for(i=0; i<arrUsers_total.length; i++){
      if(arrUsers_total[i].name == __user){
        __user_index = i;
        arrUsers_total[i].live_time = __n;
        break;
      }
     }
     if(__user_index == -1){
      __new_user = {};
      __new_user.name = __user;
      __new_user.live_time = __n;
      arrUsers_total[arrUsers_total.length] = __new_user;
     }
  }
  socket.on('chat message', function(msg){
    msgObj = JSON.parse(msg);
    if( msgObj.adminName != adminName)return;
    if(msgObj.type == "init"){
        __insert_user(msgObj.name);
        __refresh_users();
    }
    if(msgObj.type == "invite_deny") {
      if(msgObj.otherName == userName){
        onlineGameId = 0;
        onlineOtherName = "";
      }
    }
    if(msgObj.type == "invite_accept") {
      if(msgObj.otherName == userName){
        isMyturn = true;
        $("#masterName").html(userName);
        $("#clientName").html(msgObj.name);
      }
    }
    if(msgObj.type == "invite_send"){
      if(msgObj.otherName == userName){
        if(confirm('Someone invited you online game. Are you sure accept?')){
          onlineGameId = msgObj.gameId;
          onlineOtherName = msgObj.name;
          strBuff = msgObj.gameCards;
          arrCards = strBuff.split(",");          
          topicName = msgObj.topic;
          var topics = document.getElementsByClassName("topics");
          for( i = 0; i < topics.length; i++){
            topics[i].className = "topics";
            if(topics[i].innerHTML == topicName){
              topics[i].className += " selected";
            }
          }
          setCardImgs(arrCards);
          onlineGameEnd = false;
          isMyturn = false;
          onlineMyMatchCount = 0;
          onlineOtherMatchCount = 0;
          $("#masterName").html(userName);
          $("#clientName").html(msgObj.name);

          __user_obj = {"type": "invite_accept", "adminName":  adminName, "name":userName, "otherName": msgObj.name};
          socket.emit('chat message', JSON.stringify(__user_obj));
        } else {
          onlineGameId = 0;
          onlineOtherName = "";
          __user_obj = {"type": "invite_deny", "adminName": adminName, "name": userName, "otherName": msgObj.name};
          socket.emit('chat message', JSON.stringify(__user_obj));
        }
      }
    }
    if(msgObj.type == "card_click") {
      if(msgObj.otherName == userName){
        var idCard = msgObj.cardId;
        var elem = document.getElementsByClassName("flip-container");
        setTimeout( function(){
          cardClickEvent(elem[idCard]);
        }, 150);
      }
    }
    if(msgObj.type == "change_owber") {
      if(msgObj.otherName == userName){
        setTimeout(function(){
          isMyturn = true;
          $("#yourTurnTag").removeClass("yourturnHidden");
          $("#yourTurnTag").addClass("yourturnShow");
          setTimeout(function(){
            $("#yourTurnTag").removeClass("yourturnShow");
            $("#yourTurnTag").addClass("yourturnHidden");
          }, 1000);
        }, 1000);
      }
    }
  });
  function __refresh_users(){
      var __d = new Date();
      var __n = __d.getTime();
      arrUsers = [];
      for(i=0; i<arrUsers_total.length; i++){
        if((__n - arrUsers_total[i].live_time < 2000) && (arrUsers_total[i].name != userName))
          arrUsers[arrUsers.length] = arrUsers_total[i].name;
      }
      var el = document.getElementById("curUsers");
      arrSelUsers = [];
      var options = el && el.options;
      var opt;
      for( var i = 0, iLen = options.length; i<iLen; i++){
        opt = options[i];
        if( opt.selected){
          arrSelUsers.push( opt.text);
          break;
        }
      }
      var strHtml = "";
      for( i = 0; i < arrUsers.length; i++){
        if( arrSelUsers.indexOf(arrUsers[i]) != -1){
          strHtml += '<option value="' + arrUsers[i] + '" selected="selected">' + arrUsers[i] + '</option>';
        }else{
          strHtml += '<option value="' + arrUsers[i] + '">' + arrUsers[i] + '</option>';
        }
      }
      el.innerHTML = strHtml;
  }

  setInterval(function(){
    if(userName == "")
      return;
    __user_obj = {"type": "init", "adminName": adminName, "name": userName};
    socket.emit('chat message', JSON.stringify(__user_obj));
  }, 1000);

  function dealCards_2(){
    if(userName == ""){
      alert("You have to enter your name and join to online game.");
      return;
    }
    console.log("dealCards_2");
    onlineMyMatchCount = 0;
    onlineOtherMatchCount = 0;
    onlineGameId = 0;
    document.getElementById("animationTag").innerHTML = "";
    document.getElementById("animationTag").style.visibility = "hidden";
    jQuery.ajax({
      type: 'POST',
      url: 'card_deal.php',
      dataType: 'json',
      data: {topic: topicName, adminName: adminName},
      success: function(obj, textstatus){
        console.log("dealCards");
        arrCards = obj;
        setCardImgs(arrCards);
        if( onlineGameId != 0){
          alert("already sent invitation.");
          return;
        }
        var el = document.getElementById("curUsers");
        arrSelUsers = [];
        var options = el && el.options;
        var opt;
        for( var i = 0, iLen = options.length; i<iLen; i++){
          opt = options[i];
          if( opt.selected){
            arrSelUsers.push( opt.text);
          }
        }
        if( arrSelUsers.length == 0){
          return;
        }
        if ( arrSelUsers.length > 1) {
          alert("Select one user!");
          return;
        }
        onlineGameId = "123";
        onlineOtherName = arrSelUsers[0];
        __user_obj = {"type": "invite_send", "adminName": adminName, "name": userName, "otherName": onlineOtherName,"topic":topicName, "gameCards": arrCards.join(","), gameId: onlineGameId};
        socket.emit('chat message', JSON.stringify(__user_obj));
        console.log(__user_obj);
      }
    });
  }

  $("#cmdSendInvite").click(function(){
    dealCards_2();
  });
});

// function sleep(ms) {
//   return new Promise(resolve => setTimeout(resolve, ms));
// }
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
      data: {addTopic: topicTitle, adminName: adminName},
      success: function(obj, textstatus){
        var strHtml = "<p class='editTopics'>" + obj + "</p>";
        console.log(strHtml);
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
      data: {delTopic: selectedTopic, adminName: adminName},
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
var arrSelCards = [];
$(document).on("click", ".flip-container", function () {
  if( !isMyturn && onlineGameId != 0)
    return;
  console.log("clicked");
  cardClickEvent(this);
});
function cardClickEvent(clickedElem){
  if(IsBegin == false){
    IsBegin = true;
    clearInterval(gmTime);
    gmTime = setInterval(gameTimer, 1000);
    timeSpend = 0;
    clickCount = 0;
  }
  clickCount ++;
  if( onlineGameId != 0){   //if online Game, update db
    if( isMyturn){
      __user_obj = {"type": "card_click", "adminName": adminName, "name": userName, "otherName": onlineOtherName, "cardId": clickedElem.getAttribute("cardid"), gameId: "123"};
      socket.emit('chat message', JSON.stringify(__user_obj));
    }
  }
  if( onlineGameId == 0){
  }
  $(clickedElem).toggleClass('hover');
  arrSelCards.push(clickedElem.getAttribute("cardid"));
  if( arrSelCards.length >= 2){
    setTimeout( function(){
      checkCards();
    }, 200);
  }
}
function checkCards(){
  var Id1 = arrSelCards[0];
  var Id2 = arrSelCards[1];
  arrSelCards = [];
  if( Id1 == Id2){
    return;
  }
  var firstId = parseInt(Id1);
  var secondId = parseInt(Id2);
  if( arrCards[firstId] == arrCards[secondId]){
    if( isMyturn){
      onlineMyMatchCount ++;
    } else{
      onlineOtherMatchCount ++
    }
    document.getElementById("masterScore").innerHTML = onlineMyMatchCount;
    document.getElementById("clientScore").innerHTML = onlineOtherMatchCount;
    document.getElementById("cardContainer"+firstId).style.visibility = "hidden";
    document.getElementById("cardContainer"+secondId).style.visibility = "hidden";
    remainCount -= 2;
    if( remainCount == 0){    // Game Ended
      if( onlineGameId ){ //onlineGame Ended
        onlineGameEnd = true;
        if( onlineMyMatchCount > onlineOtherMatchCount ){
          document.getElementById("animationTag").innerHTML = "You Win!";
        } else{
          document.getElementById("animationTag").innerHTML = "You lose";
        }
        document.getElementById("animationTag").style.visibility = "visible";
        onlineGameId = 0;
      }else{
        document.getElementById("animationTag").innerHTML = "THE END";
        document.getElementById("animationTag").style.visibility = "visible";
      }
      clearInterval(gmTime);
    } 
  } else{
    setTimeout(function(){
      for( i = 0; i < 18; i++){
        if( document.getElementById("cardContainer"+i).style.visibility != "hidden")
          document.getElementById("cardContainer"+i).classList.remove("hover");
      }
    }, 500);
    if( onlineGameId != 0){
      if( isMyturn){
        console.log("No matched!");
        __user_obj = {"type": "change_owber", "adminName":adminName, "name": userName, "otherName": onlineOtherName, gameId: "123"};
        socket.emit('chat message', JSON.stringify(__user_obj));
        isMyturn = false;
      } else{

      }
    }
  }
}
</script>
<?php
} else{
  echo "<h1>You have to get your admin name.</h1>";
}
?>