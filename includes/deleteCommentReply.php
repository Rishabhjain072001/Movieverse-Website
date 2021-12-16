<?php


	date_default_timezone_set('Europe/copenhagen');
	include 'dbh.inc.php';
        include 'comments.inc.php';
     
	if (isset($_POST['commentDelete'])){
		$cid = $_POST['cid'];
		$movie_title =  $_POST['movie_title'];
		$movie_id =  $_POST['movie_id'];
		$release_date =  $_POST['release_date'];
		$movie_lang =  $_POST['movie_lang'];
		$tmdb_id =  $_POST['tmdb_id'];

		$sql = "DELETE FROM comments WHERE cid='$cid '";
		$result = $conn->query($sql);
		
		$p_cid =  $_POST['cid'];
		$sql3 = "SELECT * FROM reply WHERE p_cid='$p_cid'";
		$result3 = $conn->query($sql3);	
        	while($row3 = $result3->fetch_assoc()){
			$rid = $row3['rid'];
			$sql2 = "DELETE FROM reply WHERE rid='$rid'";
			$result2 = $conn->query($sql2);
		}
		header("Location:../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
	}



	if (isset($_POST['replyDelete'])){
		
		$rid = $_POST['rid'];
		$movie_title =  $_POST['movie_title'];
		$movie_id =  $_POST['movie_id'];
		$release_date =  $_POST['release_date'];
		$movie_lang =  $_POST['movie_lang'];
		$tmdb_id =  $_POST['tmdb_id'];

		
		$sql = "DELETE FROM reply WHERE rid='$rid '";
		$result = $conn->query($sql);	
        	
		header("Location:../subpage.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
	}

