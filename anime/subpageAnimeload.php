<script>    
   
       $(document).ready(function(){
	var limit = 8;
	var ind = 0;
	var start = "<?php echo"$ShowID"?>";
	var action = 'inactive';

	function load_country_data(limit, start, ind){
	   $.ajax({
		url:"fetchanimeSubpagedata.php",
		method:"POST",
		data:{limit:limit, start:start, ind:ind},
		cache:false,
		success:function(data)
		{
		    $('.sideVideo').append(data);
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
		load_country_data(limit, start, ind);
	}
	/*$(window).scroll(function(){
	   if($(window).scrollTop() + $(window).height() > $(".sideVideo").height() && action == 'inactive')
	   {
		action = 'active';
		start = start + limit;
		ind = ind + limit;
		setTimeout(function(){
		  load_country_data(limit, start, ind);
		}, 1000);
		
	   }
	})*/
 });

</script>