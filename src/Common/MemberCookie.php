<?php

namespace Membergate\Common;

class MemberCookie {
    public const cookie_name = 'membergate_member';

    public function user_has_cookie() {
        return isset($_COOKIE[self::cookie_name]);
    }

    public function set_member_cookie() {
        setcookie(
            self::cookie_name,
            'true',
            time() + YEAR_IN_SECONDS,
            '/',
            '',
            false,
            true,
        );
    }
}
