<?php
	require "includes/vendor/autoload.php";
	require "includes/config-cloud.php";
	session_start();
	require 'includes/dbh.inc.php';
	$id = $_SESSION['userId'];
?>

<!DOCTYPE html>
<html>
<head>
   <title>MovieVerse</title>
   <link rel="stylesheet" href="profile2.css"> 
    <script src="js/jquery.min.js"></script>  
    <script src="js/bootstrap.min.js"></script>
    <script src="js/croppie.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="croppie.css" />
</head>
<body>

<?php
	$sql = "SELECT * FROM users WHERE idUsers = '$id'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$idUsers = $row['idUsers'];
			$sqlImg = "SELECT * FROM profileimg WHERE idUsers ='$idUsers'";
			$resultImg = mysqli_query($conn, $sqlImg);
			while($rowImg = mysqli_fetch_assoc($resultImg)){
				echo "<a href='index.php'><svg class='arrow-left' width='2em' height='2em' viewBox='0 0 16 16' class='bi bi-chevron-double-left' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  				  <path fill-rule='evenodd' d='M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/>
  				  <path fill-rule='evenodd' d='M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/>
				  </svg></a>";
				echo "<div class='profile'><center>";
				   if ($rowImg['status'] == 0){
					$url = "https://129647638724392:LIC4zkAcAHhRiob4PywtuO7e4RM@api.cloudinary.com/v1_1/dnlfvybzm/resources/image";
					$ch = curl_init();  
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_URL, $url); 
					$res = curl_exec($ch); 
					$res2 = explode("/",$res);
					$size = count($res2);
					
					for ($x = 0; $x < $size; $x++) {
  					   if (strpos($res2[$x], 'profile'.$idUsers.'.png') !== false) {
    						$index = $x;
						break;
  					   }
				        }
				   	$version = $res2[$index-2];
				   	$link = "http://res.cloudinary.com/dnlfvybzm/image/upload/".$version."/profile/profile".$idUsers;
			   	    	echo "<img class='image' src=$link width = '200' height ='300'>";
				
					
					
				 
					echo "<p>".$row['uidUsers']."<br>".$row['emailUsers']."</p><br>";
									

					echo "<form method='POST' enctype = 'multipart/form-data'>
					<label for='upload_image' class='btn1'>Change profile picture</label>
					<input type='file' name='file' id='upload_image' style='visibility:hidden;'>
					</form>";

					echo "<form action='includes/homepagedeleteprofile.php' method='POST'>
					<button class='btn2' >Remove profile picture</button>
					</form>";
					
				    }
				    else{
					
					$firstLetter = substr(strtoupper($row["uidUsers"]),0,1);
					echo "<img class='image' src='includes/uploads/default/".$firstLetter.".png' width = '200' height ='300'>";
					echo "<p>".$row['uidUsers']."<br>".$row['emailUsers']."</p><br>";
					
					echo "<form method='POST' enctype = 'multipart/form-data'>
					<label for='upload_image' class='btn1'>Upload profile picture</label>
					<input type='file' name='file' id='upload_image' style='visibility:hidden;'>
					</form>";
				    }
				echo "</center></div>";
			}	
		}
	}
		

		echo "
		 <div id='uploadimageModal' class='modal' role='dialog'>
		  <div class='modal-dialog'>
		    <div class='modal-content'>
      			<div class='modal-header'>
        			<button type='button' class='close' data-dismiss='modal'>&times;</button>
        			<h4 class='modal-title'>Upload & Crop Image</h4>
      			</div>
      			<div class='modal-body'>
        			<div class='row'>
  					<div class='col-md-8 text-center'>
						  <div id='image_demo' style='width:350px; margin-top:30px'></div>
  					</div>
  					<div class='col-md-4' style='padding-top:30px;'>
  						<br />
  						<br />
  						<br/>
						  <button class='btn btn-success crop_image'>Crop & Upload Image</button>
					</div>
				</div>
      			</div>
      		   <div class='modal-footer'>
        		<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      		   </div>
    		 </div>
    	       </div>
	     </div>


		";
		


	    
?>
</body>

<script>

$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'circle' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      var dataURL = reader.result;
      var Split = dataURL.split(';');
      var Split2 = Split[0].split('/');
      var fileActualExt = Split2[1].toLowerCase();
      console.log(fileActualExt);

      if($.inArray(fileActualExt, ['gif','png','jpg','jpeg']) == -1) {
	     $('#uploadimageModal').modal('hide');
             alert('invalid file extension!');
	      location.reload();
      }     
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
     }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
 
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){ 
      $.ajax({
        url:"includes/uploadProfile.php",
        type: "POST",
	data:{ image:response},
     
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
	  location.reload();
	   location.reload();
        }
      });
    })
  });

});
  
</script>
</html>