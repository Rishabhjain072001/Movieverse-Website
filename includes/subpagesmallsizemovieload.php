<script>
var winWidth  = 0;
    $(window).on('load',function() {
    winWidth = $(window).width();
    if (winWidth < 1000)
    {
	 $("#div2").css('display', 'block');
	 $("#showmorebtn").css('display', 'block');
	
    }
    else{
	$("#div2").css('display', 'none');
	$("#showmorebtn").css('display', 'none');
    }
    });

    $(window).resize(function() {
    winWidth = $(window).width();
    if (winWidth < 1000)
    {
	 $("#div2").css('display', 'block');
	 $("#showmorebtn").css('display', 'block');
    }
    else{
	$("#div2").css('display', 'none');
	$("#showmorebtn").css('display', 'none');
    }
    });

   $(document).ready(function(){
	var movieCount = 2;
	var movie_id = "<?php echo"$movie_id"?>"; 
	$("#showmorebtn").click(function(){
		movieCount = movieCount + 2;
		$("#div2").load("fetchsubpagedata.php", {
			movie_id: movie_id,
			movieNewCount: movieCount
		});
	});
	
	

   });
</script>