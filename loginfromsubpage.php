<title>MovieVerse</title>
<link rel="stylesheet" type="text/css" href="login2.css">

     <main>
	<?php
	  if(isset($_GET['movie_title']) && isset($_GET['movie_id']) && isset($_GET['release_date']) && isset($_GET['movie_lang']) && isset($_GET['tmdb_id'])){
			$movie_title =  $_GET['movie_title'];
	       		$movie_id =  $_GET['movie_id'];
  			$release_date = $_GET['release_date'];
			$movie_lang = $_GET['movie_lang'];
			$tmdb_id = $_GET['tmdb_id'];
		}
		else{
			$movie_title =  $_POST['movie_title'];
	        	$movie_id =  $_POST['movie_id'];
			$release_date = $_POST['release_date'];
			$movie_lang = $_POST['movie_lang'];
			$tmdb_id = $_POST['tmdb_id'];
		}
	?>
	<div class="Login">
	   <section class="section-default">
		<a href="subpage.php?movie_title=<?php echo $movie_title ?>&movie_id=<?php echo $movie_id ?>&release_date=<?php echo $release_date ?>&movie_lang= <?php echo $movie_lang ?>&tmdb_id=<?php echo $tmdb_id ?>">
		<svg class='arrow-left' width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  		<path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  		<path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
		</svg></a>
		<h1>SignIn</h1>
		
		<?php
		   if(isset($_GET['error'])){
			if ($_GET['error'] == "emptyfields"){
			  echo '<p class="loginerror">Fill in all fields!</p>';
			}
			else if ($_GET['error'] == "sqlerror") {
			  echo '<p class="loginerror">database server not found!</p>';
			}
			else if ($_GET['error'] == "wrongpwd") {
			  echo '<p class="loginerror">Wrong password!</p>';
			}
			else if ($_GET['error'] == "nouser") {
			  echo '<p class="loginerror">No user found!</p>';
			}
			
		   }
		  
		?>
		<?php
		if(isset($_GET['movie_title']) && isset($_GET['movie_id']) && isset($_GET['release_date']) && isset($_GET['movie_lang']) && isset($_GET['tmdb_id'])){
			$movie_title =  $_GET['movie_title'];
	       		$movie_id =  $_GET['movie_id'];
  			$release_date = $_GET['release_date'];
			$movie_lang = $_GET['movie_lang'];
			$tmdb_id = $_GET['tmdb_id'];
		}
		else{
			$movie_title =  $_POST['movie_title'];
	        	$movie_id =  $_POST['movie_id'];
			$release_date = $_POST['release_date'];
			$movie_lang = $_POST['movie_lang'];
			$tmdb_id = $_POST['tmdb_id'];
		}
		echo "<form action='includes/loginfromsubpage.inc.php' method='post'>
		 <label for='mail'><br><b>E-mail</b></br></label>
	  	 <input type='text' name='mail' placeholder='E-mail...'>

		 <label for='pwd'><br><b>Password</b></br></label>
	  	 <input type='password' name='pwd' placeholder='Password...'>
		 <br>
		 <input type = 'hidden' name='movie_title' value='$movie_title'>
		 <input type = 'hidden' name='movie_id' value='$movie_id'>
		 <input type = 'hidden' name='release_date' value='$release_date'>
		 <input type = 'hidden' name='movie_lang' value='$movie_lang'>
		 <input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
	  	 <button type='submit' name='login-submit'>SignIn</button>
		</form>
		<p>Don't Have an Account ? <a class='signup-link' href='signupfromsubpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."'>SignUp</a></p>
		";
		?>
	    </section>
	</div>
     </main>

