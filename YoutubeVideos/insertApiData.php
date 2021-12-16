<?php

require '../includes/dbh.inc.php';


$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, 'https://30562.wayscript.io/');
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

$jsonData = json_decode(curl_exec($curlSession), true);
curl_close($curlSession);

$visitdata = $jsonData['visitdata'];
$token = $jsonData['token'];


$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, "http://Movieverse-youtube.herokuapp.com/apihomestar/".$visitdata."/".$token);
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

$jsonData2 = json_decode(curl_exec($curlSession), true);
curl_close($curlSession);


$arr = array();
$singleArr = array();
$playlistArr = array();
$tempArr = array();
$tempArr2 = array();
$c = 1;

for($i=0; $i<count($jsonData2['Single']); $i++){
	if(!in_array($jsonData2['Single'][$i]['id'], $arr)){
		array_push($arr,$jsonData2['Single'][$i]['id']);
		
		$singleChannel = $jsonData2['Single'][$i]['channel'];
		
		
		if($jsonData2['Single'][$i]['channel_image'] != 'Null'){
			$singleChannelImg = $jsonData2['Single'][$i]['channel_image'][0]['url'];
			
		}
		else{
			$singleChannelImg = $jsonData2['Single'][$i]['channel_image'];
			
		}
		
		$singleId = $jsonData2['Single'][$i]['id'];
		
		
		$singlePubtime = $jsonData2['Single'][$i]['pubtime'];
	
		
		if($jsonData2['Single'][$i]['richthumb'] != 'Null'){
			$singleRichThumb = $jsonData2['Single'][$i]['richthumb']['url'];
			
		}
		else{
			$singleRichThumb = $jsonData2['Single'][$i]['richthumb'];
			
		}
		
		
		if($jsonData2['Single'][$i]['thumbnails'] != 'Null'){
			$singleThumbnail = $jsonData2['Single'][$i]['thumbnails'][0]['url'];
			
		}
		else{
			$singleThumbnail = $jsonData2['Single'][$i]['thumbnails'];
			
		}
		
		
		$singleTime = $jsonData2['Single'][$i]['time'];
		
		
		$singleTitle = $jsonData2['Single'][$i]['title'];
		
		
		$singleViews = $jsonData2['Single'][$i]['views'];	
		
		$tempArr['singleChannel'] = $singleChannel;
		$tempArr['singleChannelImg'] = $singleChannelImg;
		$tempArr['singleId'] = $singleId;
		$tempArr['singlePubtime'] = $singlePubtime;
		$tempArr['singleRichThumb'] = $singleRichThumb;
		$tempArr['singleThumbnail'] = $singleThumbnail;
		$tempArr['singleTime'] = $singleTime;
		$tempArr['singleTitle'] = $singleTitle;
		$tempArr['singleViews'] = $singleViews;
		array_push($singleArr,$tempArr);
		
	
		
		
	}
}

for($i=0; $i<count($singleArr); $i++){
	
		

        $singleChannel = $singleArr[$i]['singleChannel'];
		
        $singleChannelImg = $singleArr[$i]['singleChannelImg'];
		

        $singleId = $singleArr[$i]['singleId'];
		
        $singlePubtime = $singleArr[$i]['singlePubtime'];
		
        $singleRichThumb = $singleArr[$i]['singleRichThumb'];
		
        $singleThumbnail = $singleArr[$i]['singleThumbnail'];
		
        $singleTime = $singleArr[$i]['singleTime'];
		
        $singleTitle = $singleArr[$i]['singleTitle'];
		
        $singleViews = $singleArr[$i]['singleViews'];
		

        if($i < 1009){

            $c = $i+1;
            
			$sql = "UPDATE homepagedatasingle SET channel='$singleChannel', channelImage = '$singleChannelImg', id = '$singleId', pubtime = '$singlePubtime', richthumb =                                 '$singleRichThumb', thumbnail = '$singleThumbnail', duration = '$singleTime', title = '$singleTitle', videoViews = '$singleViews' WHERE video_id = '$c'";
			$result = $conn->query($sql);
           
		}
}


for($i=0; $i<count($jsonData2['playlist']); $i++){
	if(!in_array($jsonData2['playlist'][$i]['id'], $arr)){
		array_push($arr,$jsonData2['playlist'][$i]['id']);
		
		$playlistChannel = $jsonData2['playlist'][$i]['channel'];
		
		
		if($jsonData2['playlist'][$i]['channel_image'] != 'Null'){
			$playlistChannelImg = $jsonData2['playlist'][$i]['channel_image'][0]['url'];
			
		}
		else{
			$playlistChannelImg = $jsonData2['playlist'][$i]['channel_image'];
		}
		
		
		$playlistId = $jsonData2['playlist'][$i]['id'];
		
		
		$playlistPubtime = $jsonData2['playlist'][$i]['pubtime'];
		
		
		
		if($jsonData2['playlist'][$i]['thumbnails'] != 'Null'){
			$playlistThumbnail = $jsonData2['playlist'][$i]['thumbnails'][0]['url'];
			
		}
		else{
			$playlistThumbnail = $jsonData2['playlist'][$i]['thumbnails'];
			
		}
		
		
		
		$playlistTitle = $jsonData2['playlist'][$i]['title'];
		
		
		$countArr = explode(" ",$jsonData2['playlist'][$i]['videoCount']);
		$playlistVideoCount = $countArr[0];
		
		
		$tempArr2['playlistChannel'] = $playlistChannel;
		$tempArr2['playlistChannelImg'] = $playlistChannelImg;
		$tempArr2['playlistId'] = $playlistId;
		$tempArr2['playlistPubtime'] = $playlistPubtime;
		$tempArr2['playlistThumbnail'] = $playlistThumbnail;
		$tempArr2['playlistTitle'] = $playlistTitle;
		$tempArr2['playlistVideoCount'] = $playlistVideoCount;
		array_push($playlistArr,$tempArr2);
		
	}
}

for($i=0; $i<count($playlistArr); $i++){
	
		

        $playlistChannel = $playlistArr[$i]['playlistChannel'];
		
        $playlistChannelImg = $playlistArr[$i]['playlistChannelImg'];
		
        $playlistId = $playlistArr[$i]['playlistId'];
		

        $playlistPubtime = $playlistArr[$i]['playlistPubtime'];
	
        $playlistThumbnail = $playlistArr[$i]['playlistThumbnail'];
		
        $playlistTitle = $playlistArr[$i]['playlistTitle'];
		
        $playlistVideoCount = $playlistArr[$i]['playlistVideoCount'];
		

         if($i < 11){
              $c = $i+1;

			$sql = "UPDATE homepagedataplaylist SET channel='$playlistChannel', channelImg = '$playlistChannelImg', id = '$playlistId', pubtime = '$playlistPubtime', thumbnail = '$playlistThumbnail', title = '$playlistTitle', videoCount = '$playlistVideoCount' WHERE playlist_id = '$c'";
			$result = $conn->query($sql);
		}
	
}