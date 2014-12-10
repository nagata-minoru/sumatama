<?php
require_once('vendor/autoload.php');
require_once('lib/FacebookUtil.php');
require_once('lib/User.php');
require_once('lib/Feed.php');

lib\FacebookUtil::fbInit();

try {
    $user = new lib\User($_POST['user_id'], $_POST['access_token']);
    $feed = new lib\Feed($user);
    $feed->post($_POST['message']);
    echo 'success';
} catch (Exception $e) {
    echo $e->getMessage();
}
