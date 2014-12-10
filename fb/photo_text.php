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
unlink($temp);
getImage($_GET['url'], $temp);
$image = new Imagick($temp);

$page = $image->getImagePage();
$fontSize = max($page['width'], $page['height']) / 10;
$draw = new ImagickDraw();
$draw->setFontSize($fontSize);

$text = $_GET['txt'];
$metrics = $image->queryFontMetrics($draw, $text);

$draw->setFillColor('#fff');
$draw->setFillOpacity(0.5);
$draw->rectangle(20, 50 - $fontSize, 20 + $metrics['textWidth'], 50);

$draw->setFillColor('#00f');
$draw->setFillOpacity(1);
$draw->annotation(20, 50, $text);

$image->drawImage($draw);

echo $image;
$image->clear();
