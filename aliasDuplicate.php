<?php
error_reporting(0);
$connect = mysqli_connect('localhost','db_uname','db_pass','db_name');


$d = mysqli_query($connect, "SELECT group_concat(`id`) ids, count(id) c FROM `revo_site_content` GROUP by concat(uri) HAVING c > 1");
while($res = mysqli_fetch_array($d))
{
$ids = explode(",",$res['ids']);
$i = 0;
foreach($ids as $id)
{
	$i++;
	if($i == 1)
		continue;
	echo $id . "\r\n<br/>";
	$m = mysqli_fetch_array(mysqli_query($connect, "SELECT uri FROM `revo_site_content` WHERE id = $id"));
	$uri = $m['uri'];
	$uri2 = explode("/",$uri);
	$uri2 = end($uri2);
	$uri = str_replace($uri2,$id."-".$uri2, $uri);
		
	mysqli_query($connect, "UPDATE `revo_site_content` SET `uri` = '".$uri."', `alias` = CONCAT('".$id."-',`alias`) WHERE `id` = '$id'");
}
}
