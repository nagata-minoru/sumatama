<?php namespace lib;

use Facebook\FacebookSession;

class FacebookUtil {
    static function fbInit() {
        FacebookSession::setDefaultApplication(
            getenv('SUMATAMA_FACEBOOK_APPID'),
            getenv('SUMATAMA_FACEBOOK_APPSECRET')
        );
    }
}
