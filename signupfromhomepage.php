<title>MovieVerse</title>
<link rel="stylesheet" type="text/css" href="signup2.css">

     <main>
	<div class="signup">
	   <section class="section-default">
		<section class="section-default">
		<a href='index.php'><svg class='arrow-left' width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-chevron-double-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  		<path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  		<path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
		</svg>
		</a>

		<h1>SignUp</h1>
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
		   else if(isset($_GET['signup'])){
		      if ($_GET['signup'] == "success"){
			echo '<p class="signupsuccess">Signup successful!</p>';
			
		      }	
		   }
		?>
 		<form action="includes/signupfromhomepage.inc.php" method="post">
		
		 <label for="uid"><br><b>Username</b></br></label>
	  	 <input type="text" name="uid" placeholder="Username">

		 <label for="mail"><br><b>Email</b></br></label>
	  	 <input type="text" name="mail" placeholder="Email">

		 <label for="pwd"><br><b>Password</b></br></label>
	  	 <input type="password" name="pwd" placeholder="Password">

		 <label for="pwd-repeat"><br><b>Repeat Password</b></br></label>
	  	 <input type="password" name="pwd-repeat" placeholder="Repeat password">
		 <br>
	  	 <button type="submit" name="signup-submit">SignUp</button>
		</form>
		<p>Already Have an Account ? <a class='login-link' href='loginfromhomepage.php'>SignIn</a></p>	
	    </section>
	</div>
     </main>

