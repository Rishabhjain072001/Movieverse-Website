<?php
  date_default_timezone_set('Europe/copenhagen');
  require 'includes/dbh.inc.php';
  require 'includes/comments.inc.php';
  session_start();
  $movie_title = mysqli_real_escape_string($conn, trim($_GET['movie_title']));
  $movie_id = mysqli_real_escape_string($conn, trim($_GET['movie_id']));
  $release_date = mysqli_real_escape_string($conn, trim($_GET['release_date']));
  $movie_lang = mysqli_real_escape_string($conn, trim($_GET['movie_lang']));
  $tmdb_id = mysqli_real_escape_string($conn, trim($_GET['tmdb_id']));
?>
<!DOCTYPE html>
<html>
 <head>
   <title>MovieVerse</title>
   <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- Our Custom CSS -->
   <link rel="stylesheet" href="subpage1.css">
   <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>


  <body>
   <header>
    
	<?php
          require 'headerofhomepage.php';
        ?>
</header>
<?php
   if (empty($_GET['movie_title']) && empty($_GET['movie_id']) && empty($_GET['release_date']) && empty($_GET['movie_lang']) && empty($_GET['tmdb_id'])){
	header('Location:index.php');
   }
   else{
   	

 	$sql = "SELECT * FROM q_480p WHERE movie_title='$movie_title' AND movie_id='$movie_id'";
   	$result = mysqli_query($conn, $sql);
   	$queryResults = mysqli_num_rows($result);

   	if ($queryResults > 0){
		$row = mysqli_fetch_assoc($result);
		$link_480p = $row['movie_flix'];
   	}

   	$sql = "SELECT * FROM q_720p WHERE movie_title='$movie_title' AND movie_id='$movie_id'";
   	$result = mysqli_query($conn, $sql);
   	$queryResults = mysqli_num_rows($result);

   	if ($queryResults > 0){
		$row = mysqli_fetch_assoc($result);
		$link_720p = $row['movie_flix'];
   	}

   	$sql = "SELECT * FROM q_1080p WHERE movie_title='$movie_title' AND movie_id='$movie_id'";
   	$result = mysqli_query($conn, $sql);
   	$queryResults = mysqli_num_rows($result);

   	if ($queryResults > 0){
		$row = mysqli_fetch_assoc($result);
		$link_1080p = $row['movie_flix'];
   	}
   }
   
?>

<script>
var link_480p = <?php echo json_encode($link_480p); ?>;
var link_720p = <?php echo json_encode($link_720p); ?>;
var link_1080p = <?php echo json_encode($link_1080p); ?>;
</script>

<?php
  require 'includes/subpagemovieload.php';
?>

<div id ="div1">
<h3>Up next</h3>	
</div>


<script src="js/playerjs.js" type="text/javascript"></script>
<div id="player">
<script src="js/player1.js" type="text/javascript"></script>
</div>


<div class = "grid-container-movie">	
<div class = "moviename">
   <?php echo "<h3>$movie_title</h3><br><p>$movie_lang</p>";?>
   <?php 
    if ($release_date !== "0"){
	echo "<p>$release_date<p>";
    }	
   ?>
</div>
<?php
  require 'includes/download.inc.php';	
?>
</div>
<hr>
<?php
   if ($tmdb_id != 0){
     require 'discription_box.php';
   }
?>
<hr>

<?php
  require 'includes/subpagesmallsizemovieload.php';
?>


<div id = "div2">
<h3>Up next</h3>
  <?php
	$sql = "SELECT * FROM movies LIMIT $movie_id,2";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0){
	  while ($row = mysqli_fetch_assoc($result)){
		echo "<a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
		    <div class = 'grid-container2'>
		    <img src=".$row['movie_img']." height='170'>
		    <p class= 'heading'>".$row['movie_title']." </p>
		    <p class= 'subheading'>".$row['movie_lang']."</p>
		    <p class= 'subheading'>".$row['release_date']."</p>
		   </div></a>";
	  }
	}
	else{
	 $sql = "SELECT * FROM movies LIMIT 0,2";
	 $result = mysqli_query($conn, $sql);
	 if (mysqli_num_rows($result) > 0){
	  while ($row = mysqli_fetch_assoc($result)){
		echo "<a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
		    <div class = 'grid-container2'>
		    <img src=".$row['movie_img']." height='200'>
		    <p class= 'heading'>".$row['movie_title']." </p>
		    <p class= 'subheading'>".$row['movie_lang']."</p>
		    <p class= 'subheading'>".$row['release_date']."</p>
		   </div></a>";
	  }
	 }
	}
  ?>
</div>
<button id = "showmorebtn">Show more</button>



<div class="commentsection">
	 <?php
	 $sqlCount = "SELECT COUNT(cid) FROM comments WHERE movie_id = '$movie_id' AND movie_title = '$movie_title'";
	 $resultCount = $conn->query($sqlCount);
	 $Count = $resultCount->fetch_assoc();
         echo "<p>", $Count['COUNT(cid)'] ," Comments</p><br>" ;
	?>

	   <section class="section-default">
	     <?php
		if (isset($_SESSION['userId'])){ 
		   

		    echo "<form method='POST' action='includes/writecomment.php'>
        	    <input type ='hidden' name='uidUsers' value='".$_SESSION['userId']."'>
  	            <input type = 'hidden' name='date' value='".date('Y-m-d H:i:s')."'>
		    <input type = 'hidden' name='movie_title' value='$movie_title'>
		    <input type = 'hidden' name='movie_id' value='$movie_id'>
		    <input type = 'hidden' name='release_date' value='$release_date'>
		    <input type = 'hidden' name='movie_lang' value='$movie_lang'>
		     <input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
  	            <textarea id='textarea' name ='message' placeholder='Add a public comment....'></textarea><br>
  	            <button class ='comment-btn' type='submit' name='commentSubmit'>Comment</button>
                   </form><br><br>"; 
		}
		else{
		    echo "<h3>you need to be logged in to comment!</h3>";	
		}
	      getComments($conn);
	     ?>
	      
	  </section>
</div>

<script>
var textarea = document.getElementById("textarea");

textarea.oninput = function() {
  textarea.style.height = "";
  textarea.style.height = Math.min(textarea.scrollHeight) + "px";
};
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


   </body>
</html>