<?php

namespace App\Models;

class getUser
{
	public static function getUserInfoByLoginToken($login,$token)
	{
		$login = trim(strip_tags($login));
		$token = trim(strip_tags($token));

		$db = \DB\DB::Connect();

		$user_db = $db->prepare("SELECT users.login, users.email, users.img, role.role_ru, role.id FROM `users` JOIN `role`
			ON users.role = role.id
			WHERE users.login = :login AND users.token = :token
            GROUP BY (users.login)");
		$user_db->execute([":login"=>$login, ":token"=>$token]);

		$user = $user_db->fetchObject();
		
		if($user == false) {
			return 0;
		} else {
			return $user;
		}
	}








}