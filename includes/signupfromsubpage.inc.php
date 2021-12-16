<?php

if (isset($_POST['signup-submit'])){
	require 'dbh.inc.php';
	
	$username = $_POST['uid'];
	$email = $_POST['mail'];
	$password = $_POST['pwd'];
	$passwordRepeat = $_POST['pwd-repeat'];
	$movie_title =  $_POST['movie_title'];
	$movie_id =  $_POST['movie_id'];
	$release_date =  $_POST['release_date'];
        $movie_lang =  $_POST['movie_lang'];
	$tmdb_id =  $_POST['tmdb_id'];

	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
		header("Location: ../signupfromsubpage.php?error=emptyfields&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."&uid=".$username."&mail=".$email);
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signupfromsubpage.php?error=invalidmailuid&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		exit();
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../signupfromsubpage.php?error=invalidmail&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."&uid=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signupfromsubpage.php?error=invaliduid&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."&mail=".$email);
		exit();
	}
	else if ($password !== $passwordRepeat){
		header("Location: ../signupfromsubpage.php?error=passwordcheck&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."&uid=".$username."&mail=".$email);
		exit();
	} 
	else{
	  $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";	
	  $stmt = mysqli_stmt_init($conn);
	  if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../signupfromsubpage.php?error=sqlerror&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		exit();

	  }
	  else{
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$resultCheck = mysqli_stmt_num_rows($stmt);
		if ($resultCheck > 0){
			header("Location: ../signupfromsubpage.php?error=emailtaken&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."&uid=".$username);
			exit();
		}
		else{
		  $sql = "INSERT INTO users(uidUsers, emailUsers, pwdUsers) VALUES(?, ?, ?)";
		  $stmt = mysqli_stmt_init($conn);
		  if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signupfromsubpage.php?error=sqlerror&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
			exit();
		  }
		  else{
			$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

			mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
			mysqli_stmt_execute($stmt);
			
		  }	
		}
	  }
	}
	$sql = "SELECT * FROM users WHERE emailUsers=?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)){
	     header("Location: ../loginfromsubpage.php?error=sqlerror&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
	     exit();
	}
	else{
	    mysqli_stmt_bind_param($stmt, "s", $email);
	    mysqli_stmt_execute($stmt);
	    $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)){
		$pwdCheck = password_verify($password, $row['pwdUsers']);
		
	        if ($pwdCheck == true){
		  	session_start();
			$_SESSION['userId'] = $row['idUsers'];
			$_SESSION['userUid'] = $row['uidUsers'];
			
			header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		    	exit();
		}
		
	    }
        }

	mysqli_stmt_close( $stmt);
	mysqli_close($conn);
}

else{
	$movie_title =  $_POST['movie_title'];
	$movie_id =  $_POST['movie_id'];
	$release_date =  $_POST['release_date'];
        $movie_lang =  $_POST['movie_lang'];
	$tmdb_id =  $_POST['tmdb_id'];
	header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
	exit();  

}