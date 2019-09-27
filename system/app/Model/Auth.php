<?php
namespace Core\Model;

use \Illuminate\Database\Eloquent\Model;
use Core\Model\Cookie;
use Core\Model\Token;

class Auth extends Model
{

	public static function id(){

		return self::user()->id;
	}

	public static function getUserAttribute(){
		return self::user();
	}

	public static function user(){
		$token = Token::where('hash',Cookie::getToken())->latest()->first();
		if ($token) {
			return $token->user;
		}
		Cookie::unsetToken();
	}

}
