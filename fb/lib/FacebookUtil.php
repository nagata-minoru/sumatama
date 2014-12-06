<?php namespace lib;

use Facebook\FacebookSession;

class FacebookUtil {
    static function fbInit() {
        FacebookSession::setDefaultApplication(
            getenv('SUMATAMA_APPID'), getenv('SUMATAMA_APPSECRET')
        );
    }
}
