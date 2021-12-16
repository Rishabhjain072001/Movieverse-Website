<?php
  date_default_timezone_set('Europe/copenhagen');
  require '../includes/dbh.inc.php';
  require '../includes/comments.inc.php';
  session_start();
  $title = unescapeUTF8EscapeSeq($_GET['title']);
  $channel = unescapeUTF8EscapeSeq($_GET['channel']);
  $video_id = $_GET['id'];
 
  $video_link ="https://www.youtube.com/watch?v=" . $video_id;
?>
<!DOCTYPE html>
<html>
 <head>
   <title>MovieVerse</title>
   <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
   <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- Our Custom CSS -->
   <link rel="stylesheet" href="youtubeVideoSubpage2.css">
   <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <style>
   #player iframe {
    pointer-events: none;
   }
  </style>


<script type='text/javascript' src="//wurfl.io/wurfl.js"></script>
<script>

if (WURFL.is_mobile === true) {
    window.location.replace("http://mob.movieverse.unaux.com");
}
</script>
  </head>


  <body>
   <header>
    
	<?php
          require 'headerofyoutubeVideoHome.php';
        ?>
</header>


<?php

$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, 'http://Movieverse-youtube.herokuapp.com/apisub/'.$video_id);
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

$jsonData = json_decode(curl_exec($curlSession), true);
curl_close($curlSession);
?>

<?php
function unescapeUTF8EscapeSeq($str)
{
	return preg_replace_callback(
		"/\\\u([0-9a-f]{4})/i",
		function ($matches) {
			return html_entity_decode('&#x' . $matches[1] . ';', ENT_QUOTES, 'UTF-8');
		},
		$str
	);
}

?>

<div id="inlineright">
<div class = 'sideVideo'>
<h3>Up next<h3>
<?php
$line = "off";
for($i=0; $i<count($jsonData['search_result']); $i++){
	echo "
	<div class='card'><a href='youtubeVideoSubpage.php?&id=".$jsonData['search_result'][$i]['id']."&channel=".$jsonData['search_result'][$i]['channel']."&title=".$jsonData['search_result'][$i]['title']."'>
	<div class = 'pic'>

	<span class='ytd-thumbnail-overlay-time-status-renderer' aria-label='1 minute, 26 seconds'>
		".$jsonData['search_result'][$i]['time']." 
		</span>
	</div>
	<p class= 'heading'>".unescapeUTF8EscapeSeq($jsonData['search_result'][$i]['title'])." </p>
	<p class= 'subheading'>".unescapeUTF8EscapeSeq($jsonData['search_result'][$i]['channel'])."</p>
	<p class= 'subheading2'>".unescapeUTF8EscapeSeq($jsonData['search_result'][$i]['views']." - ".$jsonData['search_result'][$i]['pubtime'])."</p>
	<script>
		
			document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$jsonData['search_result'][$i]['thumbnails'][0].")';	
	</script>
	</a> </div><br>";
	if($line == "off"){
		echo "<hr style='width:100%; margin-top:-3px; margin-bottom:20px;'>";
		$line = "on";
	}

}
?>
</div>
</div>

<script src="../js/playerjs.js" type="text/javascript"></script>
<div id="player">
<script>
var video_link = <?php echo json_encode($video_link); ?>;
 var player = new Playerjs({"id":"player", "file": video_link});
 setTimeout("player.api('unmute');", 1000);
</script>
</div>

<div class = "grid-container-movie">
<div class = "moviename">
   <?php echo "<h3>$title</h3><p>".$jsonData['meta']['sviews'][0]." - ".$jsonData['meta']['publishDate'][0]."</p>";?>
</div>
</div>
<hr>

<div id="discriptionBox">
<div class="imgOwner">
<?php echo "<img  src= ".$jsonData['meta']['channel'][0][1]." >"; ?>
</div>

<div class="discriptionOwner">
<?php echo $channel; ?>
</div>
<br>
<div class="discription"></div>
</div>
<button type="button" id="show_more_btn" onclick="ShowMoreFunction()">SHOW MORE</button>
<button type="button" id="show_less_btn" onclick="ShowLessFunction()">SHOW LESS</button>
<hr>


<script>
var str = <?php echo json_encode($jsonData['meta']['description'][0]); ?>;
lines = str.split(/\r\\n|\r|\\n/).length; 
if(lines > 2){
	document.getElementById("show_more_btn").style.display = "block";
	document.getElementsByClassName('discription')[0].classList.add("hiddenlines");
}

var val = str.replace(RegExp("\\\\n","g"), "<br>");
document.getElementsByClassName('discription')[0].innerHTML = val;

function ShowMoreFunction(){
	document.getElementsByClassName('discription')[0].classList.remove("hiddenlines");
	document.getElementById("show_more_btn").style.display = "none";
	document.getElementById("show_less_btn").style.display = "block";
}

function ShowLessFunction(){
	document.getElementsByClassName('discription')[0].classList.add("hiddenlines");
	document.getElementById("show_more_btn").style.display = "block";
	document.getElementById("show_less_btn").style.display = "none";
}

</script>


<div id="inlinebelow">
<div class = 'belowVideo'>
<h3>Up next<h3>
<?php
$line = "off";
for($i=0; $i<count($jsonData['search_result']); $i++){
	echo "
	<div class='card2'><a href='youtubeVideoSubpage.php?&id=".$jsonData['search_result'][$i]['id']."&channel=".$jsonData['search_result'][$i]['channel']."&title=".$jsonData['search_result'][$i]['title']."'>
	<div class = 'pic2'>

	<span class='ytd-thumbnail-overlay-time-status-renderer2' aria-label='1 minute, 26 seconds'>
		".$jsonData['search_result'][$i]['time']." 
		</span>
	</div>
	<p class= 'heading2'>".unescapeUTF8EscapeSeq($jsonData['search_result'][$i]['title'])." </p>
	<p class= 'subheadingg2'>".unescapeUTF8EscapeSeq($jsonData['search_result'][$i]['channel'])."</p>
	<p class= 'subheading22'>".unescapeUTF8EscapeSeq($jsonData['search_result'][$i]['views']." - ".$jsonData['search_result'][$i]['pubtime'])."</p>
	<script>
		
			document.getElementsByClassName('pic2')[$i].style.backgroundImage = 'url(".$jsonData['search_result'][$i]['thumbnails'][0].")';	
	</script>
	</a> </div><br>";
	if($line == "off"){
		echo "<hr style='width:95%; margin-top:-3px; margin-bottom:20px;'>";
		$line = "on";
	}

}
?>
</div>
</div>

<!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
          
         <script type="text/javascript">
             $(document).ready(function () {
                 var act = "off";
                 $('#sidebarCollapse').on('click', function () {
                   if (act === "off"){
                     $('#sidebar').toggleClass('active');
		      document.body.style.backgroundColor = "rgba(0, 0, 0, 0.95)";
                     act ="on";
		   }
                   else if (act === "on"){
			 $('#sidebar').toggleClass('active');
		     	document.body.style.backgroundColor = "#1a1a1a";
                     	act ="off";
		   }
                 });
             });
         </script>


</script>

   </body>


</html>