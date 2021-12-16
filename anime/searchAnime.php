<?php
   date_default_timezone_set('Europe/copenhagen');
  
  
   require '../includes/dbh.inc.php';
   require '../includes/comments.inc.php';
  require 'vendor/autoload.php';
   session_start();
   
?>

<!DOCTYPE html>
<html>
 <head>
   <!-- Bootstrap CSS CDN -->
      <!-- Our Custom CSS -->
   <link rel="stylesheet" href="searchAnime6.css">
   <link rel="stylesheet" type="text/css"  href="css/all.css">
   
   <title>MovieVerse</title>
  </head>
  <body>
   <header>
        <?php
          require 'headerofanimeHome.php';
        ?>
	
    </header>
	

  

    
  <div class="search">
  
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
	
	if (isset($_GET['submit-search'])){
	    
		if (empty($_GET['search'])){
			header('Location:youtubeVideoHome.php');
		 }
		else{
			$defaultEpisodeID = 1;
			$ind = 0;
			$buttonColor = array('#FF4F03', '#C71585', '#000080', '#8B0000', '#008000', '#ff8000', '#0066ff', '#618624', '#FF4F03', '#C71585', '#E67E22', '#1ABC9C ', '#9B59B6', '#008000', '#ff8000', '#8B0000', '#0099ff', '#ff33cc','#000080','#D7A60E');
		   $search = mysqli_real_escape_string($conn, trim($_GET['search']));
		   echo "<h2 class='heading'>Showing result for ' $search '<br><br></h2>";
		   $words = explode(" ",  $search);
		   $Count = count($words);
		   $arr = array(); 
		   $arr2 = array();
		   for($x = 0; $x < $Count; $x++)
		   {
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '%$words[$x]%' UNION ALL SELECT * FROM animixshow WHERE ShowTitle LIKE '%$words[$x]%'";
			
			$result = mysqli_query($conn, $sql);
			$queryResult = mysqli_num_rows($result);
			if ($queryResult > 0) {
				   While ($row = mysqli_fetch_assoc($result)){
				  if(array_key_exists($row['ShowTitle'],$arr))
				  {
					 $arr[$row['ShowTitle']]++;
						  }
				  else
				  {
				
					$arr[$row['ShowTitle']] = 1; 

				  }
				   }
				}
		   }
		   arsort($arr);
		   $keys = array_keys($arr);
		   $Count_keys = count($keys);
		   if ($Count_keys > 4)
		   {
			 for($x = 0; $x < 4; $x++)
			 {
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '$keys[$x]'";
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '$keys[$x]' UNION ALL SELECT * FROM animixshow WHERE ShowTitle LIKE '$keys[$x]'";
			$result = mysqli_query($conn, $sql);
			$queryResult = mysqli_num_rows($result);
			if ($queryResult > 0) {
				  While ($row = mysqli_fetch_assoc($result)){
				  
					if (!array_key_exists($row['ShowTitle'],$arr2))
					{
						if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						
						$arr2[$row['ShowTitle']] = array($row['Server']);
						$arr2[$row['ShowTitle']][1] = $row['Language'];
					}
					
					else
					{
					  if (!in_array($row['Server'], $arr2[$row['ShowTitle']]) || !in_array($row['Language'], $arr2[$row['ShowTitle']]))
					  {
					   if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
					   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Server'];
					   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Language'];
					  }

					}
					
				  
				  }
				}
		   
			 }
		   }
		   else{
			  for($x = 0; $x < $Count_keys; $x++)
			  {
			
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '$keys[$x]' UNION ALL SELECT * FROM animixshow WHERE ShowTitle LIKE '$keys[$x]'";
			$result = mysqli_query($conn, $sql);
			$queryResult = mysqli_num_rows($result);
			if ($queryResult > 0) {
				  While ($row = mysqli_fetch_assoc($result)){
					if (!array_key_exists($row['ShowTitle'],$arr2))
					{
						
						if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						
						$arr2[$row['ShowTitle']] = array($row['Server']);
						$arr2[$row['ShowTitle']][1] = $row['Language'];
					}
					
					else
					{	
						if (!in_array($row['Server'], $arr2[$row['ShowTitle']]) || !in_array($row['Language'], $arr2[$row['ShowTitle']]))
						{
						  if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Server'];
						   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Language'];
						}

					 }
				  
				  }
				}
		   
			   }
		   }
		   

		   
		   $sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '%$search%' UNION ALL SELECT * FROM animixshow WHERE ShowTitle LIKE '%$search%'";
			   $result = mysqli_query($conn, $sql);
		   $queryResult = mysqli_num_rows($result);
				
		   
		   $Split = str_split($search);
		   $Count = count($Split);
			   $arr = array(); 
		   for($x = 0; $x < $Count; $x++)
		   {
			$Split[$x]=mysqli_real_escape_string($conn, $Split[$x]);
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '%$Split[$x]%'";
			$result = mysqli_query($conn, $sql);
			$queryResult = mysqli_num_rows($result);
			if ($queryResult > 0) {
				   While ($row = mysqli_fetch_assoc($result)){
				  if(array_key_exists($row['ShowTitle'],$arr))
				  {
					 $arr[$row['ShowTitle']]++;
						  }
				  else
				  {
				
				$arr[$row['ShowTitle']] = 1; 

				  }
				   }
				}
		   }
		   arsort($arr);
		   $keys = array_keys($arr);
		   $Count_keys = count($keys);
		   for($x = 0; $x < $Count_keys; $x++)
		   {
			$Split_keys = str_split($keys[$x]);
			if (strcasecmp($Split_keys[0],$Split[0])!==0)
			{
			  unset($keys[$x]);
			}
			   }
		   $keys= array_values($keys);
		   $Count_keys = count($keys);
		   if ($Count_keys > 10){
			  for($x = 0; $x < 10; $x++)
			  {
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '$keys[$x]' UNION ALL SELECT * FROM animixshow WHERE ShowTitle LIKE '$keys[$x]'";
			
			$result = mysqli_query($conn, $sql);
			$queryResult = mysqli_num_rows($result);
			if ($queryResult > 0) {
				  While ($row = mysqli_fetch_assoc($result)){
					if (!array_key_exists($row['ShowTitle'],$arr2))
					{
						if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						
						$arr2[$row['ShowTitle']] = array($row['Server']);
						$arr2[$row['ShowTitle']][1] = $row['Language'];
					}
					
					else
					{
						if (!in_array($row['Server'], $arr2[$row['ShowTitle']]) || !in_array($row['Language'], $arr2[$row['ShowTitle']]))
						{
						   if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Server'];
						   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Language'];
						}

					}
				  
				  }
				}
		   
			 }
		   
		 }
		 else{
		  for($x = 0; $x < $Count_keys; $x++)
			  {
			
			$sql = "SELECT * FROM Shows WHERE ShowTitle LIKE '$keys[$x]' UNION ALL SELECT * FROM animixshow WHERE ShowTitle LIKE '$keys[$x]'";
			$result = mysqli_query($conn, $sql);
			$queryResult = mysqli_num_rows($result);
			if ($queryResult > 0) {
				  While ($row = mysqli_fetch_assoc($result)){
					if (!array_key_exists($row['ShowTitle'],$arr2))
					{
						if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						
						$arr2[$row['ShowTitle']] = array($row['Server']);
						$arr2[$row['ShowTitle']][1] = $row['Language'];
					}
					
					else
					{
						if (!in_array($row['Server'], $arr2[$row['ShowTitle']]) || !in_array($row['Language'], $arr2[$row['ShowTitle']]))
						{
						   if($row['AnilistID'] != Null){
							$Data = getData($row['AnilistID']);
							$genres='';
							for($i = 0; $i < count($Data['data']['Media']['genres']); $i++){
								$genres = $Data['data']['Media']['genres'][$i].' . '.$genres;
							}
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
				
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$Data['data']['Media']['title']['romaji']." [Server - ".$row['Server']."]
							<p class='title'>".$Data['data']['Media']['title']['english']." - ".$Data['data']['Media']['title']['native']."</p>
							<p class='title'>Episode - ".$Data['data']['Media']['episodes']." (".$row['Language'].")</p>
							<p class='title'>".$genres."</p>
							</div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(".$Data['data']['Media']['coverImage']['large'].")';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						else{
							echo "<div class ='card'><a href='animeSubpage.php?ShowTitle=".$row['ShowTitle']."&ShowID=".$row['ShowID']."&EpisodeID= ".$defaultEpisodeID."&AnilistID=".$row['AnilistID']."&Server=".$row['Server']."'>
					
							<i class='fas fa-arrow-right'></i>
							<div class='discription'>".$row['ShowTitle']." [Server - ".$row['Server']."]
							<p class='title'>(".$row['Language'].")</p></div>
							<div class='pic' >
							
							</div>
							
							<button>
							</button>
							<script>
								document.getElementsByClassName('pic')[$ind].style.backgroundImage = 'url(../includes/uploads/no-image-available.jpg)';
								document.getElementsByClassName('card')[$ind].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$ind]';
							</script>
							</a></div>";
							$ind++;
						}
						   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Server'];
						   $arr2[$row['ShowTitle']][count($arr2[$row['ShowTitle']])] = $row['Language'];
						}

					}
				   
				  }
				}
		   
			 }
		}  
		}
	}
	
	
  ?>
  
