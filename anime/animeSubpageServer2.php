<?php

$sql = "SELECT * FROM animixepisodes WHERE ShowTitle = '$ShowTitle' AND ShowID = '$ShowID' ORDER BY '$EpisodeID' ";
$result = $conn->query($sql);
$arr = array();
$arr2 = array();
while($row = $result->fetch_assoc()){
		$temp = explode(".to",$row['EpisodeLink']);
		$temp2 = 'https://movieverse-anime.herokuapp.com/Animix'.$temp[1];
		array_push($arr, $temp2);	
		array_push($arr2,$row['EpisodeID']);
}	

$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, $arr[$EpisodeID-1	]);
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

$jsonData = json_decode(curl_exec($curlSession), true);
curl_close($curlSession);
?>


<script type='text/javascript'>
<?php
$js_array = json_encode($arr);
$js_array2 = json_encode($EpisodeID);
$js_array3 = json_encode($jsonData);
echo "var javascript_array = ". $js_array . ";\n";
echo "var javascript_array2 = ". $js_array2 . ";\n";
echo "var javascript_array3 = ". $js_array3 . ";\n";
?>
var vrr = javascript_array;
var EpisodeID = javascript_array2;
var link = javascript_array3;
</script>


<script src="../js/playerjs.js" type="text/javascript"></script>

<div id="player" style="display:inline-block;">
<script>
 var list = link['link'];
 var player = new Playerjs({"id":"player", file: list, autoplay:1});
 setTimeout("player.api('unmute');", 1000);
</script>
</div>

<div class="grid" >
<div class="listContainer">
  <div class="listHeader">
	<div class="listHeaderL">
	  <div class="listTitle"><?php echo $ShowTitle ?></div>
	  <div class="listOwner">
		
	  </div>
	</div>
	<div class="listHeaderR">
	  <i class="fa fa-angle-up" id="collapse"></i>
	</div>
  </div>
  <div class="listContent" id="playlist">	
  </div>
  
  <?php
  require 'subpageAnimeload2.php';
?>


<div id="inlineright">
	<div class = 'sideVideo'>
	
	
</div>
</div>

  
</div>
</div>

<div class = "grid-container-movie">
<div class = "moviename">
   <?php echo "<h3>$ShowTitle</h3><p>Episode - $EpisodeID</p>";?>
</div>
</div>

<?php
$arry = array();
$arry2 = array('id');

$arry2 = [
	"id" => "id",
    "ShowTitle" => "ShowTitle",
	"ShowID" => "ShowID",
	"image" => "image",
	"EpisodeID" => "EpisodeID",
	"AnilistID" => "AnilistID",
	"Server" => "Server",
];

for($i = 0; $i < count($arr2); $i++){
	$arry2['id'] = $i+1;
	$arry2['ShowTitle'] = $ShowTitle;
	$arry2['ShowID'] = $ShowID;
	$arry2['image'] = '../includes/uploads/no-image-available.jpg';
	$arry2['EpisodeID'] = $arr2[$i];
	$arry2['AnilistID'] = $AnilistID;
	$arry2['Server'] = $Server;
	
	
	array_push($arry,  $arry2);
	$arry2 = [
    "id" => "id",
    "ShowTitle" => "ShowTitle",
	"ShowID" => "ShowID",
	"image" => "image",
	"EpisodeID" => "EpisodeID",
	"AnilistID" => "AnilistID",
	"Server" => "Server",
];
}

?>

<script type='text/javascript'>
<?php
$js_array = json_encode($arry);
$js_array2 = json_encode($EpisodeID);
$js_array3 = json_encode($AnilistID);
echo "var javascript_array = ". $js_array . ";\n";
echo "var javascript_array2 = ". $js_array2 . ";\n";
echo "var javascript_array3 = ". $js_array3 . ";\n";
?>


</script>

<hr>
	<?php
	if ($AnilistID != NULL){
     require 'anime_discription_box.php';
	}
	
	?>
  <hr>
