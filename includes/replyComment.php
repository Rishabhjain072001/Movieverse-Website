<?php

	date_default_timezone_set('Europe/copenhagen');
	include 'dbh.inc.php';
        include 'comments.inc.php';
        session_start();

 	if (isset($_POST['commentReply'])){
		$cid = $_POST['cid'];
		$uidUsers = $_POST['uidUsers'];
		$date = $_POST['date'];
		$message = $_POST['message'];
		$movie_title =  $_POST['movie_title'];
		$movie_id =  $_POST['movie_id'];
		$release_date =  $_POST['release_date'];
		$movie_lang =  $_POST['movie_lang'];
		$tmdb_id =  $_POST['tmdb_id'];
		
		if (empty($message)){
			header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
			exit(); 
		}
		else {
			$sql = "INSERT INTO reply (p_cid, uidUsers, date, message) VALUES ('$cid','$uidUsers', '$date', '$message')";
			$result = $conn->query($sql);
			header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		}
	}

	if (isset($_POST['cancelReply'])){
	        $movie_title =  $_POST['movie_title'];
		$movie_id =  $_POST['movie_id'];
		$release_date =  $_POST['release_date'];
		$movie_lang =  $_POST['movie_lang'];
		$tmdb_id =  $_POST['tmdb_id'];

	    header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
	    exit();
	}
