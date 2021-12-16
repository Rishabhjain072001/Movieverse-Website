<?php
   date_default_timezone_set('Europe/copenhagen');
  
  
   require 'includes/dbh.inc.php';
   require 'includes/comments.inc.php';
  
   session_start();
?>
<!DOCTYPE html>
<html>
 <head>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- Our Custom CSS -->
   <link rel="stylesheet" href="homepage.css">
   <title>MovieVerse</title>
 </head>
 <body>
   <header>
        <?php
          require 'headerofhomepage.php';
        ?>
	
	<!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
	     var width;
		window.onresize = window.onload = function() {
    		width = this.outerWidth;
		if (width >= 1433){
		  document.getElementById("div1").style.marginLeft = "18%";	
   		}
		else if (width >= 1285){
		  document.getElementById("div1").style.marginLeft = "21%";	
   		}
    		else if (width >= 1267){
		  document.getElementById("div1").style.marginLeft = "19%";	
   		}
		else if (width >= 1263){
		  document.getElementById("div1").style.marginLeft = "10%";	
   		}
	     }
	
             $(document).ready(function () {
		 var act = "off";
                  $('#sidebarCollapse').on('click', function () {
		  if (act === "off"){	
			var w = window.outerWidth;
		  	$('#sidebar').toggleClass('active'); 
			if (w <= 523){
			 document.getElementById("div1").style.marginLeft = "21%";
			}
			else{
			  document.getElementById("div1").style.marginLeft = "11%";
			}
                         act ="on";
		  }  
		  else if (act === "on"){
			 var w = window.outerWidth;
			 $('#sidebar').toggleClass('active');
			 if (w <= 1263){
			  document.getElementById("div1").style.marginLeft = "8%";
			 }
			 else if (w <= 1359){
			  document.getElementById("div1").style.marginLeft = "20%";
			 }
			 else{
		     	   document.getElementById("div1").style.marginLeft = "18%";
			 }
                     	 act ="off";
		     }
		 });	
             });
         </script>
   </header>

<script>
   
   $(document).ready(function(){
	var limit = 12;
	var start = 0;
	var action = 'inactive';

	function load_country_data(limit, start){
	   $.ajax({
		url:"fetchhomepagedata.php",
		method:"POST",
		data:{limit:limit, start:start},
		cache:false,
		success:function(data)
		{
		    $('#div1').append(data);
		    if(data == '')
		    {
			
		    	action = "active";
		    }
		    else{
			
			action = "inactive";
		    }
		}
	   });
	}
	
	if(action == 'inactive')
	{
		action = 'action';
		load_country_data(limit, start);
	}
	$(window).scroll(function(){
	   if($(window).scrollTop() + $(window).height() > $("#div1").height() && action == 'inactive')
	   {
		action = 'active';
		start = start + limit;
		setTimeout(function(){
		  load_country_data(limit, start);
		}, 1000);
		
	   }
	})
 });
</script>


<div id ="div1">
	
</div>

</body>
</html>