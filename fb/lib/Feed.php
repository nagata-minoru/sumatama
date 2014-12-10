<?php namespace lib;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;

class Feed
{
    private $user;

    function __construct($user) {
        $this->user = $user;
    }

    public function post($message) {
        $request = new \Facebook\FacebookRequest(
            $this->user->getSession(), 'POST', '/me/feed',
            array('message' => $message, 'place' => 195680633840439)
        );

        $request->execute();
    }
}

