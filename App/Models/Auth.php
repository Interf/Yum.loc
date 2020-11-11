<?php

namespace App\Models;

class Auth
{
	public static function checkEmail($email)
	{
		$db = \DB\DB::Connect();

		$email_db = $db->prepare("SELECT COUNT(`id`) as id FROM `users` WHERE email = :email");
		$email_db->execute([":email"=>$email]);

		$email_chek = $email_db->fetchObject();
		if($email_chek->id == 0) {
			return 0; // no email
		} else {
			return 1;
		}
	}

	public static function checkLogin($login)
	{
		$db = \DB\DB::Connect();

		$log_db = $db->prepare("SELECT COUNT(`id`) as id FROM `users` WHERE login = :login");
		$log_db->execute([":login"=>$login]);

		$log_check = $log_db->fetchObject();
		if($log_check->id == 0) {
			return 0; // no login
		} else {
			return 1;
		}
	}

	public static function passHash($pass)
	{
		$pass_hash = password_hash($pass, PASSWORD_DEFAULT);
		if($pass_hash == false) {
			return false;
		} else {
			return $pass_hash;
		}
	}

	public static function recoveryHash($login)
	{
		$recovery_hash = password_hash($login, PASSWORD_DEFAULT);
		if($recovery_hash == false) {
			return false;
		} else {
			return $recovery_hash;
		}
	}

	public static function registerUser($login, $email, $pass_hash, $recovery_hash)
	{
		$db = \DB\DB::Connect();

		$token = bin2hex(random_bytes(32));

		$reg_db = $db->prepare("INSERT INTO `users`(`email`, `login`, `pass_hash`, `token`, `recovery_hash`) VALUES (?,?,?,?,?)");
		$reg_db->execute([$email,$login,$pass_hash, $token, $recovery_hash]);

		$reg_check = $reg_db->rowCount();
		if($reg_check == 0) {
			$error[] = "Ошибка регистрации. Попробуйте позже";
			return $error; // error
		} else {
			return 1;
		}
	}


	public static function checkFormData(array $data)
	{
		$errors = array();

		$login = trim(strip_tags($data["login"]));
		$email = trim(strip_tags($data["email"]));
		$pass1 = trim(strip_tags($data["pass1"]));
		$pass2 = trim(strip_tags($data["pass2"]));

		if(mb_strlen($login) < 3 || mb_strlen($login) > 15)
		{
			$errors["input"][] = "Минимальная длина логина 3 символа, максимальная 15";
		} else {
			if(!preg_match("~([a-z0-9A-Z]+)~", $login)) {
				$errors["input"][] = "Доступный только английские буквы в логине";
			}
		}

		if(!preg_match("~^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$~", $email))
		{
			$errors["input"][] = "Некорректный E-mail";
		}

		if(mb_strlen($pass1) < 3) {
			$errors["input"][] = "Минимальная длина пароля 3 символа.";
		} else {
			if(!preg_match("~([a-z0-9A-Z]+)~", $pass1)) {
				$errors["input"][] = "Доступный только английские буквы в пароле";
			}
		}

		if($pass1 != $pass2) {
			$errors["input"][] = "Повторный пароль введен неверно";
		}

		if(empty($errors["input"])) {
			
			$db = \DB\DB::Connect();

			if(self::checkEmail($email) == 1) {
				$errors["DB"][] = "Такой E-mail уже зарегистрирован.";
			}

			if(self::checkLogin($login) == 1) {
				$errors["DB"][] = "Такой логин уже зарегистрирован.";
			}

			if(!$pass_hash = self::passHash($pass1)) {
				$errors["DB"][] = "Ошибка пароля. Попробуйте позже.";
			}

			if(!$recovery_hash = self::recoveryHash($login)) {
				$errors["DB"][] = "Ошибка хэша логина";
			}

			if(empty($errors["DB"])) {
				
				$result_reg = self::registerUser($login, $email, $pass_hash, $recovery_hash);
				return $result_reg;

			} else {
				return $errors["DB"];
			}
		} else {
			return $errors["input"];
		}


	}