<script>

var AnilistID = javascript_array3;
if(AnilistID == ''){
	  
	  var arr3 = javascript_array;
	  var ind = javascript_array2;
	  arr3.forEach(function (data) {
	  var item = document.createElement("div");
	  
	  item.innerHTML = `
	  <div class="listItem" onclick= "itemFromList('${data.ShowTitle}', ${data.ShowID}, ${data.EpisodeID}, ${data.AnilistID}, ${data.Server})">
	  <div class="videoId" >${data.id}</div>
	  <i class="fa fa-play" style="display:none;font-size:10px;"></i>
	  <div class="itemImage">
		<img src="${data.image}" alt="" />
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
		-webkit-line-clamp: 2;">${data.ShowTitle}</div>

		<div class="videoOwner" style="text-overflow: ellipsis;overflow-x: hidden;white-space: nowrap;display: block;max-height: 18;overflow: hidden;font-size: 13px;">Episode - ${data.EpisodeID}</div>
	  </div>
	  </div>
		`;
	  
	  playlist.appendChild(item);
	 });
	 
	 document.getElementsByClassName('listItem')[ind-1].classList.add("selectedItem");
		document.getElementsByClassName('fa-play')[ind-1].style.display = "block";
		document.getElementsByClassName('videoId')[ind-1].style.display = "none";
	
	function itemFromList(ShowTitle, ShowID, EpisodeID, AnilistID, Server){
			window.location.href = 'animeSubpage.php?ShowTitle='+ShowTitle+'&ShowID='+ShowID+'&EpisodeID= '+EpisodeID+'&AnilistID= '+AnilistID+'&Server= '+Server;
		}
}

</script>


<div id="inlinebelow">
<div class = 'belowVideo'>
<?php

function getData($AnilistID){
	  $query = '
	query ($id: Int) { # Define which variables will be used in the query (id)
	  Media (id: $id, type: ANIME) { # Insert our variables into the query arguments (id) (type: ANIME is hard-coded in the query)
		id
		genres
		episodes
		bannerImage
		coverImage {
		 extraLarge
		 large
		 medium
		 color
		}
		description
		title {
		  romaji
		  english
		  native
		}
	  }
	}
	';

	// Define our query variables and values that will be used in the query request
	$variables = [
		"id" => $AnilistID
	];

	// Make the HTTP Api request
	$http = new GuzzleHttp\Client;
	$response = $http->post('https://graphql.anilist.co', [
		'json' => [
			'query' => $query,
			'variables' => $variables,
		]
	]);
	$contents = (string) $response->getBody();
	$Data = json_decode($contents, true);
	return $Data;
	
   }

$sql = "SELECT * FROM animixshow ORDER BY ShowID  LIMIT $ShowID, 8";
$result = mysqli_query($conn, $sql);
$queryResult = mysqli_num_rows($result);
if ($queryResult > 0) {
  $ind = 0; 
   While ($row = mysqli_fetch_assoc($result)){
	 if($row['AnilistID'] != Null){
		$Data = getData($row['AnilistID']);
		$genres='';
		for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
			$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
		}
		
		echo "<div class ='card2'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
		<div class='pic2' >
		
		</div>
		
		<p class='heading2'>".$Data['data']['Media']['title']['romaji']."
		<p class='subheading'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
		<p class='subheading22'>Episode - ".$Data['data']['Media']['episodes']."</p>
		<p class='subheading22'>".$genres."</p>
		

		<script>
			
			document.getElementsByClassName('pic2')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
			
		</script>
		</a></div>";
		
	}
	else{
		echo "<div class ='card2'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
		<div class='pic2' >
		
		</div>
		
		<p class='heading2'>".$row['ShowTitle']."
		<p class='subheading'>s </p>
		<p class='subheading22'> s</p>
		

		<script>
			
			document.getElementsByClassName('pic2')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
			
		</script>
		</a></div>";
		
	}
	$ind++;
   }
}
	
?>
</div>
</div>