</div>
 


<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

<!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
	     var width;
		window.onresize = window.onload = function() {
    		width = this.outerWidth;
		if (width >= 1433){
		  document.getElementsByClassName("search")[0].style.marginLeft = "18%";	
   		}
		else if (width >= 1285){
		  document.getElementsByClassName("search")[0].style.marginLeft = "21%";	
   		}
    		else if (width >= 1267){
		  document.getElementsByClassName("search")[0].style.marginLeft = "19%";	
   		}
		else if (width >= 1263){
		  document.getElementsByClassName("search")[0].style.marginLeft = "10%";	
   		}
	     }
	
             $(document).ready(function () {
		 var act = "off";
                  $('#sidebarCollapse').on('click', function () {
		  if (act === "off"){	
			var w = window.outerWidth;
		  	$('#sidebar').toggleClass('active'); 
			if (w <= 523){
			 document.getElementsByClassName("search")[0].style.marginLeft = "21%";
			}
			else{
			  document.getElementsByClassName("search")[0].style.marginLeft = "11%";
			}
                         act ="on";
		  }  
		  else if (act === "on"){
			 var w = window.outerWidth;
			 $('#sidebar').toggleClass('active');
			 if (w <= 517){
			  document.getElementsByClassName("search")[0].style.marginLeft = "15%";
			 }
			 else if (w <= 1263){
			  document.getElementsByClassName("search")[0].style.marginLeft = "8%";
			 }
			 else if (w <= 1359){
			  document.getElementsByClassName("search")[0].style.marginLeft = "20%";
			 }
			 else{
		     	   document.getElementsByClassName("search")[0].style.marginLeft = "18%";
			 }
                     	 act ="off";
		     }
		 });	
             });
         </script>

</body>
</html>
