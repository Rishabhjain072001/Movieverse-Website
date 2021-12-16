<?php
    require '../includes/dbh.inc.php';
	require 'vendor/autoload.php';
?>

<?php

   if(isset($_POST["limit"], $_POST["start"])){
	   
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

	
	$start = $conn->real_escape_string($_POST['start']);
	$limit = $conn->real_escape_string($_POST['limit']);
	$ind = $conn->real_escape_string($_POST['ind']);
	$defaultEpisodeID =1;
	 
	$sql = "SELECT * FROM animixshow ORDER BY ShowID  LIMIT $start, $limit";
	$result = mysqli_query($conn, $sql);
	$queryResult = mysqli_num_rows($result);
	if ($queryResult > 0) {
		   
            While ($row = mysqli_fetch_assoc($result)){
				
				if($row['AnilistID'] != Null){
					$Data = getData($row['AnilistID']);
					$genres='';
					for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
						$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
					}
					
					echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					<div class='pic' >
					
					</div>
					
					<p class='heading'>".$Data['data']['Media']['title']['romaji']."
					<p class='subheading'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
					<p class='subheading2'>Episode - ".$Data['data']['Media']['episodes']."</p>
					<p class='subheading2'>".$genres."</p>
					
			
					<script>
						
						document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
						
					</script>
					</a></div>";
					$ind++;
				}
				else{
					echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					<div class='pic' >
					
					</div>
					
					<p class='heading'>".$row['ShowTitle']."
					<p class='subheading'>s </p>
					<p class='subheading2'> s</p>
					
			
					<script>
						
						document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
						
					</script>
					</a></div>";
					$ind++;
				}
				
					
	    }
	}
	else{
	  $sql = "SELECT * FROM animixshow ORDER BY ShowID  LIMIT 1, 12";
	  $result = mysqli_query($conn, $sql);
	  $queryResult = mysqli_num_rows($result);
	  if ($queryResult > 0) {
            While ($row = mysqli_fetch_assoc($result)){
				if($row['AnilistID'] != Null){
					$Data = getData($row['AnilistID']);
					$genres='';
					for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
						$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
					}
					
					echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					<div class='pic' >
					
					</div>
					
					<p class='heading'>".$Data['data']['Media']['title']['romaji']."
					<p class='subheading'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
					<p class='subheading2'>Episode - ".$Data['data']['Media']['episodes']."</p>
					<p class='subheading2'>".$genres."</p>
					
			
					<script>
					
						document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
						
					</script>
					</a></div>";
					$ind++;
				}
				else{
					echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					<div class='pic' >
					
					</div>
					
					<p class='heading'>".$row['ShowTitle']."
					<p class='subheading'> </p>
					<p class='subheading2'> </p>
					
			
					<script>
						
						document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
						
					</script>
					</a></div>";
					$ind++;
				}
				
	    }
	  }
	}
		
  }
?>