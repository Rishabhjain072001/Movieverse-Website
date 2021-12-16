<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

 <?php

function getComments($conn){
	$movie_title = mysqli_real_escape_string($conn, trim($_GET['movie_title']));
   	$movie_id = mysqli_real_escape_string($conn, trim($_GET['movie_id']));
	$release_date = mysqli_real_escape_string($conn, trim($_GET['release_date']));
	$movie_lang = mysqli_real_escape_string($conn, trim($_GET['movie_lang']));
	$tmdb_id = mysqli_real_escape_string($conn, trim($_GET['tmdb_id']));

	$sql = "SELECT * FROM comments WHERE movie_id = '$movie_id' AND movie_title = '$movie_title' ORDER BY date DESC ";
	$result = $conn->query($sql);
	
        while($row = $result->fetch_assoc()){
            $idUsers = $row['uidUsers'];
	    $sql2 = "SELECT * FROM users WHERE idUsers='$idUsers'";
	    $result2 = $conn->query($sql2);
	    if ($row2 = $result2->fetch_assoc()) {
	       $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='$idUsers'";
	       $resultImg = mysqli_query($conn, $sqlImg);
	       while($rowImg = mysqli_fetch_assoc($resultImg)){
		
		 if ($rowImg['status'] == 0){
			echo "<img class='profileImg' src='includes/uploads/profile".$idUsers.".png?'".mt_rand()." width = '200' height ='300'>";

		 }
		 else{
			$firstLetter = substr(strtoupper($row2["uidUsers"]),0,1);
			echo "<img class='profileImg' src='includes/uploads/default/".$firstLetter.".png' width = '200' height ='300'>";
		 }
		 
	      }	
 	  

	
	       echo "<div class='comment-box'><p>";
		echo "<div class='comment-content'><p>";
		echo $row2['uidUsers']."&nbsp; &nbsp;";
		echo "<span>".$row['date']."</span><br>";
		echo nl2br($row['message']);
		echo "</div>";
	        echo "</p>";
		if (isset($_SESSION['userId'])){
			if ($_SESSION['userId'] == $row2['idUsers']){
			
			    echo"
				<svg onclick='showOption(this)' class = 'three_dots' class='bi bi-three-dots-vertical' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  				<path fill-rule='evenodd' d='M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z'/>
				</svg>
			     ";
			    
			     echo "
				<form class='delete-form' method='POST' action='includes/deleteCommentReply.php' style = 'display:none;'>
		                <input type ='hidden' name='cid' value='".$row['cid']."'>
				<input type = 'hidden' name='movie_title' value='$movie_title'>
		    		<input type = 'hidden' name='movie_id' value='$movie_id'>
				<input type = 'hidden' name='release_date' value='$release_date'>
				<input type = 'hidden' name='movie_lang' value='$movie_lang'>
				<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
				<button type='submit' name='commentDelete'>
				<svg class = 'trash_icon' class='bi bi-trash' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  				<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
  				<path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
				</svg>
				DELETE</button>
	              	     </form>
		      	     	
		   	     
				<button  class ='edit-btn' onclick='editComment(this)' style = 'display:none;'>
				<svg class ='pencil_icon' class='bi bi-pencil' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  				<path fill-rule='evenodd' d='M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z'/>
  				<path fill-rule='evenodd' d='M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z'/>
				</svg>
				EDIT</button>
			        
		     	     ";
			   

			   echo "<form class='edit-form' method='POST' action='includes/editComment.php' style = 'display:none;'>
  				<input type ='hidden' name='cid' value='".$row['cid']."'>
				<input type ='hidden' name='uidUsers' value='".$row['uidUsers']."'>
  				<input type = 'hidden' name='date' value='".$row['date']."'>
				<input type = 'hidden' name='movie_title' value='$movie_title'>
		    		<input type = 'hidden' name='movie_id' value='$movie_id'>
				<input type = 'hidden' name='release_date' value='$release_date'>
				<input type = 'hidden' name='movie_lang' value='$movie_lang'>
				<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
  				<textarea  name ='message'>".$row['message']."</textarea><br>
				<button  name='cancelEditComment'>CANCEL</button>
  				<button type='submit' name='commentSubmit'>EDIT</button>
				</form>";




			} else {
      				echo "
		       		<button class='reply-btn' onclick='reply(this)' name='commentDelete'>REPLY</button>
	              	     	";
				
			
				echo "<form class='reply-form' method='POST' action='includes/replyComment.php' style = 'display:none;'>
  				<input type ='hidden' name='cid' value='".$row['cid']."'>
  				<input type ='hidden' name='uidUsers' value='".$_SESSION['userId']."'>
  				<input type = 'hidden' name='date' value='".date('Y-m-d H:i:s')."'>
  				<textarea  name ='message'></textarea><br>
				<input type = 'hidden' name='movie_title' value='$movie_title'>
  				<input type = 'hidden' name='movie_id' value='$movie_id'>
  				<input type = 'hidden' name='release_date' value='$release_date'>
  				<input type = 'hidden' name='movie_lang' value='$movie_lang'>
  				<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
				<button name='cancelReply'>CANCEL</button>
  				<button type='submit' name='commentReply'>REPLY</button>
				</form>
				";
				
			}
		} 	         
	        echo "</div>";
		$p_cid = $row['cid'];
		$sql3 = "SELECT * FROM reply WHERE p_cid='$p_cid' ORDER BY date DESC";
		$result3 = $conn->query($sql3);	
		
        	while($row3 = $result3->fetch_assoc()){
			$idUsers = $row3['uidUsers'];
	   	        $sql2 = "SELECT * FROM users WHERE idUsers='$idUsers'";
	    		$result2 = $conn->query($sql2);

		
			if ($row2 = $result2->fetch_assoc()) {
			
			   $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='$idUsers'";
	       		   $resultImg = mysqli_query($conn, $sqlImg);
	       		   while($rowImg = mysqli_fetch_assoc($resultImg)){
			    if ($rowImg['status'] == 0){
				echo "<img class='replyprofileImg' src='includes/uploads/profile".$idUsers.".png?'".mt_rand()." width = '200' height ='300'>";

		 	    }
		 	    else{
			   	$firstLetter = substr(strtoupper($row2["uidUsers"]),0,1);
				echo "<img class='replyprofileImg' src='includes/uploads/default/".$firstLetter.".png' width = '200' height ='300'>";
		 	    }
	      		   }	
			
	       		   echo "<div class='Reply-box'><p>";
			   echo "<div class='reply-content'><p>";
			   echo $row2['uidUsers']."&nbsp; &nbsp;";
			   echo "<span>".$row3['date']."</span><br>";
			   echo nl2br($row3['message']);
			   echo "</div>";
	        	   echo "</p>";
			   if (isset($_SESSION['userId'])){
				 if ($_SESSION['userId'] == $row3['uidUsers']){

					echo"
					<svg onclick='showReplyOption(this)' class = 'three_dots' class='bi bi-three-dots-vertical' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  					<path fill-rule='evenodd' d='M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z'/>
					</svg>
			     		";
					
			     		echo "<form class='delete-form' method='POST' action='includes/deleteCommentReply.php' style = 'display:none;'>
		                	<input type ='hidden' name='rid' value='".$row3['rid']."'>
					<input type = 'hidden' name='movie_title' value='$movie_title'>
		    			<input type = 'hidden' name='movie_id' value='$movie_id'>
					<input type = 'hidden' name='release_date' value='$release_date'>
					<input type = 'hidden' name='movie_lang' value='$movie_lang'>
					<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
		       			<button type='submit' name='replyDelete'>
					<svg class = 'trash_icon' class='bi bi-trash' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  					<path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
  					<path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
					</svg>
					DELETE</button>
	              	     		</form>
		      	     		
    				        <button  class ='editReply-btn' onclick='editReply(this)' style = 'display:none;'>
					<svg class ='pencil_icon' class='bi bi-pencil' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
  					<path fill-rule='evenodd' d='M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z'/>
  					<path fill-rule='evenodd' d='M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z'/>
					</svg>
					EDIT</button>
		   	 		
		     	     		";

					echo "<form class='editreply-form' method='POST' action='includes/editReply.php' style = 'display:none;'>
  					<input type ='hidden' name='rid' value='".$row3['rid']."'>
  
 					<input type ='hidden' name='uidUsers' value='".$row3['uidUsers']."'>
  					<input type = 'hidden' name='date' value='".$row3['date']."'>
  					<textarea  name ='message'>".$row3['message']."</textarea><br>
					<input type = 'hidden' name='movie_title' value='$movie_title'>
		    			<input type = 'hidden' name='movie_id' value='$movie_id'>
					<input type = 'hidden' name='release_date' value='$release_date'>
					<input type = 'hidden' name='movie_lang' value='$movie_lang'>
					<input type = 'hidden' name='tmdb_id' value='$tmdb_id'>
					<button name='cancelEditReply'>CANCEL</button>
  					<button type='submit' name='replySubmit'>EDIT</button>
					</form>";
			 	 }
			   } 	
			   echo "</div>";
		       }
		}
	   }	
	    
	 }
	
}

	
?>


