<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="anime_discription.css"> 
</head>
<body>

<div id = "discription">

<button class="tablink" onclick="openPage('Overview', this, '#1a1a1a')"id="defaultOpen">Overview</button>
<button class="tablink" onclick="openPage('Information', this, '#1a1a1a')" >Information</button>
<button class="tablink" onclick="openPage('Cast', this, '#1a1a1a')">Characters</button>
<button class="tablink" onclick="openPage('Crew', this, '#1a1a1a')">Staff</button>

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



	<script>
	// Here we define our query as a multi-line string
	// Storing it in a separate .graphql/.gql file is also possible
	var AnilistID = javascript_array3;
	
	var query = `
	query ($id: Int) { # Define which variables will be used in the query (id)
	  Media (id: $id, type: ANIME) { # Insert our variables into the query arguments (id) (type: ANIME is hard-coded in the query)
		id
		title {
		 
		  romaji
		  english
		  native
		}

		staff (perPage:100){
			 edges {
			   node {
				 id
				image {
				  large
				  medium
				}
				name {
				  first
				  last
				  full
				  native
				}
			   }
			  role
			 }
		   } 
		characters(perPage:100) {
		  edges { # Array of character edges
			node { # Character node
			  id
			  image {
				large
				medium
			  }
			  name {
				first
				last
				full
			  }
			}
			role
			voiceActors { # Array of voice actors of this character for the anime
			  id
			  name {
				first
				last
				full
			  }
			  
			}
		   
		  }
		}
		
		source
		favourites
		popularity
		meanScore
		averageScore
		format
		duration
		startDate {
		  year
		  month
		  day
		}
		endDate {
		  year
		  month
		  day
		}
		season
	   genres
		streamingEpisodes {
		  title
		  thumbnail
		  url
		  site
		}
		format
		status
		episodes
		bannerImage
		coverImage {
		  extraLarge
		  large
		  medium
		  color
		}
		description
		title{
		  english
		}

	  }
	}
	`;

	// Define our query variables and values that will be used in the query request
	var variables = {
		id: AnilistID
	};

	// Define the config we'll need for our Api request
	var url = 'https://graphql.anilist.co',
		options = {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
			},
			body: JSON.stringify({
				query: query,
				variables: variables
			})
		};

	// Make the HTTP Api request
	fetch(url, options).then(handleResponse)
					   .then(handleData)
					   .catch(handleError);

	function handleResponse(response) {
		return response.json().then(function (json) {
			return response.ok ? json : Promise.reject(json);
		});
	}

	function handleData(data) {
		
		
		
		
		var movie_img = data['data']['Media']['coverImage']['large'];
		
		document.getElementById('movie_img').src = movie_img;
		
		document.getElementById('overview').innerHTML = "<h2><b>"+JSON.parse(JSON.stringify(data['data']['Media']['title']['romaji'], null, 4))+"</b><br/><span id = 'r_date'>"+JSON.parse(JSON.stringify(data['data']['Media']['title']['english'], null, 4))+"  ------  "+JSON.parse(JSON.stringify(data['data']['Media']['title']['native'], null, 4))+"<br/><br/>"+JSON.parse(JSON.stringify(data['data']['Media']['genres'], null, 4))+"</p><h4><b>Overview</b></h4><p>"+JSON.parse(JSON.stringify(data['data']['Media']['description'], null, 4))+"</p>";
		
	
		document.getElementById('backdrop_img').src = movie_img;
		document.getElementById('backdrop_img').style.width = "36%";
		
		
		var startDate = data['data']['Media']['startDate']['day']+"/"+data['data']['Media']['startDate']['month']+"/"+data['data']['Media']['startDate']['year'];
		var endDate = data['data']['Media']['endDate']['day']+"/"+data['data']['Media']['endDate']['month']+"/"+data['data']['Media']['endDate']['year'];
		
		document.getElementById('information').innerHTML = "<p><b>Format :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['format'], null, 4))+"</span><br/><br/><b>Episodes :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['episodes'], null, 4))+"</span><br/><br/><b>Episode Duration :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['duration'], null, 4))+"</span><br/><br/><b>Status :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['status'], null, 4))+"</span><br/><br/><b>Start Date :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(startDate, null, 4))+"</span><br/><br/><b>End Date :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(endDate, null, 4))+"</span><br/><br/><b>Average Score :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['averageScore'], null, 4))+"%</span><br/><br/><b>Mean Score :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['meanScore'], null, 4))+"%</span><br/><br/><b>Popularity :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['popularity'], null, 4))+"</span><br/><br/><b>Favorites :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['favourites'], null, 4))+"</span><br/><br/><b>Source :</b>&nbsp;<span>"+JSON.parse(JSON.stringify(data['data']['Media']['source'], null, 4))+"</span></p>";
		
		var count = 0;
		var table = document.getElementById("cast");
		
		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);	
			
		for (i = 0; i < data['data']['Media']['characters']['edges'].length; i++) {
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
			var profile_path = JSON.parse(JSON.stringify(data['data']['Media']['characters']['edges'][i]['node']['image']['large'], null, 4));			
			if (profile_path == null){
				var cell = row.insertCell(count);
				var element = "<img src = https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcS0PYuh3GbOstcwFJLzp6ThS_ta-XK_4vDKt5U7i18cfexXRuMX&usqp=CAU.jpg height='120'><br/><p><b>"+JSON.parse(JSON.stringify(data['credits']['cast'][i]['name'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['credits']['cast'][i]['character'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}
			else{
					var cell = row.insertCell(count);
				var element = "<img src ="+profile_path +" ><br/><p><b>"+JSON.parse(JSON.stringify(data['data']['Media']['characters']['edges'][i]['node']['name']['full'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['data']['Media']['characters']['edges'][i]['role'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}

			   count = count + 1;
		 
		
		}

		var count = 0;
		 var table = document.getElementById("crew");
		
		  var rowCount = table.rows.length;
		  var row = table.insertRow(rowCount);
		  for (i = 0; i < data['data']['Media']['staff']['edges'].length; i++) {
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
			var profile_path = JSON.parse(JSON.stringify(data['data']['Media']['staff']['edges'][i]['node']['image']['large'], null, 4));			
			if (profile_path == null){
				var cell = row.insertCell(count);
				var element = "<img src = https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcS0PYuh3GbOstcwFJLzp6ThS_ta-XK_4vDKt5U7i18cfexXRuMX&usqp=CAU.jpg height='120'><br/><p><b>"+JSON.parse(JSON.stringify(data['credits']['crew'][i]['name'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['credits']['crew'][i]['job'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}
			else{
			        var cell = row.insertCell(count);
				var element = "<img src = "+profile_path +" ><br/><p><b>"+JSON.parse(JSON.stringify(data['data']['Media']['staff']['edges'][i]['node']['name']['full'], null, 4)) + "</b><br/><span>" + JSON.parse(JSON.stringify(data['data']['Media']['staff']['edges'][i]['role'], null, 4))+"</span></p><br/>";
				cell.innerHTML = element;
			}

		       count = count + 1;
		     
			
		  }	
		  
		const collapseButton = document.getElementById("collapse");
		const playlist = document.getElementById("playlist");

		collapseButton.onclick = function () {
		  if (collapseButton.className == "fa fa-angle-down") {
			collapseButton.className = "fa fa-angle-up";
			playlist.style.display = "block";
		  } else {
			collapseButton.className = "fa fa-angle-down";
			playlist.style.display = "none";
		  }
		};



		var arr3 = javascript_array;
		var ind = javascript_array2;
		console.log(arr3);
		var arr6 = [];
		if (data['data']['Media']['streamingEpisodes'].length != 0){
			for (i = 0; i < arr3.length; i++){
				arr6[i] = data['data']['Media']['streamingEpisodes'][i];
				arr6[i].ShowTitle = arr3[i].ShowTitle;
				arr6[i].ShowID = arr3[i].ShowID;
				arr6[i].EpisodeID = arr3[i].EpisodeID;
				arr6[i].AnilistID = arr3[i].AnilistID;
				arr6[i].id = arr3[i].id;
				arr6[i].Server = arr3[i].Server;
			}
			 console.log(arr6);
			  arr6.forEach(function (data) {
			  var item = document.createElement("div");
			  
			  item.innerHTML = `
			  <div class="listItem" onclick= "itemFromList('${data.ShowTitle}', ${data.ShowID}, ${data.EpisodeID}, ${data.AnilistID}, ${data.Server})">
			  <div class="videoId" >${data.id}</div>
			  <i class="fa fa-play" style="display:none;font-size:10px;"></i>
			  <div class="itemImage">
				<img src="${data.thumbnail}" alt="" />
			  </div>
			  <div class="itemInfo" style="padding: 0px 8px;">
				<div class="videoTitle" style="
				margin: 0 0 4px 0;
				display: -webkit-box;
				max-height: calc(2 * var(--yt-link-line-height, 1.6rem));
				-webkit-box-orient: vertical;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: normal;
				-webkit-line-clamp: 2;">${data.title}</div>

				<div class="videoOwner" style="text-overflow: ellipsis;overflow-x: hidden;white-space: nowrap;display: block;max-height: 18;overflow: hidden;font-size: 13px;">${data.ShowTitle}</div>
			  </div>
			  </div>
				`;
			  
			  playlist.appendChild(item);
			  
			  
			});

		}
		else{
			arr3.forEach(function (data) {
			  var item = document.createElement("div");
			  
			  item.innerHTML = `
			  <div class="listItem" onclick= "itemFromList('${data.ShowTitle}', ${data.ShowID}, ${data.EpisodeID}, ${data.AnilistID}, ${data.Server})">
			  <div class="videoId" >${data.id}</div>
			  <i class="fa fa-play" style="display:none;font-size:10px;"></i>
			  <div class="itemImage">
				<img src="${data.image}" alt="" />
			  </div>
			  <div class="itemInfo" style="padding: 0px 8px;">
				<div class="videoTitle" style="
				margin: 0 0 4px 0;
				display: -webkit-box;
				max-height: calc(2 * var(--yt-link-line-height, 1.6rem));
				-webkit-box-orient: vertical;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: normal;
				-webkit-line-clamp: 2;">${data.ShowTitle}</div>

				<div class="videoOwner" style="text-overflow: ellipsis;overflow-x: hidden;white-space: nowrap;display: block;max-height: 18;overflow: hidden;font-size: 13px;">Episode - ${data.EpisodeID}</div>
			  </div>
			  </div>
				`;
			  
			  playlist.appendChild(item);
			 });
		}
		

		

		document.getElementsByClassName('listItem')[ind-1].classList.add("selectedItem");
		document.getElementsByClassName('fa-play')[ind-1].style.display = "block";
		document.getElementsByClassName('videoId')[ind-1].style.display = "none";
		  
		  
		
	  
	}
	
	function handleError(error) {
		alert('Error, check console');
		console.error(error);
	}
	</script>





    <script>
       
	  function itemFromList(ShowTitle, ShowID, EpisodeID, AnilistID, Server){
			window.location.href = 'animeSubpage.php?ShowTitle='+ShowTitle+'&ShowID='+ShowID+'&EpisodeID= '+EpisodeID+'&AnilistID= '+AnilistID+'&Server= '+Server;
		}


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