<?php
   date_default_timezone_set('Europe/copenhagen');
  
  
   require '../includes/dbh.inc.php';
   require '../includes/comments.inc.php';
  
   session_start();
   
?>

<!DOCTYPE html>
<html>
 <head>
   <!-- Bootstrap CSS CDN -->
      <!-- Our Custom CSS -->
   <link rel="stylesheet" href="searchYoutubeVideo2.css">
   <link rel="stylesheet" type="text/css"  href="css/all.css">
   
   <title>MovieVerse</title>
  </head>
  <body>
   <header>
        <?php
          require 'headerofyoutubeVideoHome.php';
        ?>
	
    </header>

  <div class="search">
  
  <?php
	
	if (isset($_GET['submit-search'])){
        
		if (empty($_GET['search'])){
			header('Location:youtubeVideoHome.php');
		 }
		else{
		   $search = $_GET['search'];
		   $search = str_replace(' ', '', $search);

		   $curlSession = curl_init();
		   curl_setopt($curlSession, CURLOPT_URL, 'http://Movieverse-youtube.herokuapp.com/api/'.$search);
		   curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		   curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		   $jsonData = json_decode(curl_exec($curlSession), true);
		   
		  curl_close($curlSession);
			  
		  $curlSession = curl_init();
		  curl_setopt($curlSession, CURLOPT_URL, 'https://Movieverse-youtube.herokuapp.com/apiplay/'.$search);
		  curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
		  curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

		  $jsonData2 = json_decode(curl_exec($curlSession), true);
		   
		  curl_close($curlSession);
		}
	}
  ?>

<div id = "tabs">

<button class="tablink" onclick="openPage('singleVideos', this, '#181818')"id="defaultOpen">Single videos</button>
<button class="tablink" onclick="openPage('playlist', this, '#181818')" >Playlist</button>
</div>

<div id="singleVideos" class="tabcontent">
<?php
   if (isset($_GET['submit-search'])){
        
	$buttonColor = array('#FF4F03', '#C71585', '#000080', '#8B0000', '#008000', '#ff8000', '#0066ff', '#618624', '#FF4F03', '#C71585', '#E67E22', '#1ABC9C ', '#9B59B6', '#008000', '#ff8000', '#8B0000', '#0099ff', '#ff33cc','#000080','#D7A60E');
	  $i = 0;	
	  for ($i = 0; $i<count($jsonData['search_result']); $i++){
		echo"
		   <div class='card'>
		   <a href='youtubeVideoSubpage.php?&id=".$jsonData['search_result'][$i]['id']."&channel=".$jsonData['search_result'][$i]['channel']."&title=".$jsonData['search_result'][$i]['title']."' >
		   
		   <i class='fas fa-arrow-right'></i>
		   <div class='discription'>".$jsonData['search_result'][$i]['title']."
		   <p class='title'>".$jsonData['search_result'][$i]['channel']."</p>
		   </div>
			<div class='pic' >
			<span class='ytd-thumbnail-overlay-time-status-renderer' aria-label='1 minute, 26 seconds'>
			".$jsonData['search_result'][$i]['duration']."
			</span>
			</div>
			<button>
			</button>
			<script>
				document.getElementsByClassName('pic')[$i].style.backgroundImage = 'url(".$jsonData['search_result'][$i]['thumbnails'][2].")';
				document.getElementsByClassName('card')[$i].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor[$i]';
			</script>
			</a></div>
		";
	  }	
   }  
?>
</div>

<div id="playlist" class="tabcontent">

<?php
   if (isset($_GET['submit-search'])){
        
	$buttonColor2 = array('#FF4F03', '#C71585', '#000080', '#8B0000', '#008000', '#ff8000', '#0066ff', '#618624', '#FF4F03', '#C71585', '#E67E22', '#1ABC9C ', '#9B59B6', '#008000', '#ff8000', '#8B0000', '#0099ff', '#ff33cc','#000080','#D7A60E');
	  $i = 0;	
	  for ($i = 0; $i<count($jsonData2['search_result']); $i++){
		echo"
		   <div class='card2'>
		   <a href='youtubeVideoPlaylistSubpage.php?&id=".$jsonData2['search_result'][$i]['id']."&channel=".$jsonData2['search_result'][$i]['channel']."&title=".$jsonData2['search_result'][$i]['title']."' >
		   
		   <i class='fas fa-arrow-right'></i>
           <div class='discription'>".$jsonData2['search_result'][$i]['title']."
           <p class='title'>".$jsonData2['search_result'][$i]['channel']."</p>
           </div>
			<div class='pic2' >
			<span class='ytd-thumbnail-overlay-time-status-renderer2' aria-label='1 minute, 26 seconds'>
            ".$jsonData2['search_result'][$i]['count']."
			</span>
			<img class='playlisticon' src='../includes/uploads/playlist.png'></img>
			</div>
			<button>
			</button>
			<script>
				document.getElementsByClassName('pic2')[$i].style.backgroundImage = 'url(".$jsonData2['search_result'][$i]['thumbnails'][2].")';
				document.getElementsByClassName('card2')[$i].getElementsByTagName('button')[0].style.backgroundColor = '$buttonColor2[$i]';
			</script>
			</a></div>
		";
	  }	
	
   }  
?>

</div>

</div>

<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

<!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
	     var width;
		window.onresize = window.onload = function() {
    		width = this.outerWidth;
		if (width >= 1433){
		  document.getElementsByClassName("search")[0].style.marginLeft = "18%";	
   		}
		else if (width >= 1285){
		  document.getElementsByClassName("search")[0].style.marginLeft = "21%";	
   		}
    		else if (width >= 1267){
		  document.getElementsByClassName("search")[0].style.marginLeft = "19%";	
   		}
		else if (width >= 1263){
		  document.getElementsByClassName("search")[0].style.marginLeft = "10%";	
   		}
	     }
	
             $(document).ready(function () {
		 var act = "off";
                  $('#sidebarCollapse').on('click', function () {
		  if (act === "off"){	
			var w = window.outerWidth;
		  	$('#sidebar').toggleClass('active'); 
			if (w <= 523){
			 document.getElementsByClassName("search")[0].style.marginLeft = "21%";
			}
			else{
			  document.getElementsByClassName("search")[0].style.marginLeft = "11%";
			}
                         act ="on";
		  }  
		  else if (act === "on"){
			 var w = window.outerWidth;
			 $('#sidebar').toggleClass('active');
			 if (w <= 517){
			  document.getElementsByClassName("search")[0].style.marginLeft = "15%";
			 }
			 else if (w <= 1263){
			  document.getElementsByClassName("search")[0].style.marginLeft = "8%";
			 }
			 else if (w <= 1359){
			  document.getElementsByClassName("search")[0].style.marginLeft = "20%";
			 }
			 else{
		     	   document.getElementsByClassName("search")[0].style.marginLeft = "18%";
			 }
                     	 act ="off";
		     }
		 });	
             });
         </script>

</body>
</html>