<script>



function showReplyOption(caller) {
	var visible = "false";
	$(caller).parent().children(".editReply-btn").show();
	$(caller).parent().children(".delete-form").show();
	visible = "true";
	$(document).click(function(e){
          if(visible == "true"){
    		if( $(e.target).closest(".three_dots").length > 0 ) {
        	  return false;
    		}
    		$(caller).parent().children(".editReply-btn").hide();
		$(caller).parent().children(".delete-form").hide();
		
   	   }
	});
}



function showOption(caller) {
	var visible = "false";
	$(caller).parent().children(".edit-btn").show();
	$(caller).parent().children(".delete-form").show();
	visible = "true";
	$(document).click(function(e){
          if(visible == "true"){
    		if( $(e.target).closest(".three_dots").length > 0 ) {
        	  return false;
    		}
    		$(caller).parent().children(".edit-btn").hide();
		$(caller).parent().children(".delete-form").hide();
		
   	   }
	});
}


 



function reply(caller) {
	$(caller).parent().children(".reply-form").show();
}


function editComment(caller) {
	$(caller).parent().children(".edit-form").show();
	$(caller).parent().children(".comment-content").hide();
	$(caller).parent().children(".delete-form").hide();
	$(caller).parent().children(".edit-btn").hide();
	$(caller).parent().children(".three_dots").hide();
}


function editReply(caller) {
	$(caller).parent().children(".editreply-form").show();
	$(caller).parent().children(".reply-content").hide();
	$(caller).parent().children(".delete-form").hide();
	$(caller).parent().children(".editReply-btn").hide();
	$(caller).parent().children(".three_dots").hide();
}
</script>
