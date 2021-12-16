if (link_720p == 0 && link_1080p == 0)
{
	var player = new Playerjs({
        "id":"player",
       "file":link_480p,"qualities":"480p"
        });
}

else if (link_480p == 0 && link_1080p == 0)
{
	var player = new Playerjs({
        "id":"player",
       "file":link_720p,"qualities":"720p"
        });
}

else if (link_480p == 0 && link_720p == 0)
{
	var player = new Playerjs({
        "id":"player",
       "file":link_1080p,"qualities":"1080p"
        });
}


else if (link_480p == 0)
{
	var player = new Playerjs({
        "id":"player",
       "file":link_720p+","+link_1080p,"qualities":"720p,1080p"
        });
}

else if (link_720p == 0)
{
	var player = new Playerjs({
        "id":"player",
       "file":link_480p+","+link_1080p,"qualities":"480p,1080p"
        });
}

else if (link_1080p == 0)
{
	var player = new Playerjs({
        "id":"player",
       "file":link_480p+","+link_720p,"qualities":"480p,720p"
        });
}

else
{
	var player = new Playerjs({
       "id":"player",
      "file":link_480p+","+link_720p+","+link_1080p,"qualities":"480p,720p,1080p"
      });

}


