<?php
  date_default_timezone_set('Europe/copenhagen');
  require '../includes/dbh.inc.php';
  require '../includes/comments.inc.php';
  session_start();
  $playlist_title = unescapeUTF8EscapeSeq($_GET['title']);
  $channel = unescapeUTF8EscapeSeq($_GET['channel']);
  $playlist_id = $_GET['id'];
 
  
?>
<!DOCTYPE html>
<html>
 <head>
   <title>MovieVerse</title>
   <!-- Bootstrap CSS CDN -->
   <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- Our Custom CSS -->
   <link rel="stylesheet" href="youtubeVideoPlaylistSubpage.css">
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
curl_setopt($curlSession, CURLOPT_URL, 'https://movieverse-youtube.herokuapp.com/playlistsub/'.$playlist_id);
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
$jsonData = json_decode(curl_exec($curlSession), true);
curl_close($curlSession);

?>

<?php

$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, 'http://Movieverse-youtube.herokuapp.com/apisub/'.$jsonData['videos'][0]['id']);
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

$jsonData2 = json_decode(curl_exec($curlSession), true);

curl_close($curlSession);

?>



<?php
$arry = array();
$arry2 = array('file');

$arry2 = [
    "file" => "file",
];

$count = (int)count($jsonData['videos']);
for($i = 0; $i < $count; $i++){
	$arry2['file'] ="https://www.youtube.com/watch?v=" . $jsonData['videos'][$i]['id'];
	
	array_push($arry,  $arry2);
	$arry2 = [
    "file" => "file",
];
}

?>

<script type="text/javascript">
// Some functions here
<?php
    $js_array = json_encode($arry);
    echo "var javascript_array_0 = ". $js_array . ";\n";
?>
// Output is: [object Object]

var vrr = javascript_array_0;

</script>

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



<script src="../js/playerjs.js" type="text/javascript"></script>

<div id="player" style="display:inline-block;">
<script>
 var list =vrr;

 var player = new Playerjs({"id":"player", file: list});
 setTimeout("player.api('unmute');", 1000);
</script>
</div>

<div class="grid" >
<div class="listContainer">
  <div class="listHeader">
	<div class="listHeaderL">
	  <div class="listTitle"><?php echo $playlist_title ?></div>
	  <div class="listOwner">
		<?php echo $channel ?>
	  </div>
	</div>
	<div class="listHeaderR">
	  <i class="fa fa-angle-up" id="collapse"></i>
	</div>
  </div>
  <div class="listContent" id="playlist">	
  </div>
  
  <div id="inlineright">
	<div class = 'sideVideo'>
	<?php
	for($i=0; $i<count($jsonData2['search_result']); $i++){
		echo "
		<div class='card'><a href='youtubeVideoSubpage.php?&id=".$jsonData2['search_result'][$i]['id']."&channel=".$jsonData2['search_result'][$i]['channel']."&title=".$jsonData2['search_result'][$i]['title']."'>
		<div class = 'pic'>

		<span class='ytd-thumbnail-overlay-time-status-renderer' aria-label='1 minute, 26 seconds'>
			".$jsonData2['search_result'][$i]['time']." 
			</span>
		</div>
		<p class= 'heading'>". unescapeUTF8EscapeSeq($jsonData2['search_result'][$i]['title'])." </p>
		<p class= 'subheading'>".unescapeUTF8EscapeSeq($jsonData2['search_result'][$i]['channel'])."</p>
		<p class= 'subheading2'>".unescapeUTF8EscapeSeq($jsonData2['search_result'][$i]['views']." - ".$jsonData2['search_result'][$i]['pubtime'])."</p>
		<script>
			
				document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$jsonData2['search_result'][$i]['thumbnails'][0].")';	
		</script>
		</a> </div><br>";

	}
	?>
</div>
</div>

  
</div>
</div>

<div class = "grid-container-movie">
<div class = "moviename">
   <?php echo "<h3>$playlist_title</h3><p>$channel</p>";?>
</div>
</div>
<hr>

<?php
$arr = array();
$arr2 = array('id');

$arr2 = [
    "id" => "id",
	"title" => "title",
	"owner" => "owner",
	"image" => "image",
	"length" => "length",
	"description" => "description",
	"encrypted_id" => "encrypted_id"
];

