<?php
namespace Core\Model;

/**
* 
**/
class Cookie
{
	public static function setToken(Token $token){
		return setcookie(Config::get('cookie.name'), $token->hash, time() + Config::get('cookie.duration'), "/");
	}

	public static function unsetToken(){
		if (self::issetToken()) {
			return setcookie(Config::get('cookie.name'), "", time() - Config::get('cookie.duration'), "/");	
		}
	}

	public static function issetToken(){
		return isset($_COOKIE[Config::get('cookie.name')]);
	}

	public static function getToken(){
		if (self::issetToken()) {
            return $_COOKIE[Config::get('cookie.name')];
        }
    }

	// public static function set(){
	// 	return setcookie(Config::get('cookie.name'), $token->hash, time() + Config::get('cookie.duration'), "/");
	// }

	// public static function unset(){
	// 	if (self::isset()) {
			
	// 	}
	// }

	public static function isset($cookieName){
		if (isset($_COOKIE[$cookieName])) {
            return true;
        }
	}

	public static function get($cookieName){
		if (isset($_COOKIE[$cookieName])) {
            return $_COOKIE[$cookieName];
        }
    }
}