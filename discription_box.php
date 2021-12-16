<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="discription2.css"> 
</head>
<body>

<div id = "discription">

<button class="tablink" onclick="openPage('Overview', this, '#1a1a1a')"id="defaultOpen">Overview</button>
<button class="tablink" onclick="openPage('Information', this, '#1a1a1a')" >Information</button>
<button class="tablink" onclick="openPage('Cast', this, '#1a1a1a')">Cast</button>
<button class="tablink" onclick="openPage('Crew', this, '#1a1a1a')">Crew</button>

<div id="Overview" class="tabcontent">
<table id="movie_overview">
 <tr>
 <td><img id ="movie_img"/></td>
 <td> <div id="overview"></div></td>
 </tr>
</table>       
</div>

<div id="Information" class="tabcontent">
<table id="movie_info">
 <tr>
 <td><img id ="backdrop_img"/></td>
 <td> <div id="information"></div></td>
 </tr>
</table>   
</div>

<div id="Cast" class="tabcontent">

<table id="cast">
<tr>
 
</tr>  
</table>
<button type="button" id="show_more_cast_btn" onclick="ShowMoreCastFunction()">Show more</button>
<button type="button" id="show_less_cast_btn" onclick="ShowLessCastFunction()">Show less</button>
</div>

<div id="Crew" class="tabcontent">
<table id="crew">
<tr>
 
</tr>
    
