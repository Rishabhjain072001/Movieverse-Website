<html>
<head>
<title>Login Form Design</title>
    <link rel="stylesheet" type="text/css" href="loginpageyoutube.css">
<body>
    <div class="loginbox">
    <img src="includes/uploads/avatar.png" alt="Avatar" class="avatar">
        <h1>Login Here</h1>

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
            <p>E-mail</p>
            <input type="email" name="mail" placeholder="Enter E-mail address" required>
            <p>Password</p>
            <input type="password" name="pwd" placeholder="Enter Password" required>
            <input type="submit" name="login-submit" value="Login">
            <a href="signupfromhomepage.php">Don't have an account ? SignUp</a>
        </form>

    </div>

</body>
</head>
</html>
