<?php
function GetThumbUrl($link)//link means a video link ,from youku、qq,etc.
{
	$thumbNailUrl="";
	if(strpos($link,"youku.com")>=0)
		return GetThumbUrlFormYouku($link);
	return $thumbNailUrl;
}
function GetThumbUrlFormYouku($link)
{
	//youku video link like as http://www.youku.com/v_show/id_XMTI3ODg1NDE4NA==_rss.html
	$thumbNailUrl="";
	//get vid
	if(preg_match('/id_(\w+)/',$link,$matches)==1)
	{
		$vid=$matches[1];
		$html = file_get_contents("http://play.youku.com/play/get.json?vid=".$vid."==&ct=10&ran=4034", "r") or die("Unable to open file:"."http://play.youku.com/play/get.json?vid=".$vid."==&ct=10&ran=4034");		
		if(preg_match('/"logo":"(http:\/\/[^"]+)"/',$html,$matches)==1)//get the thumbNail Url
		{
			$thumbNailUrl=$matches[1];
		}
	}	
	return $thumbNailUrl;
}
?>