$count = (int)count($jsonData['videos']);
for($i = 0; $i < $count; $i++){
	$arr2['id'] = $i+1;
	$arr2['title'] = $jsonData['videos'][$i]['title'];
	$arr2['owner'] = $jsonData['videos'][$i]['channel']['name']; //$jsonData[$i]['meta']['author'];
    $arr2['image']  = $jsonData['videos'][$i]['thumbnails'][1]['url']; //$jsonData[$i]['meta']['thumbnail'];
   
	$arr2['description'] = $jsonData2['meta']['description']; //$jsonData[$i]['meta']['description'];
	$arr2['encrypted_id'] = $jsonData['videos'][$i]['id'];
	$arr2['length'] = $jsonData['videos'][$i]['duration'];
	/*if((int)$jsonData[$i]['meta']['length_seconds'] >= 3600){
		$arr2['length'] = gmdate("H:i:s", $jsonData[$i]['meta']['length_seconds']);
	}
	else{
		$arr2['length'] = gmdate("i:s", $jsonData[$i]['meta']['length_seconds']);
	}*/
	
	array_push($arr,  $arr2);
	$arr2 = [
    "id" => "id",
	"title" => "title",
	"owner" => "owner",
	"image" => "image",
	"length" => "length",
	"description" => "description",
	"encrypted_id" => "encrypted_id"
];
}
?>


<script type="text/javascript">
// Some functions here
<?php
    $js_array = json_encode($arr);
    echo "var javascript_array = ". $js_array . ";\n";
?>
// Output is: [object Object]
</script>

<script>

const collapseButton = document.getElementById("collapse");
const playlist = document.getElementById("playlist");

collapseButton.onclick = function () {
  if (collapseButton.className == "fa fa-angle-down") {
    collapseButton.className = "fa fa-angle-up";
    playlist.style.display = "block";
  } else {
    collapseButton.className = "fa fa-angle-down";
    playlist.style.display = "none";
  }
};

var arr = javascript_array;

arr.forEach(function (data, index) {
  var item = document.createElement("div");
  
  item.innerHTML = `
  <div class="listItem" onclick= "itemFromList(${data.id})">

  <div class="encrypted_id"  style="display:none;">${data.encrypted_id}</div>
  <div class="videoId" >${data.id}</div>
  <i class="fa fa-play" style="display:none;font-size:10px;"></i>
  <div class="itemImage">
    <img src="${data.image}" alt="" />
    <button class="itemLength">${data.length}</button>
  </div>
  <div class="itemInfo" style="padding: 0px 8px;">
    <div class="videoTitle" style="
    margin: 0 0 4px 0;
    display: -webkit-box;
    max-height: calc(2 * var(--yt-link-line-height, 1.6rem));
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    -webkit-line-clamp: 2;">${data.title}</div>

    <div class="videoOwner" style="text-overflow: ellipsis;overflow-x: hidden;white-space: nowrap;display: block;max-height: 18;overflow: hidden;font-size: 13px;">${data.owner}</div>
  </div>
  </div>
    `;
  playlist.appendChild(item);
  document.getElementsByClassName('listItem')[0].classList.add("selectedItem");
  document.getElementsByClassName('fa-play')[0].style.display = "block";
  document.getElementsByClassName('videoId')[0].style.display = "none";
  document.getElementsByClassName('moviename')[0].innerHTML = "<h3>"+<?php echo json_encode($jsonData['videos'][0]['title']); ?>+"</h3><p>"+<?php echo json_encode($jsonData2['meta']['sviews']); ?>+" - " +<?php echo json_encode($jsonData2['meta']['publishDate']); ?>+"</p>";
});

function itemFromList(index){
    var v1 = parseInt(index-1);
    player.api("find","x-" + v1.toString());
    player.api("play");
	dynamicData(index);
}



