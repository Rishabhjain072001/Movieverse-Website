<title>MovieVerse</title>

<link rel="stylesheet" type="text/css" href="signup2.css">

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

	<div class="signUp">
	   <section class="section-default">
		<a href="subpage.php?movie_title=<?php echo $movie_title ?>&movie_id=<?php echo $movie_id ?>&release_date=<?php echo $release_date ?>&movie_lang= <?php echo $movie_lang ?>&tmdb_id=<?php echo $tmdb_id ?>">
		<svg class='arrow-left' width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  		<path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  		<path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
		</svg></a>

		<h1>Signup</h1>
		<p>Please fill in this form to create an account.</p>
		<?php
		   if(isset($_GET['error'])){
			if ($_GET['error'] == "emptyfields"){
			  echo '<p class="signuperror">Fill in all fields!</p>';
			}
			else if ($_GET['error'] == "invalidmailuid") {
			  echo '<p class="signuperror">Invalid username and e-mail!</p>';
			}
			else if ($_GET['error'] == "invaliduid") {
			  echo '<p class="signuperror">Invalid username!</p>';
			}
			else if ($_GET['error'] == "invalidmail") {
			  echo '<p class="signuperror">Invalid e-mail!</p>';
			}
			else if ($_GET['error'] == "passwordcheck") {
			  echo '<p class="signuperror">Your password do not match!</p>';
			}
			else if ($_GET['error'] == "emailtaken") {
			  echo '<p class="signuperror">E-mail is already taken!</p>';
			}
		   }
		   
		?>
		<?php
		if(isset($_GET['movie_title']) && isset($_GET['movie_id']) && isset($_GET['release_date']) && isset($_GET['movie_lang']) && isset($_GET['tmdb_id'])){
			$movie_title =  $_GET['movie_title'];
	       		$movie_id =  $_GET['movie_id'];
			$release_date =  $_GET['release_date'];
			$movie_lang =  $_GET['movie_lang'];
			$tmdb_id =  $_GET['tmdb_id'];
		}
		else{
			$movie_title =  $_POST['movie_title'];
	        	$movie_id =  $_POST['movie_id'];
			$release_date =  $_POST['release_date'];
			$movie_lang =  $_POST['movie_lang'];
			$tmdb_id =  $_POST['tmdb_id'];
		}
 		echo "<form action='includes/signupfromsubpage.inc.php' method='post'>
		
		 <label for='uid'><br><b>Username</b></br></label>
	  	 <input type='text' name='uid' placeholder='Username'>

		 <label for='mail'><br><b>Email</b></br></label>
	  	 <input type='text' name='mail' placeholder='Email'>

		 <label for='pwd'><br><b>Password</b></br></label>
	  	 <input type='password' name='pwd' placeholder='Password'>

		 <label for='pwd-repeat'><br><b>Repeat Password</b></br></label>
	  	 <input type='password' name='pwd-repeat' placeholder='Repeat password'>
		 <br>
		 
		 <input type = 'hidden' name='movie_title' value='$movie_title'>
		 <input type = 'hidden' name='movie_id' value='$movie_id'>
		 <input type = 'hidden' name='release_date' value='$release_date'>
		 <input type = 'hidden' name='movie_lang' value='$movie_lang'>
		 <input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
	  	 <button type='submit' name='signup-submit'>Signup</button>
		</form>
		<p>Already Have an Account ? <a class='login-link' href='loginfromsubpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."'>SignIn</a></p>
		";
		?>
	    </section>
	</div>
     </main>