	public static function isBlockUser($login = null)
	{
		if($login == null) {return false;}
		
		$db = \DB\DB::Connect();

		$login = trim(strip_tags($login));

		$user_db = $db->prepare("SELECT `login` FROM `users` WHERE `login` = :login AND `is_block` = 0");
		$user_db->execute([':login'=>$login]);

		if($user_db->rowCount() != 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function getUsername($token)
	{
		$db = \DB\DB::Connect();

		$token = trim(strip_tags($token));

		$user_db = $db->prepare("SELECT login FROM `users` WHERE token = :token");
		$user_db->execute([":token"=>$token]);

		$username = $user_db->fetchObject();
		if($username == false) {
			return false;
		} else {
			return $username->login;
		}
	}


	public static function checkPass($login, $pass)
	{
		$db = \DB\DB::Connect();

		$pass_db = $db->prepare("SELECT pass_hash FROM `users` WHERE login = :log");
		$pass_db->execute([":log"=>$login]);

		$hash = $pass_db->fetchObject();

		if(password_verify($pass, $hash->pass_hash)) {
			return 1;
		} else {
			return 0; // error
		}
	}

	public static function getToken($login)
	{
		$db = \DB\DB::Connect();

		$token_db = $db->prepare("SELECT token FROM `users` WHERE login = :log");
		$token_db->execute([":log"=>$login]);

		$token = $token_db->fetchObject();

		return $token->token;
	}

	public static function getImage($login)
	{
		$db = \DB\DB::Connect();

		$img_db =  $db->prepare("SELECT img FROM `users` WHERE login = :login");
		$img_db->execute([":login"=>$login]);

		$user_image = $img_db->fetchObject();

		return $user_image->img;
	}

	public static function getUserRole($login, $token)
	{
		$db = \DB\DB::Connect();

		$role_db =  $db->prepare("SELECT role FROM `users` WHERE login = :login AND token = :token");
		$role_db->execute([":login"=>$login, ":token"=>$token]);

		$user_role = $role_db->fetchObject();

		return $user_role->role;
	}

	public static function writeSession($login, $token, $image, $role)
	{
		$_SESSION['user'] = [
			'user_login' => $login,
			'user_token' => $token,
			'user_image' => $image,
			'user_role' => $role
		];
	}

	public static function updateToken($login)
	{
		$db = \DB\DB::Connect();

		$token = bin2hex(random_bytes(32)); // new token

		$token_db =  $db->prepare("UPDATE `users` SET `token` = :token WHERE `login` = :login");
		$result = $token_db->execute([":login"=>$login, ":token"=>$token]);

		return $result;
	}

	public static function authUser(array $log)
	{
		$login = trim(strip_tags($log["login"]));
		$pass = trim(strip_tags($log["pass"]));
		$remember = trim(strip_tags($log['remember']));

		if(mb_strlen($login) < 3 || mb_strlen($login) > 15 || !preg_match("~([a-zA-Z0-9]+)~", $login)) {
			$errors["input"][] = "Ошибочный логин"; 
		}

		if(mb_strlen($pass) < 3 || mb_strlen($pass) > 25 || !preg_match("~([a-zA-Z0-9]+)~", $pass)) {
			$errors["input"][] = "Введите пароль";
		}

		if(empty($errors)) {
			if(self::checkLogin($login) == 0) {
				$errors["login"][] = "Нет такого пользователя";
			} else {
				if(self::isBlockUser($login) == false) {
					$errors["login"][] = "Данный пользователь заблокирован.";
				}
			}

			if(empty($errors["login"])) {
				if($result = self::checkPass($login, $pass)) {
					self::updateToken($login);

					if($remember == "true") {
						#30 Деней
						setcookie('token', self::getToken($login), time()+86400 * 30);
					}

					self::writeSession($login, self::getToken($login), self::getImage($login), self::getUserRole($login, self::getToken($login)));
					return 1;
				} else {
					$errors["password"][] = "Ошибочный пароль";
					return $errors["password"];
				}
			} else {
				return $errors["login"];
			}
		} else {
			return $errors["input"];
		}

	}




}