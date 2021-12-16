<?php
   date_default_timezone_set('Europe/copenhagen');
  
  
   require 'includes/dbh.inc.php';
   require 'includes/comments.inc.php';
  
   session_start();
   
?>


<!DOCTYPE html>
<html>
 <head>
   <!-- Bootstrap CSS CDN -->
      <!-- Our Custom CSS -->
   <link rel="stylesheet" href="search.css">
   <title>MovieVerse</title>
  </head>
  <body>
   <header>
        <?php
          require 'headerofhomepage.php';
        ?>
	
    </header>

   <div class="search">
<?php
   if (isset($_GET['submit-search'])){
        
	
        if (empty($_GET['search'])){
		header('Location:index.php');
	}
	else{
	   $search = mysqli_real_escape_string($conn, trim($_GET['search']));
	   echo "<h2><br><br>Showing result for ' $search '</h2>";
	   $words = explode(" ",  $search);
	   $Count = count($words);
           $arr = array(); 
	   for($x = 0; $x < $Count; $x++)
	   {
		$sql = "SELECT * FROM movies WHERE movie_title LIKE '%$words[$x]%'";
		$result = mysqli_query($conn, $sql);
		$queryResult = mysqli_num_rows($result);
		if ($queryResult > 0) {
	     	   While ($row = mysqli_fetch_assoc($result)){
		      if(array_key_exists($row['movie_title'],$arr))
		      {
          		 $arr[$row['movie_title']]++;
                      }
		      else
		      {
			
				$arr[$row['movie_title']] = 1; 

		      }
	           }
	        }
	   }
	   arsort($arr);
	   $keys = array_keys($arr);
	   $Count_keys = count($keys);
	   $arr1 = array();
	   if ($Count_keys > 4)
	   {
	     for($x = 0; $x < 4; $x++)
	     {
		$sql = "SELECT * FROM movies WHERE movie_title LIKE '$keys[$x]'";
		$result = mysqli_query($conn, $sql);
		$queryResult = mysqli_num_rows($result);
		if ($queryResult > 0) {
	     	  While ($row = mysqli_fetch_assoc($result)){
		      if (!array_key_exists($row['movie_title'],$arr1))
		      {
		    	echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			
		    	<img src=".$row['movie_img']."  width='70%' height='250'>

			<p class= 'heading'>".$row['movie_title']." </p>
		    	<p class= 'subheading'>".$row['movie_lang']."</p>
		    	 <p class= 'subheading'>".$row['release_date']."</p>
		    	</a></div>";
			$arr1[$row['movie_title']] = array($row['release_date']);
			$arr1[$row['movie_title']][1] = $row['movie_lang'];
		      }
		      else
		      {
			if (!in_array($row['release_date'], $arr1[$row['movie_title']]) || !in_array($row['movie_lang'], $arr1[$row['movie_title']]))
			{
			   echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			   
		    	   <img src=".$row['movie_img']."  width='70%' height='250'>
			   <p class= 'heading'>".$row['movie_title']." </p>
		    	   <p class= 'subheading'>".$row['movie_lang']."</p>
		    	   <p class= 'subheading'>".$row['release_date']."</p>
		    	   </a></div>";
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['release_date'];
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['movie_lang'];
			}

		      }
	          }
	        }
	   
	     }
	   }
	   else{
	      for($x = 0; $x < $Count_keys; $x++)
	      {
		$sql = "SELECT * FROM movies WHERE movie_title LIKE '$keys[$x]'";
		$result = mysqli_query($conn, $sql);
		$queryResult = mysqli_num_rows($result);
		if ($queryResult > 0) {
	     	  While ($row = mysqli_fetch_assoc($result)){
		      if (!array_key_exists($row['movie_title'],$arr1))
		      {
		    	echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			
		    	<img src=".$row['movie_img']."  width='70%' height='250'>
			<p class= 'heading'>".$row['movie_title']." </p>
		    	<p class= 'subheading'>".$row['movie_lang']."</p>
		    	<p class= 'subheading'>".$row['release_date']."</p>
		    	</a></div>";
			$arr1[$row['movie_title']] = array($row['release_date']);
			$arr1[$row['movie_title']][1] = $row['movie_lang'];
		      }
		      else
		      {
			if (!in_array($row['release_date'], $arr1[$row['movie_title']]) || !in_array($row['movie_lang'], $arr1[$row['movie_title']]))
			{
			   echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			   
		    	   <img src=".$row['movie_img']."  width='70%' height='250'>
			   <p class= 'heading'>".$row['movie_title']." </p>
		    	   <p class= 'subheading'>".$row['movie_lang']."</p>
		    	   <p class= 'subheading'>".$row['release_date']."</p>
		    	   </a></div>";
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['release_date'];
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['movie_lang'];
			}

		      }
	          }
	        }
	   
	       }
	   }
	   

	   $sql = "SELECT * FROM movies WHERE movie_title LIKE '%$search%'" ;
           $result = mysqli_query($conn, $sql);
	   $queryResult = mysqli_num_rows($result);
            
	   
	   $Split = str_split($search);
	   $Count = count($Split);
           $arr = array(); 
	   for($x = 0; $x < $Count; $x++)
	   {
		$Split[$x]=mysqli_real_escape_string($conn, $Split[$x]);
		$sql = "SELECT * FROM movies WHERE movie_title LIKE '%$Split[$x]%'";
		$result = mysqli_query($conn, $sql);
		$queryResult = mysqli_num_rows($result);
		if ($queryResult > 0) {
	     	   While ($row = mysqli_fetch_assoc($result)){
		      if(array_key_exists($row['movie_title'],$arr))
		      {
          		 $arr[$row['movie_title']]++;
                      }
		      else
		      {
			
			$arr[$row['movie_title']] = 1; 

		      }
	           }
	        }
	   }
	   arsort($arr);
	   $keys = array_keys($arr);
	   $Count_keys = count($keys);
	   for($x = 0; $x < $Count_keys; $x++)
	   {
		$Split_keys = str_split($keys[$x]);
		if (strcasecmp($Split_keys[0],$Split[0])!==0)
		{
		  unset($keys[$x]);
		}
       	   }
	   $keys= array_values($keys);
	   $Count_keys = count($keys);
	   if ($Count_keys > 10){
	      for($x = 0; $x < 10; $x++)
	      {
		$sql = "SELECT * FROM movies WHERE movie_title LIKE '$keys[$x]'";
		$result = mysqli_query($conn, $sql);
		$queryResult = mysqli_num_rows($result);
		if ($queryResult > 0) {
	     	  While ($row = mysqli_fetch_assoc($result)){
		      if (!array_key_exists($row['movie_title'],$arr1))
		      {
		    	echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			
		    	<img src=".$row['movie_img']."  width='70%' height='250'>
			<p class= 'heading'>".$row['movie_title']." </p>
		    	<p class= 'subheading'>".$row['movie_lang']."</p>
		    	<p class= 'subheading'>".$row['release_date']."</p>
		    	</a></div>";
			$arr1[$row['movie_title']] = array($row['release_date']);
			$arr1[$row['movie_title']][1] = $row['movie_lang'];
		      }
		      else
		      {
			if (!in_array($row['release_date'], $arr1[$row['movie_title']]) || !in_array($row['movie_lang'], $arr1[$row['movie_title']]))
			{
			   echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			   
		    	   <img src=".$row['movie_img']."  width='70%' height='250'>
			   <p class= 'heading'>".$row['movie_title']." </p>
		    	   <p class= 'subheading'>".$row['movie_lang']."</p>
		    	   <p class= 'subheading'>".$row['release_date']."</p>
		    	  </a> </div>";
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['release_date'];
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['movie_lang'];
			}

		      }
	          }
	        }
	   
	     }
	   
	 }
	 else{
	  for($x = 0; $x < $Count_keys; $x++)
	      {
		$sql = "SELECT * FROM movies WHERE movie_title LIKE '$keys[$x]'";
		$result = mysqli_query($conn, $sql);
		$queryResult = mysqli_num_rows($result);
		if ($queryResult > 0) {
	     	  While ($row = mysqli_fetch_assoc($result)){
		      if (!array_key_exists($row['movie_title'],$arr1))
		      {
		    	echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			
		    	<img src=".$row['movie_img']."  width='70%' height='250'>
			<p class= 'heading'>".$row['movie_title']." </p>
		    	<p class= 'subheading'>".$row['movie_lang']."</p>
		    	<p class= 'subheading'>".$row['release_date']."</p>
		    	</a></div>";
			$arr1[$row['movie_title']] = array($row['release_date']);
			$arr1[$row['movie_title']][1] = $row['movie_lang'];
		      }
		      else
		      {
			if (!in_array($row['release_date'], $arr1[$row['movie_title']]) || !in_array($row['movie_lang'], $arr1[$row['movie_title']]))
			{
			   echo "<div class ='search-box'><a href='subpage.php?movie_title=".$row['movie_title']."&movie_id=".$row['movie_id']."&release_date=".$row['release_date']."&movie_lang=".$row['movie_lang']."&tmdb_id=".$row['tmdb_id']."'>
			   
		    	   <img src=".$row['movie_img']."  width='70%' height='250'>
			   <p class= 'heading'>".$row['movie_title']." </p>
		    	   <p class= 'subheading'>".$row['movie_lang']."</p>
		    	   <p class= 'subheading'>".$row['release_date']."</p>
		    	   </a></div>";
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['release_date'];
			   $arr1[$row['movie_title']][count($arr1[$row['movie_title']])] = $row['movie_lang'];
			}

		      }
	          }
	        }
	   
	     }
	}    
      }
   }
  else{
	header('Location:index.php');
	exit();
  }

?>
</div>
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