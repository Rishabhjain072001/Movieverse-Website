<title>MovieVerse</title>
<link rel="stylesheet" type="text/css" href="login2.css">

     <main>
	<div class="Login">
	   <section class="section-default">
		<a href='index.php'><svg class='arrow-left' width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
 		<form action="includes/loginfromhomepage.inc.php" method="post">
		
		 <label for="mail"><br><b>E-mail</b></br></label>
	  	 <input type="text" name="mail" placeholder="E-mail...">

		 <label for="pwd"><br><b>Password</b></br></label>
	  	 <input type="password" name="pwd" placeholder="Password...">
		 <br>

	  	 <button type="submit" name="login-submit">SignIn</button>
		</form>
		<p>Don't Have an Account ? <a class='signup-link' href='signupfromhomepage.php'>SignUp</a></p>
	    </section>
	</div>
     </main>

