<?php
require "vendor/autoload.php";
require "config-cloud.php";


session_start();
require 'dbh.inc.php';
$id = $_SESSION['userId'];

if(isset($_POST["image"]))
{
	$data = $_POST["image"];

	
   
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);

	$imgName = "profile/profile".$id;

	\Cloudinary\Uploader::upload('data:image/png;base64,'.$image_array_2[1], array("public_id" => $imgName, "overwrite" => TRUE, "resource_type" => "image"));
	$sql = "UPDATE profileimg SET status = 0 WHERE idUsers='$id';";
	$result = mysqli_query($conn, $sql);
	
}

?>