</table>
<button type="button" id="show_more_crew_btn" onclick="ShowMoreCrewFunction()">Show more</button>
<button type="button" id="show_less_crew_btn" onclick="ShowLessCrewFunction()">Show less</button>
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



    <script src="js/key.js"></script>
    <script>
        var tmdb_id = "<?php echo $tmdb_id ?>";
        /*************
        SAMPLE URLS
        
        1. To get the config data like image base urls
        https://api.themoviedb.org/3/configuration?api_key=<APIKEY>
        
        2. To fetch a list of movies based on a keyword
        https://api.themoviedb.org/3/search/movie?api_key=<APIKEY>&query=<keyword>
        
        3. To fetch more details about a movie
        https://api.themoviedb.org/3/movie/1726?api_key=<APIKEY>

	
        *************/
        //const APIKEY is inside key.js
        let baseURL = 'https://api.themoviedb.org/3/';
        let configData = null;
        let baseImageURL = null;
        let getConfig = function () {
            let url = "".concat(baseURL, 'movie/'+tmdb_id+'?api_key=', APIKEY,'&append_to_response=credits'); 
	     	  
            fetch(url)
            .then((result)=>{
                return result.json();
            })
            .then((data)=>{
                
                console.log('config:', data);
                console.log('config fetched');
                
		var movie_img = data['poster_path'];
		
		document.getElementById('movie_img').src = "https://image.tmdb.org/t/p/w185"+movie_img;
		
		var genres = []
		for (i = 0; i < data['genres'].length; i++)
		{
		  genres.push(data['genres'][i]['name']);
		}
		
		document.getElementById('overview').innerHTML = "<h2><b>"+JSON.parse(JSON.stringify(data['original_title'], null, 4))+"</b><br/><span id = 'r_date'>"+JSON.parse(JSON.stringify(data['release_date'], null, 4))+"&nbsp; &nbsp;.&nbsp;"+genres+"&nbsp;.<span></h2><p id = 'tagline'>"+ JSON.parse(JSON.stringify(data['tagline'], null, 4)) +"</p><h4><b>Overview</b></h4><p>"+JSON.parse(JSON.stringify(data['overview'], null, 4))+"</p>";
		

		var backdrop_img = data['backdrop_path'];
		if (backdrop_img == null){
			document.getElementById('backdrop_img').src = "https://image.tmdb.org/t/p/w185"+movie_img; 
			document.getElementById('backdrop_img').style.width = "35%";
		}
		else{
			document.getElementById('backdrop_img').src = "https://image.tmdb.org/t/p/w185"+backdrop_img; 
		}
		document.getElementById('information').innerHTML = "<p><b>Status :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['status'], null, 4))+"</span><br/><br/><b>Original Language :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['original_language'], null, 4))+"</span><br/><br/><b>Budget :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['budget'], null, 4))+"</span><br/><br/><b>Revenue :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['revenue'], null, 4))+"</span><br/><br/><b>Adult :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['adult'], null, 4))+"</span><br/><br/><b>Popolarity :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['popularity'], null, 4))+"</span><br/><br/><b>Vote Average :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['vote_average'], null, 4))+"</span><br/><br/><b>Vote Count :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['vote_count'], null, 4))+"</span></p>";		

        	 var count = 0;
		 var table = document.getElementById("cast");
		
		  var rowCount = table.rows.length;
		  var row = table.insertRow(rowCount);
		  for (i = 0; i < data['credits']['cast'].length; i++) {
		        if (count == 4){	
			  count = 0;
			  var table = document.getElementById("cast");

			  var rowCount = table.rows.length;
			  var row = table.insertRow(rowCount);
		        }
			if (i >= 8){
				document.getElementById("show_more_cast_btn").style.display = "block";
				row.classList.add("hiderow");
				
			}
			var profile_path = JSON.parse(JSON.stringify(data['credits']['cast'][i]['profile_path'], null, 4));			
			if (profile_path == null){
				var cell = row.insertCell(count);
				var element = "<img src = https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcS0PYuh3GbOstcwFJLzp6ThS_ta-XK_4vDKt5U7i18cfexXRuMX&usqp=CAU.jpg height='120'><br/><p><b>"+JSON.parse(JSON.stringify(data['credits']['cast'][i]['name'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['credits']['cast'][i]['character'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}
			else{
			        var cell = row.insertCell(count);
				var element = "<img src = https://image.tmdb.org/t/p/w185"+profile_path +" ><br/><p><b>"+JSON.parse(JSON.stringify(data['credits']['cast'][i]['name'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['credits']['cast'][i]['character'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}

		       count = count + 1;
		     
			
		  }	

		 var count = 0;
		 var table = document.getElementById("crew");
		
		  var rowCount = table.rows.length;
		  var row = table.insertRow(rowCount);
		  for (i = 0; i < data['credits']['crew'].length; i++) {
		        if (count == 4){	
			  count = 0;
			  var table = document.getElementById("crew");

			  var rowCount = table.rows.length;
			  var row = table.insertRow(rowCount);
		        }
			if (i >= 8){
				document.getElementById("show_more_crew_btn").style.display = "block";
				row.classList.add("hiderow");
				
			}
			var profile_path = JSON.parse(JSON.stringify(data['credits']['crew'][i]['profile_path'], null, 4));			
			if (profile_path == null){
				var cell = row.insertCell(count);
				var element = "<img src = https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcS0PYuh3GbOstcwFJLzp6ThS_ta-XK_4vDKt5U7i18cfexXRuMX&usqp=CAU.jpg height='120'><br/><p><b>"+JSON.parse(JSON.stringify(data['credits']['crew'][i]['name'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['credits']['crew'][i]['job'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}
			else{
			        var cell = row.insertCell(count);
				var element = "<img src = https://image.tmdb.org/t/p/w185"+profile_path +" ><br/><p><b>"+JSON.parse(JSON.stringify(data['credits']['crew'][i]['name'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['credits']['crew'][i]['job'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}

		       count = count + 1;
		     
			
		  }	
            })
            .catch(function(err){
                alert(err);
            });
        }
        
        
       
        document.addEventListener('DOMContentLoaded', getConfig);


   function ShowMoreCastFunction() {
      document.getElementById("show_more_cast_btn").style.display = "none";
      document.getElementById("show_less_cast_btn").style.display = "block";

     var table = document.getElementById("cast");
	var rowCount = table.rows.length;
        for (var i = 3; i < rowCount; i++) {
  		document.getElementById("cast").rows[i].classList.remove("hiderow");
        }
    }

    function ShowLessCastFunction() {
	document.getElementById("show_more_cast_btn").style.display = "block";
       document.getElementById("show_less_cast_btn").style.display = "none";

	var table = document.getElementById("cast");
	var rowCount = table.rows.length;
        for (var i = 3; i < rowCount; i++) {
  		document.getElementById("cast").rows[i].classList.add("hiderow");
        }
    }

    function ShowMoreCrewFunction() {
      document.getElementById("show_more_crew_btn").style.display = "none";
      document.getElementById("show_less_crew_btn").style.display = "block";

     var table = document.getElementById("crew");
	var rowCount = table.rows.length;
        for (var i = 3; i < rowCount; i++) {
  		document.getElementById("crew").rows[i].classList.remove("hiderow");
        }
    }

    function ShowLessCrewFunction() {
	document.getElementById("show_more_crew_btn").style.display = "block";
       document.getElementById("show_less_crew_btn").style.display = "none";

	var table = document.getElementById("crew");
	var rowCount = table.rows.length;
        for (var i = 3; i < rowCount; i++) {
  		document.getElementById("crew").rows[i].classList.add("hiderow");
        }
    }
   
    </script>
</body>
</html>