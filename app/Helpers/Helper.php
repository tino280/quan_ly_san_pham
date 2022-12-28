<?php

namespace App\Helpers;

class Helper
{
    public static function generateUncryptedPassword() : String
    {
        $chars = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";

        $password = '';

        for ($i=0; $i<20; $i++) {
            $password .= substr($chars, random_int(0, strlen($chars)-1), 1);
        }

        return $password;
    }

    public static function generateCryptedPassword() : String
    {
        return bcrypt(self::generateUncryptedPassword());
    }
}
