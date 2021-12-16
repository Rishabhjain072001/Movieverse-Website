<?php	
  require 'includes/dbh.inc.php';
?>
<h3>Up next</h3>
<?php

	$movieNewCount = $_POST['movieNewCount'];
	$movieid = $_POST['movie_id'];		
	$sql = "SELECT * FROM movies LIMIT $movieid, $movieNewCount";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 1){
	  while ($row = mysqli_fetch_assoc($result)){
	      echo "<a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."'><div class ='search-box'>
		    <div class = 'grid-container2'>
		    <img src=".$row['movie_img']."  height='200'>
		    <p class= 'heading'>".$row['movie_title']." </p>
		    <p class= 'subheading'>".$row['movie_lang']."</p>
		    <p class= 'subheading'>".$row['release_date']."</p>
		   </div></a> ";
	  }
	}
	else{
	  $movieNewCount = $_POST['movieNewCount'];		
	  $sql = "SELECT * FROM movies LIMIT 0, $movieNewCount";
	  $result = mysqli_query($conn, $sql);
	  if (mysqli_num_rows($result) > 0){
	    while ($row = mysqli_fetch_assoc($result)){
	      echo "<a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."'><div class ='search-box'>
		    <div class = 'grid-container2'>
		    <img src=".$row['movie_img']."  height='200'>
		    <p class= 'heading'>".$row['movie_title']." </p>
		    <p class= 'subheading'>".$row['movie_lang']."</p>
		    <p class= 'subheading'>".$row['release_date']."</p>
		    </div></a>";
	    }
	  }
	}
  ?>