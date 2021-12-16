<?php
	date_default_timezone_set('Europe/copenhagen');
	include 'dbh.inc.php';
        include 'comments.inc.php';
        

 	if (isset($_POST['replySubmit'])){
		$rid = $_POST['rid'];
		$p_cid = $_POST['p_cid'];
		$uidUsers = $_POST['uidUsers'];
		$date = $_POST['date'];
		$message = $_POST['message'];
		$movie_title =  $_POST['movie_title'];
		$movie_id =  $_POST['movie_id'];
		$release_date =  $_POST['release_date'];
		$movie_lang =  $_POST['movie_lang'];
		$tmdb_id =  $_POST['tmdb_id'];

		
		$sql = "UPDATE reply SET message='$message' WHERE rid='$rid'";
		$result = $conn->query($sql);
		header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
	}
	
        if (isset($_POST['cancelEditReply'])){
		$movie_title =  $_POST['movie_title'];
		$movie_id =  $_POST['movie_id'];
		$release_date =  $_POST['release_date'];
		$movie_lang =  $_POST['movie_lang'];
		$tmdb_id =  $_POST['tmdb_id'];

		header("Location: ../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
		exit();
	}