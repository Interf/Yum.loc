<?php

namespace App\Models;

class isAuth
{
	public static function isAuth()
	{
		if(!empty($_SESSION['token']) && !empty($_SESSION['user'])) {
			return 1; // logged in
		} else {
			return 0; // log out
		}
	}

	public static function isAuthByTokenId($token, $user)
	{
		$token = trim(strip_tags($token));
		$login = trim(strip_tags($user));

		$db = \DB\DB::Connect();

		$auth_db = $db->prepare("SELECT `id` FROM users WHERE `token` = :token AND `login` = :login");
		$auth_db->execute([":token"=>$token, ":login"=>$login]);

		$count_id = $auth_db->fetchObject();

		if($count_id->id == 0 ) {
			$result = 0;
		} else {
			$result = $count_id->id;
		}

		return $result;
	}


	public static function delSession()
	{
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}

		session_destroy();

		setcookie('token', "", time() - 3600);
	}



}