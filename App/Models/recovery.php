<?php

namespace App\Models;

class Recovery
{
	public static function sendEmail($email)
	{
		$email = trim(strip_tags($email));

		if(!Auth::checkEmail($email)) {
			$errors[] = "Нет такой почты";
		} else {
			if(!$recovery_hash = self::getRecoveryHash($email)) {
				$errors[] = "Ошибка получения токена восстановления пароля.";
			}
		}

		if(empty($errors)) {
			$to  = "<".$email.">"; 

			$subject = "Восстановление пароля на сайте "; 

			$message = "Ваша ссылка для восстановления пароля.\n<a href='".\App\DATA::DOMEN_NAME."/forgot-pass/?recovery=mode&rec_hash=".$recovery_hash."'>".\App\DATA::DOMEN_NAME."/forgot-pass/?recovery=mode&rec_hash=".$recovery_hash."</a>";

			$headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 
			$headers .= "From: yummy.loc\r\n";  

			return mail($to, $subject, $message, $headers); // true or false

		} else {
			return json_encode($errors);
		}
	}

	public static function getRecoveryHash($email)
	{
		$db = \DB\DB::Connect();

		$rec_db = $db->prepare("SELECT `recovery_hash` FROM `users` WHERE email = :email");
		$rec_db->execute([":email"=>$email]);

		$recovery = $rec_db->fetchObject();
		if($recovery == false) {
			return false;
		} else {
			return $recovery->recovery_hash;
		}
	}


}