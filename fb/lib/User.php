<?php namespace lib;

class User {
    private $id;
    private $accessToken;

    public function __construct($id, $accessToken) {
        $this->id = $id;
        $this->accessToken = $accessToken;
    }

    public function getSession() {
        return new \Facebook\FacebookSession($this->accessToken);
    }
}
