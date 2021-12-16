<?php

if (isset($_POST['login-submit'])){
	require 'dbh.inc.php';
	$mail= $_POST['mail'];
	$password = $_POST['pwd'];
	$movie_title =  $_POST['movie_title'];
	$movie_id =  $_POST['movie_id'];
        $release_date =  $_POST['release_date'];
        $movie_lang =  $_POST['movie_lang'];
	$tmdb_id =  $_POST['tmdb_id'];

	if (empty($mail) || empty($password)){
		
		header("Location: ../loginfromsubpage.php?error=emptyfields&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		exit();
	}
	else {
	    $sql = "SELECT * FROM users WHERE emailUsers=?;";
	    $stmt = mysqli_stmt_init($conn);
	    if (!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../loginfromsubpage.php?error=sqlerror&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		exit();
	    }
	    else{
		mysqli_stmt_bind_param($stmt, "s", $mail);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)){
		    $pwdCheck = password_verify($password, $row['pwdUsers']);
		    if ($pwdCheck == false){
		    	header("Location: ../loginfromsubpage.php?error=wrongpwd&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		    	exit();
		    }
		    else if ($pwdCheck == true){
		  	session_start();
			$_SESSION['userId'] = $row['idUsers'];
			$_SESSION['userUid'] = $row['uidUsers'];
			header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		    	exit();
			
		    }
		    else{
			header("Location: ../loginfromsubpage.php?error=wrongpwd&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		    	exit();
		    }
		}
		else{
		    header("Location: ../loginfromsubpage.php?error=nouser&movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		    exit();
		}
	    }
	}
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
