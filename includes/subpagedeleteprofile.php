<?php
require "vendor/autoload.php";
require "config-cloud.php";

session_start();

include 'dbh.inc.php';
$sessionid = $_SESSION['userId'];

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

$file = "profile/profile".$sessionid;


\Cloudinary\Uploader::destroy($file);

$sql = "UPDATE profileimg SET status = 1 WHERE idUsers = '$sessionid';";
mysqli_query($conn, $sql);

header("Location: ../subpageprofile.php?movie_title=".$movie_title."&movie_id=".$movie_id."&release_date=".$release_date."&movie_lang=".$movie_lang."&tmdb_id=".$tmdb_id."");
exit();