<?php
  date_default_timezone_set('Europe/copenhagen');
  require '../includes/dbh.inc.php';
  require '../includes/comments.inc.php';
  session_start();
  $ShowTitle = mysqli_real_escape_string($conn, trim($_GET['ShowTitle']));
  $ShowID = mysqli_real_escape_string($conn, trim($_GET['ShowID']));
  $EpisodeID = mysqli_real_escape_string($conn, trim($_GET['EpisodeID']));
  $AnilistID = mysqli_real_escape_string($conn, trim($_GET['AnilistID']));
  $Server = mysqli_real_escape_string($conn, trim($_GET['Server']));
  
  $defaultEpisodeID = 1;
?>
<!DOCTYPE html>
<html>
 <head>
   <title>MovieVerse</title>
   <!-- Bootstrap CSS CDN -->
   <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- Our Custom CSS -->
   <link rel="stylesheet" href="animeSubpage2.css">
   <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <style>
   #player iframe {
    pointer-events: none;
   }
  </style>


<script type='text/javascript' src="//wurfl.io/wurfl.js"></script>
<script>

if (WURFL.is_mobile === true) {
    window.location.replace("http://mob.movieverse.unaux.com");
}
</script>
  </head>


  <body>
   <header>
    
	<?php
          require 'headerofanimeHome.php';
        ?>
</header>




<?php
if($Server == 1){
	require 'animeSubpageServer1.php';
}
else if($Server == 2){
	require 'animeSubpageServer2.php';
}
?>








<!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
          
         <script type="text/javascript">
             $(document).ready(function () {
                 var act = "off";
                 $('#sidebarCollapse').on('click', function () {
                   if (act === "off"){
                     $('#sidebar').toggleClass('active');
		      document.body.style.backgroundColor = "rgba(0, 0, 0, 0.95)";
                     act ="on";
		   }
                   else if (act === "on"){
			 $('#sidebar').toggleClass('active');
		     	document.body.style.backgroundColor = "#1a1a1a";
                     	act ="off";
		   }
                 });
             });
         </script>


</script>

   </body>


</html>