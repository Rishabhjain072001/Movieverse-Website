<?php
   require 'includes/dbh.inc.php';
?>
<?php
  if(isset($_POST["query"]))
  {
	$output = '';
	$query = "SELECT * FROM movies WHERE movie_title LIKE '%".$_POST["query"]."%' LIMIT 14";
	$result = mysqli_query($conn, $query);
	$output = '<ul class="list-unstyled">';
	if(mysqli_num_rows($result) > 0)
	{
	    while($row = mysqli_fetch_array($result)){
		$output .= '<li class="movie-list">'.$row["movie_title"].'</li>';	
	    }
	   $output .= '</ul>';
	   echo $output;
	}
  }
?>

