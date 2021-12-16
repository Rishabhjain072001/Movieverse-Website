<?php
    require 'includes/dbh.inc.php';
?>
<?php
   if(isset($_POST["limit"], $_POST["start"])){
	
	$start = $conn->real_escape_string($_POST['start']);
	$limit = $conn->real_escape_string($_POST['limit']);
       
	$sql = "SELECT * FROM movies ORDER BY movie_id  LIMIT $start, $limit";
	$result = mysqli_query($conn, $sql);
	$queryResult = mysqli_num_rows($result);
	if ($queryResult > 0) {
            While ($row = mysqli_fetch_assoc($result)){
		echo "<div class = grid-container><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
		    <img src=".$row['movie_img']." width='70%' height='250'>
		    <p class= 'heading'>".$row['movie_title']." </p>
		    <p class= 'subheading'>".$row['movie_lang']."</p>
		    <p class= 'subheading'>".$row['release_date']."</p>
		    
		   </a></div>";	
	    }
	}
	else{
	  $sql = "SELECT * FROM movies ORDER BY movie_id  LIMIT 1, 12";
	  $result = mysqli_query($conn, $sql);
	  $queryResult = mysqli_num_rows($result);
	  if ($queryResult > 0) {
            While ($row = mysqli_fetch_assoc($result)){
		echo "<div class = grid-container><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
		  
		    <img src=".$row['movie_img']." width='70%' height='250'>
		    <p class= 'heading'>".$row['movie_title']." </p>
		    <p class= 'subheading'>".$row['movie_lang']."</p>
		    <p class= 'subheading'>".$row['release_date']."</p>
		   </a></div>";	
	    }
	  }
	}
		
  }
?>