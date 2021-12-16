<script>    
   var winWidth  = 0;
    $(window).on('load',function() {
    winWidth = $(window).width();
    if (winWidth < 1000)
    {
	 $("#div1").css('display', 'none');
	
    }
    else{
	$("#div1").css('display', 'block');
    }
    });

    $(window).resize(function() {
    winWidth = $(window).width();
    if (winWidth < 1000)
    {
	 $("#div1").css('display', 'none');
	
    }
    else{
	$("#div1").css('display', 'block');
    }
    });

       $(document).ready(function(){
	var limit = 8;
	var start = "<?php echo"$movie_id"?>";
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