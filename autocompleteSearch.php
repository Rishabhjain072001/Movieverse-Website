<!-- autocomplete search code -->

<script>
$(document).ready(function(){
   $('#movie').keypress(function(){
    $('#movie').keyup(function(){
	var query = $(this).val();
	if(query != '')
	{
	    $.ajax({
		url:"searchList.php",
		method:"POST",
		data:{query:query},
		success:function(data)
		{
			
			$('#movieList').fadeIn();
			$('#movieList').html(data);
			
		}
	    });
	
	}
	else{
		$('#movieList').fadeOut();
		$('#movieList').html("");
	}
    });
    });

    var pointer = 1;
    $('#movie').on('keydown', function(event) {
    switch(event.keyCode){
        case 38: // Up arrow
	   event.preventDefault();
	   var strLength = $('#movie').val().length * 2;
	   movie.setSelectionRange(strLength, strLength);
        			
	   if (pointer === 1){
		$('#movie').off('keyup');
		$(".movie-list:nth-child("+pointer+")").removeClass("highlight");
		while ($(".movie-list:nth-child("+pointer+")").length > 0){
			pointer = pointer + 1;
		}
		$(".movie-list:nth-child("+pointer+")").addClass("highlight"); 
		$('#movie').val($(".movie-list:nth-child("+pointer+")").text());
	  }
	  else{
		$('#movie').off('keyup');
		$(".movie-list:nth-child("+pointer+")").removeClass("highlight");
		pointer = pointer - 1;
		$(".movie-list:nth-child("+pointer+")").addClass("highlight");
		$('#movie').val($(".movie-list:nth-child("+pointer+")").text());
	   }
         break;
	case 40: // Down arrow

	    if (pointer === 1){
		$('#movie').off('keyup');
		$(".movie-list:first-child").addClass("highlight"); 
		$('#movie').val($(".movie-list:first-child").text());
		pointer = pointer + 1; 
      	     }
	    else{
		$('#movie').off('keyup');
		if($(".movie-list:nth-child("+pointer+")").length > 0){
		    var privious = pointer - 1; 
		    $(".movie-list:nth-child("+privious+")").removeClass("highlight");
		    $(".movie-list:nth-child("+pointer+")").addClass("highlight");
		    $('#movie').val($(".movie-list:nth-child("+pointer+")").text());
		    pointer = pointer + 1;
		}
		else{
		    var privious = pointer - 1; 
		    $(".movie-list:nth-child("+privious+")").removeClass("highlight");
		    pointer = 1;
		    $(".movie-list:nth-child("+pointer+")").addClass("highlight");
		    $('#movie').val($(".movie-list:nth-child("+pointer+")").text());
		    pointer = pointer + 1;		
	        }
	     }
	break;
		  
	default:
		
		pointer = 1;
		while ($(".movie-list:nth-child("+pointer+")").length > 0){
		    $(".movie-list:nth-child("+pointer+")").removeClass("highlight");
		    pointer = pointer + 1;
		}
		pointer = 1;
       }
    });

    $(document).on('click','.movie-list',function(){
	$('#movie').val($(this).text());
	$('#movieList').fadeOut();
	document.getElementById("clickSearch").click();
    });



    $(window).click(function() {
	$('#movieList').fadeOut();
	$('#movieList').html("");
   });
    
});
</script>

