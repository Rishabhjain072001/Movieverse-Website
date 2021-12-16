<?php

require '../includes/dbh.inc.php';



if(isset($_POST["limit"], $_POST["start"])){

$start = $conn->real_escape_string($_POST['start']);
$limit = $conn->real_escape_string($_POST['limit']);

$i = $start;
   
$sql = "SELECT * FROM homepagedatasingle ORDER BY video_id  LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
$queryResult = mysqli_num_rows($result);
if ($queryResult > 0) {
		While ($row = mysqli_fetch_assoc($result)){
		if($row['duration'] == 'Null'){
			$duration = 'Live';		
		}
		else{
			$duration = $row['duration'];	
		}
		
		if($row['pubtime'] == 'Null'){
			$pubtime = 'Live Now';		
		}
		else{
			$pubtime = $row['pubtime'];	
		}
	echo "
	   <div class='card'><a href='youtubeVideoSubpage.php?&id=".$row['id']."&channel=".$row['channel']."&title=".$row['title']."'>
			<div class = 'pic'>
			
			<span class='ytd-thumbnail-overlay-time-status-renderer' aria-label='1 minute, 26 seconds'>
				
				".$duration." 
				</span>
			</div>
			<img class='channelimg' src=".$row['channelImage']."  width='40px'>
			<p class= 'heading'>
			".$row['title']." 
			
			</p>
			<p class= 'subheading'>".$row['channel']."</p>
			<p class= 'subheading2'>".$row['videoViews']." - ".$pubtime."</p>
			<script>
			
					document.getElementsByClassName('card')[$i].addEventListener('mouseover', mouseOver);
					document.getElementsByClassName('card')[$i].addEventListener('mouseout', mouseOut);
					
					function mouseOver() {
						document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$row['richthumb'].")';
						if(document.getElementsByClassName('pic')[$i].style.backgroundImage == 'url(\"Null\")'){
							document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$row['thumbnail'].")';
						}
						
					}

					function mouseOut() {
					  document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$row['thumbnail'].")';
					}
					
					document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$row['thumbnail'].")';
					
			</script>
	   </a> </div>
	   
	   ";	
	   $i=$i+1;
	}
}

}

?>