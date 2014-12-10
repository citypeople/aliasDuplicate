<?php
error_reporting(0);
mysql_connect('localhost','','');
mysql_select_db('');

$d = mysql_query("SELECT group_concat(`id`) ids, count(id) c FROM `revo_site_content` GROUP by concat(uri) HAVING c > 1");
while($res = mysql_fetch_array($d))
{
$ids = explode(",",$res['ids']);
$i = 0;
foreach($ids as $id)
{
	$i++;
	if($i == 1)
		continue;
	echo $id . "\r\n<br/>";
	$m = mysql_fetch_array(mysql_query("SELECT uri FROM `revo_site_content` WHERE id = $id"));
	$uri = $m['uri'];
	$uri2 = explode("/",$uri);
	$uri2 = end($uri2);
	$uri = str_replace($uri2,$id."-".$uri2, $uri);
		
	mysql_query("UPDATE `revo_site_content` SET `uri` = '".$uri."', `alias` = CONCAT('".$id."-',`alias`) WHERE `id` = '$id'");
}
}