function dynamicData(index){
	
	
	var id = document.getElementsByClassName('encrypted_id')[index-1].innerHTML;
	 $.ajax({
			url: 'subpageApi.php',
			type: 'post',
			dataType: 'json',
			data: { "callFunc1": id},
			success: function(response) { 
			
			   
				document.getElementsByClassName('moviename')[0].innerHTML = "<h3>"+document.getElementsByClassName('videoTitle')[index-1].innerHTML+"</h3><p>"+response['meta']['sviews']+ " - " +response['meta']['publishDate']+"</p>";
				var i;
				for (i = 0; i < parseInt(response['search_result'].length); i++) {
					document.getElementsByClassName('card')[i].innerHTML = "<a href=youtubeVideoSubpage.php?&id="+response['search_result'][i]['id']+"&channel="+response['search_result'][i]['channel'].replace(/\s/g, '%20')+"&title="+response['search_result'][i]['title'].replace(/\s/g, '%20')+"><div class = 'pic'><span class='ytd-thumbnail-overlay-time-status-renderer' aria-label='1 minute, 26 seconds'>"+response['search_result'][i]['time']+"</span></div><p class= 'heading'>"+ response['search_result'][i]['title'] +"</p><p class= 'subheading'>"+ response['search_result'][i]['channel'] +"</p><p class= 'subheading2'>"+ response['search_result'][i]['views'] +"</p></a>";
					var link = response['search_result'][i]['thumbnails'][0];
					document.getElementsByClassName('pic')[i].style.backgroundImage = "url("+link+")";
					document.getElementsByClassName('pic')[i].style.width = "168px";
					document.getElementsByClassName('pic')[i].style.height = "94px";
					document.getElementsByClassName('pic')[i].style.backgroundSize = "100% 100%";
				}
				
				for (i = 0; i < parseInt(response['search_result'].length); i++) {
					document.getElementsByClassName('card2')[i].innerHTML = "<a href=youtubeVideoSubpage.php?&id="+response['search_result'][i]['id']+"&channel="+response['search_result'][i]['channel'].replace(/\s/g, '%20')+"&title="+response['search_result'][i]['title'].replace(/\s/g, '%20')+"><div class = 'pic2'><span class='ytd-thumbnail-overlay-time-status-renderer2' aria-label='1 minute, 26 seconds'>"+response['search_result'][i]['time']+"</span></div><p class= 'heading2'>"+ response['search_result'][i]['title'] +"</p><p class= 'subheading2'>"+ response['search_result'][i]['channel'] +"</p><p class= 'subheading22'>"+ response['search_result'][i]['views'] +"</p></a>";
					var link2 = response['search_result'][i]['thumbnails'][0];
					document.getElementsByClassName('pic2')[i].style.backgroundImage = "url("+link2+")";
					document.getElementsByClassName('pic2')[i].style.width = "168px";
					document.getElementsByClassName('pic2')[i].style.height = "94px";
					document.getElementsByClassName('pic2')[i].style.backgroundSize = "100% 100%";
				}
					
			}
		});

	
		
	
	var i, listItem;
	listItem = document.getElementsByClassName("listItem");
	for (i = 0; i < listItem.length; i++) {
	  listItem[i].classList.remove("selectedItem");
	  document.getElementsByClassName('fa-play')[i].style.display = "none";
	  document.getElementsByClassName('videoId')[i].style.display = "block";
	}
  
	document.getElementsByClassName('listItem')[index-1].classList.add("selectedItem");
	document.getElementsByClassName('fa-play')[index-1].style.display = "block";
	document.getElementsByClassName('videoId')[index-1].style.display = "none";
	
	
	var str = arr[index-1]['description'][0];
	lines = str.split(/\r\n|\r|\n/).length; 
	if(lines > 2){
	 document.getElementById("show_more_btn").style.display = "block";
	 document.getElementsByClassName('discription')[0].classList.add("hiddenlines");
	}
	var val = str.replace(RegExp("\n","g"), "<br>");  
	document.getElementsByClassName('discription')[0].innerHTML = val;
}
</script>

<script>
var pid = player.api("playlist_id");
setInterval(function(){
	var pid2 = player.api("playlist_id");
	if(pid != pid2){
		var arr3 = pid2.split("-");
		ind = parseInt(arr3[1])+1;
		
		dynamicData(ind);
		pid = pid2;
	}
},10);

</script>


<div id="discriptionBox">
<div class="imgOwner">
<?php echo "<img  src= ".$jsonData2['meta']['channel'][0][1]." >"; ?>
</div>
<div class="discriptionOwner"><?php echo  trim(unescapeUTF8EscapeSeq(json_encode($jsonData['info']['channel']['name']))	, '"'); ?></div>
<br>
<div class="discription"></div>
</div>
<button type="button" id="show_more_btn" onclick="ShowMoreFunction()">SHOW MORE</button>
<button type="button" id="show_less_btn" onclick="ShowLessFunction()">SHOW LESS</button>
<hr>


<div id="inlinebelow">
<div class = 'belowVideo'>
<?php

for($i=0; $i<count($jsonData2['search_result']); $i++){
	
	echo "
	
	
	<div class='card2'><a href='youtubeVideoSubpage.php?&id=".$jsonData2['search_result'][$i]['id']."&channel=".$jsonData2['search_result'][$i]['channel']."&title=".$jsonData2['search_result'][$i]['title']."'>
		<div class = 'pic2'>

		<span class='ytd-thumbnail-overlay-time-status-renderer2' aria-label='1 minute, 26 seconds'>
			".$jsonData2['search_result'][$i]['time']." 
			</span>
		</div>
		<p class= 'heading2'>". unescapeUTF8EscapeSeq($jsonData2['search_result'][$i]['title'])." </p>
		<p class= 'subheading'>".unescapeUTF8EscapeSeq($jsonData2['search_result'][$i]['channel'])."</p>
		<p class= 'subheading22'>".unescapeUTF8EscapeSeq($jsonData2['search_result'][$i]['views']." - ".$jsonData2['search_result'][$i]['pubtime'])."</p>
		<script>
			
				document.getElementsByClassName('pic2')[$i].style.backgroundImage = 'url(".$jsonData2['search_result'][$i]['thumbnails'][0].")';	
		</script>
		</a> </div><br>";
	
	


}
?>
</div>
</div>

<script>

var str = <?php echo json_encode($jsonData2['meta']['description'][0]); ?>;
lines = str.split(/\\r\\n|\\r|\\n/).length;

if(lines > 2){
	document.getElementById("show_more_btn").style.display = "block";
	document.getElementsByClassName('discription')[0].classList.add("hiddenlines");
}

var val = str.replace(RegExp("\n","g"), "<br>");
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