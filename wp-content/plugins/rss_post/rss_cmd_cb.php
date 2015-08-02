<?php
header("Content-type: text/html; charset=utf-8"); 

$xmlData=<<<EOF
<root version="2.0">
<item>
	<rssTaskName>
		defaultSetting
	</rssTaskName>
	<rssUrl>
	http://www.youku.com/user/rss/id/UMzk2ODA1OTY4
	</rssUrl>
	<frequency unit="min">
	10
	</frequency>
	<title>
	<![CDATA[
	{title}
	]]>
	</title>
	<content>
	<![CDATA[
	[ckplayer]{link}[/ckplayer]
	]]>
	</content>
	<sort>
	未分类
	</sort>
	<extraSortFromTitle>
	true
	</extraSortFromTitle>
	<tags>
	</tags>
	<ignoreRepeat>
	true
	</ignoreRepeat>
	<thumbNailUrl>
	Default
	</thumbNailUrl>
</item>
</root>
EOF;

if(file_exists("rss_post_config.xml")==false)//if not exists default config file ,creade it
{
	$xml=simplexml_load_string($xmlData);
	$xml->asXML("rss_post_config.xml");
}
else
{
	$xml=simplexml_load_file("rss_post_config.xml");
}
$callback='callback';//jsonp callback function
if(isset($_REQUEST['callback']))
	$callback=$_REQUEST['callback'];
if(isset($_REQUEST['action']))
{	
switch($_REQUEST['action'])//action indicate what to do, should be the follow values:query,add,delete,deleteall.return jasonp.
{
	case 'query':
		if(isset($_REQUEST['key']))//compare with xml path 'root/item/rssTaskName'
		{
			$nodes=$xml->xpath('item');
			foreach($nodes as $node)
			{
				$strRet=$callback.'({"errno":"0","msg":"success","data",{';
				$strTemp='';
				$bThisNode=false;
				foreach($node->children() as $key=>$value)
				{
					if($key=='rssTaskName' and $value==str_replace($_REQUEST['key'],' '))
					{
						$strTemp.='"'.$key.'":"'.rtrim($_REQUEST['key'],'').'",';
						$bThisNode=true;
						echo 'find key';
					}
					else
						$strTemp.='"'.$key.'":"'.$value.'",';					
				}
				echo $strTemp;
				if($bThisNode)
				{
					$strRet.=$strTemp;
					$strRet[strlen($strRet)-1]='}';
					$strRet.='});';
					die($strRet);
				}				
			}
			//run there indicate that not find the node match $_REQUEST['key']
			die($callback.'({"errno":"-3","msg":"query failed(not find a item match this key)"})');
		}
		else
			die($callback.'({"errno":"-2","msg":"bad query"})');
		break;
	case 'add':
		break;
	case 'delete':
		break;
	case 'deleteall':
		break;
	default:
		die($callback.'({"errno":"-1","msg":"bad action"})');
		break;
}
}
?>









