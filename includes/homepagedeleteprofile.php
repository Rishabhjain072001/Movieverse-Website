<?php
require "vendor/autoload.php";
require "config-cloud.php";

session_start();

include 'dbh.inc.php';
$sessionid = $_SESSION['userId'];


$file = "profile/profile".$sessionid;


\Cloudinary\Uploader::destroy($file);

$sql = "UPDATE profileimg SET status = 1 WHERE idUsers = '$sessionid';";
mysqli_query($conn, $sql);

header("Location: ../homepageprofile.php?deletesuccess");
exit();