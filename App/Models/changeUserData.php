<?php

namespace App\Models;

class ChangeUserData
{
	public static function changePass(array $pass, $rec_hash)
	{
		$pass1 = trim(strip_tags($pass['pass1']));
		$pass2 = trim(strip_tags($pass['pass2']));
		$hash = trim(strip_tags($rec_hash));


		if(mb_strlen($pass1) < 3 || mb_strlen($pass2) > 15) {
			$errors["input"][] = "Минмальная длина пароля 3 символа, маскимальная 15";
		}

		if($pass1 != $pass2) {
			$errors["input"][] = "Пароли не совпадают";
		}

		if(empty($errors)) {
			if($pass = Auth::passHash($pass1)) {

				if($recovery_hash = self::checkUserByRecoverHash($hash)) {

					if($rewrite_result = self::rewriteRecoveryAndPassHash($hash, $recovery_hash, $pass)) {
						return 1;
					} else {
						$errors["recovery_result"][] = "Перезапись пароля не удалась.";
						return json_encode($errors["recovery_result"]);
					}

				} else {
					$errors["check_hash_user"][] = "Нет пользователя с таким хэшем";
					return json_encode($errors["check_hash_user"]);
				}

			} else {
				$errors["hash_pass"][] = "Ошибка хэширования пароля.";
				return json_encode($errors["hash_pass"]);
			}
		} else {
			return json_encode($errors["input"]);
		}


	}


	public static function checkUserByRecoverHash($recovery_hash)
	{
		$db = \DB\DB::Connect();

		$user_db = $db->prepare("SELECT COUNT(`id`) as id, `login` FROM `users` WHERE recovery_hash = ?");
		$user_db->execute([$recovery_hash]);

		$user_check = $user_db->fetchObject();
		if($user_check->id == 0) {
			return 0; // Нет пользователя с таким хэшем
		} else {
			return Auth::recoveryHash($user_check->login); // new recovery_hash
		}
	}

	public static function rewriteRecoveryAndPassHash($oldHash, $newHash, $newPass)
	{
		$db = \DB\DB::Connect();

		$recov_db = $db->prepare("UPDATE `users` SET recovery_hash = :newHash, pass_hash = :newPass WHERE recovery_hash = :oldHash ");
		$recov_db->execute([":oldHash"=>$oldHash, ":newHash"=>$newHash, ":newPass"=>$newPass]);

		$result = $recov_db->rowCount();

		if($result == 0) {
			return 0; // not work
		} else {
			return 1;
		}
	}

	public static function changePassByUser($login, $token, array $pass)
	{
		$login = trim(strip_tags($login));
		$token = trim(strip_tags($token));
		$oldPass = trim(strip_tags($pass['oldPass']));
		$newPass1 = trim(strip_tags($pass['newPass1']));
		$newPass2 = trim(strip_tags($pass['newPass2']));

		if($oldPass == "") {
			$errors["check-input"][] = "Введите текущий пароль";
		}
		if(mb_strlen($newPass1) < 3 || mb_strlen($newPass1) > 15 ) {
			$errors["check-input"][] = "Минимальная длина пароля 3 символа, максимальняа 15.";
		}
		if($newPass1 != $newPass2) {
			$errors["check-input"][] = "Новые пароли не совпадают.";
		}

		if(empty($errors)) {

			if($check_old_pass = Auth::checkPass($login, $oldPass)) {

				if($pass_hash = Auth::passHash($newPass1)) {
					if($result = self::updateUserPass($login, $token, $pass_hash)) {
						return 1;
					} else {
						$errors["update_pass"][] = "Ошибка обновления пароля.";
						return $errors["update_pass"];
					}
				} else {
					$errors["pass_hash"][] = "Ошибка хэширования пароля.";
					return $errors["check_old_pass"];
				}
			} else {
				$errors["check_old_pass"][] = "Неверный старый пароль";
				return $errors["check_old_pass"];
			}

		} else {
			return $errors["check-input"];
		}
	}

	public static function updateUserPass($login, $token, $pass_hash)
	{
		$db = \DB\DB::Connect();

		$pass_db = $db->prepare("UPDATE `users` SET `pass_hash` = :hash WHERE login= :login AND token = :token ");
		$pass_db->execute([":hash"=>$pass_hash, ":login"=>$login, ":token"=>$token]);

		$result = $pass_db->rowCount();

		if($result == 0) {
			return 0; // Error
		} else {
			return 1;
		}

	}

	public static function changeImageUser($login, $token, $nameImage)
	{
		if(!self::delCurrentImageUser($login, $token)) {
			return false;
		}

		$db = \DB\DB::Connect();

		$img_db = $db->prepare("UPDATE `users` SET img = :img WHERE login = :login AND token = :token");
		$result = $img_db->execute([":img"=>$nameImage, ":login"=>$login, ":token"=>$token]);

		if($result) {
			return 1;
		} else {
			return 0; // error
		}
	}

	public static function delCurrentImageUser($login, $token)
	{
		$db = \DB\DB::Connect();

		$img_db =  $db->prepare("SELECT img FROM `users` WHERE login = :login AND token = :token");
		$img_db->execute([":login"=>$login, ":token"=>$token]);

		if($img = $img_db->fetchObject()) {
			if($img->img == "default.jpeg") {
				return 1;
			} else {
				return unlink(ROOT."/media/images/userUpload/".$img->img);
			}	
		} else {
			return 0;
		}
	}



}