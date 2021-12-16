<!DOCTYPE html>
<html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<body>

  <div class="download">
  <div class="downloadbtn" onClick="showDownloadlink()">
  <svg class="download-icon" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
  <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
  </svg>
  <div class='download-text'>DOWNLOAD</div>
  </div>
  <div class="download-content">
  <?php
  if ($link_720p == "0" && $link_1080p == "0"){
    echo "<a href='$link_480p'>480p</a>";
  }
  else if ($link_480p == "0" && $link_1080p == "0"){
    echo "<a href='$link_720p'>720p</a>";
  }
  else if ($link_480p == "0" && $link_720p == "0"){
    echo "<a href='$link_1080p'>1080p</a>";
  }
  else if ($link_480p == "0"){
    echo "<a href='$link_720p'>720p</a>
      <a href='$link_1080p'>1080p</a>";
  }
  else if ($link_720p == "0"){
    echo "<a href='$link_480p'>480p</a>
      <a href='$link_1080p'>1080p</a>";
  }
  else if ($link_1080p == "0"){
    echo "<a href='$link_480p'>480p</a>
      <a href='$link_720p'>720p</a>";
  }
  else {
     echo "<a href='$link_480p'>480p</a>
       <a href='$link_720p'>720p</a>
       <a href='$link_1080p'>1080p</a>";
  }
  ?>
  </div>
</div>

<script>
var status = "off"
function showDownloadlink(){
if (status == "off"){
	document.getElementsByClassName("download-content")[0].style.display = "block";
	status = "on";
}
else if(status = "on"){
	document.getElementsByClassName("download-content")[0].style.display = "none";
	status = "off";
}

$(document).ready(function(){
$(window).click(function(e) {
	if(!$(e.target).closest(".download").length > 0 ) {
	  if (status == "on"){
            document.getElementsByClassName("download-content")[0].style.display = "none";
	    status = "off";
 	  }
        }
 });
});
}
</script>
</body>
</html>