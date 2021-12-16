<?php
	
      require '../includes/dbh.inc.php';
       
?>

<!DOCTYPE html>
<html>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />

<script src="//code.jquery.com/jquery-2.1.4.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<!-- ============= -->

<div class="container">
 <div class="box">
    
   <div id = "sidebarCollapse" class = "menu-icon">
	<div class = "icon"></div>
	<div class = "icon"></div>
	<div class = "icon"></div>
    </div>

   <div id = "web-icon">
	<a href="../index.php"><img src='../includes/uploads/web-icon.png'></a>
   </div>

   <div class="dropdown">
	<?php
	if(isset($_SESSION['userId'])){
	  $sql = "SELECT * FROM users WHERE idUsers = ".$_SESSION['userId']."";
	  $result = mysqli_query($conn, $sql);
	  if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$idUsers = $row['idUsers'];
			$sqlImg = "SELECT * FROM profileimg WHERE idUsers ='$idUsers'";
			$resultImg = mysqli_query($conn, $sqlImg);
			while($rowImg = mysqli_fetch_assoc($resultImg)){
				echo "<div>";
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
			   	    	echo "<img onclick='ShowSetting()' class='dropbtn' src=$link width = '200' height ='300'>";

					

				    }
				    else{
					$firstLetter = substr(strtoupper($row["uidUsers"]),0,1);
	   				echo "<img onclick='ShowSetting()' class='dropbtn' src='../includes/uploads/default/".$firstLetter.".png' width = '200' height ='300'>";
				    }
				 
				echo "</div>";
			}	
		}
	    }
	}
	else{
	   echo "<img onclick='ShowSetting()' class='dropbtn' src='../includes/uploads/default-profile-icon.png' width = '200' height ='300'>";
	}
	?>
     <div id="myDropdown" class="dropdown-content">
    
     <div class = "login">
         <?php	    		 
	 if (isset($_SESSION['userId'])){
	      echo "<form action='../subpageprofile.php' method='get'>
		<input type = 'hidden' name='movie_title' value='$movie_title'>
		<input type = 'hidden' name='movie_id' value='$movie_id'>
		 <input type = 'hidden' name='release_date' value='$release_date'>
		<input type = 'hidden' name='movie_lang' value='$movie_lang'>
		<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
	        <button type='submit' name='profile-submit'>
		<svg class='bi bi-person-circle' width='1.5em' height='1.5em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  		<path d='M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z'/>
  		<path fill-rule='evenodd' d='M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
  		<path fill-rule='evenodd' d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z'/>
		</svg> &nbsp; &nbsp;
		PROFILE</button>
	       </form>";	
	  }
	  else{
		echo "<form action='../loginfromsubpage.php' method='post'>
		<input type = 'hidden' name='movie_title' value='$movie_title'>
		<input type = 'hidden' name='movie_id' value='$movie_id'>
		 <input type = 'hidden' name='release_date' value='$release_date'>
		<input type = 'hidden' name='movie_lang' value='$movie_lang'>
		<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
		 <button type='submit'  name='login-submit'>
		 <svg class='bi bi-arrow-right-square' width='1.4em' height='1.4em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  		<path fill-rule='evenodd' d='M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
  		<path fill-rule='evenodd' d='M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z'/>
 		 <path fill-rule='evenodd' d='M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z'/>
		</svg> &nbsp; &nbsp;
		SIGNIN</button>
	   	 </form>";
	   }
	   ?>
     </div>
	
     <div class = "signup">
	<?php
	 if (!isset($_SESSION['userId'])){
	     echo "<form action='../signupfromsubpage.php' method='post'>
	      <input type = 'hidden' name='movie_title' value='$movie_title'>
		 <input type = 'hidden' name='movie_id' value='$movie_id'>
		 <input type = 'hidden' name='release_date' value='$release_date'>
		<input type = 'hidden' name='movie_lang' value='$movie_lang'>
		<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
    	      <button type='submit' name='signup-submit'>
		<svg class='bi bi-box-arrow-right' width='1.5em' height='1.5em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  		<path fill-rule='evenodd' d='M11.646 11.354a.5.5 0 0 1 0-.708L14.293 8l-2.647-2.646a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z'/>
  		<path fill-rule='evenodd' d='M4.5 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z'/>
  		<path fill-rule='evenodd' d='M2 13.5A1.5 1.5 0 0 1 .5 12V4A1.5 1.5 0 0 1 2 2.5h7A1.5 1.5 0 0 1 10.5 4v1.5a.5.5 0 0 1-1 0V4a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V12A1.5 1.5 0 0 1 9 13.5H2z'/>
		</svg> &nbsp;
		SIGNUP</button>
	      </form>";
         }
	 else{
	   echo "<form action='../includes/logout.inc.php' method='post'>
	        <button type='submit' name='logout-submit'>
		<svg class='bi bi-arrow-right-square' width='1.4em' height='1.4em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  		<path fill-rule='evenodd' d='M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
  		<path fill-rule='evenodd' d='M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z'/>
 		 <path fill-rule='evenodd' d='M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z'/>
		</svg> &nbsp; &nbsp;
		SIGNOUT</button>
	       </form>";
	 }
         ?>
    </div>

     </div>
    </div>

    <div class="search-bar">
      <form action="searchYoutubeVideo.php" method="get">
        <input type="text" placeholder="Search On Youtube..." name="search" id="movie" autocomplete="off">
	<div id="movieList"></div>
        <button type="submit" name="submit-search" id="clickSearch"><i class="fa fa-search"></i></button>
      </form>
    </div>
	
	
	<script>
	/* AutoComplete */
	$("#movie").autocomplete({
		source: function(request, response){
			/* google geliştirici kimliği (zorunlu değil) */
			var apiKey = 'AI39si7ZLU83bKtKd4MrdzqcjTVI3DK9FvwJR6a4kB_SW_Dbuskit-mEYqskkSsFLxN5DiG1OBzdHzYfW0zXWjxirQKyxJfdkg';
			/* aranacak kelime */
			var query = request.term;
			/* youtube sorgusu */
			$.ajax({
				url: "https://suggestqueries.google.com/complete/search?hl=en&ds=yt&client=youtube&hjson=t&cp=1&q="+query+"&key="+apiKey+"&format=5&alt=json&callback=?",  
				dataType: 'jsonp',
				success: function(data, textStatus, request) { 
				   response( $.map( data[1], function(item) {
						return {
							label: item[0],
							value: item[0],
						}
					}));
				}
			});
		},
		/* seçilene işlem yapmak için burayı kullanabilirsin */
		select: function( event, ui ) {
			document.getElementById("clickSearch").click();
		}
	});
	
	</script>

    
  </div>
</div>
<div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                

                <ul class="list-unstyled components">
                    <li class="active">
                        <a href="../index.php" >
                            &nbsp;&nbsp;
                            <i class="fa fa-home">&nbsp;&nbsp;</i>
                            <span class="icon-name">Home</span>
                        </a>
                    </li>
		    <li>
                        <a href="youtubeVideoHome.php" >
			    &nbsp;&nbsp;
                            <i class="fa fa-youtube">&nbsp;&nbsp;</i>
                            <span class="icon-name">Video</span>
                        </a>
                    </li>
					<li>
                        <a href="../anime/animeHome.php" >
			    &nbsp;&nbsp;
                            <i class="fa fa-youtube-play">&nbsp;&nbsp;</i>
                            <span class="icon-name">Anime</span>
                        </a>
                    </li>
                </ul>

                
            </nav>



</div>

<script>

function ShowSetting() {
  document.getElementById("myDropdown").classList.toggle("showsetting");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('showsetting')) {
        openDropdown.classList.remove('showsetting');
      }
    }
  }
}
</script>
</html>




