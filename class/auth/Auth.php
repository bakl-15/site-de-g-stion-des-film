<?php
namespace App\auth;

use App\security\ForbiddenException;
use \Exception;
class Auth{
    public static function check_admin()
    {
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        if(!isset($_SESSION['auth_admin']))
        {
            throw new ForbiddenException();
        }
    }
    public static function check_user()
    {
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        if(!isset($_SESSION['auth_user']))
        {
            throw new ForbiddenException();
        }
    }
}
