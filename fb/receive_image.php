<?php
$img64=$_POST['img64'];
$userid=$_POST['userid'];

$returnobj=array();

$firstbytes=substr($img64,0,30);
$coronpos=strpos($firstbytes,":");
$semicoronpos=strpos($firstbytes,";");
$commapos=strpos($firstbytes,",");
$contenttype=substr($firstbytes,$coronpos+1,$semicoronpos-$coronpos);
$ext=".jpg";
if($contenttype=="image/png"){
	$ext=".png";
}

$returnobj["contenttype"]=$contenttype;
$returnobj["ext"]=$ext;

$filepath='/fb/user_photo/';
$filename=$userid."-".time().$ext;
$fullfilename = $_SERVER['DOCUMENT_ROOT'] . $filepath . $filename;
$returnobj["filname"]=$filename;
$returnobj["fullfilname"]=$fullfilename;

if($_SERVER['HTTPS']=="on"){$scheme = "https://";}else{$scheme = "http://";}
$URL = $scheme . $_SERVER["HTTP_HOST"] . $filepath . $filename;
$returnobj["url"]=$URL;

$img64=substr($img64,$commapos+1);
$imgbin=base64_decode($img64);
if(!file_put_contents($fullfilename,$imgbin)){
	$returnobj["message"]="save failed";
	$returnobj["status"]=2;
}else{
	$returnobj["message"]="success";
	$returnobj["status"]=1;
}
echo json_encode($returnobj);
