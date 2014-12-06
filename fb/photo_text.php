<?php
function getImage($url, $temp) {
    $ch = curl_init($url);

    $fp = fopen($temp, "w");

    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}

header('Content-type: image/jpeg');
$temp = '/tmp/temp.jpg';
getImage($_GET['url'], $temp);
$image = new Imagick($temp);

$draw = new ImagickDraw();
$draw->annotation(20, 50, $_GET['txt']);
$image->drawImage($draw);

echo $image;
