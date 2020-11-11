<?php

namespace App\Models;

class Comment
{
	public static function insertComment($user_id, $comment, $proj_id)
	{
		$comment = self::checkDataComment($comment);
		$proj_id = (int) $proj_id;

		if(($user_id != 0) && (!is_array($comment))) {

			$db = \DB\DB::Connect();

			$insert_comment = $db->prepare("INSERT INTO `comments`(`id_user`, `comment`, `id_proj`) VALUES (?,?,?)");
			$insert_comment->execute([$user_id, $comment, $proj_id]);

			if($insert_comment->rowCount() == 0) {
				$error[] = "Ошибка добавления комменатрия.";
				return $error; // error
			} else {
				return 1;
			}
		} else {
			return $comment; // error message
		}
	}

	public static function checkDataComment($comment)
	{
		$errors = array();

		$comment = trim(strip_tags($comment));

		if(mb_strlen($comment) < 2) {
			$errors[] = "Минимальная длина комментария 2 символа";
		}

		if(mb_strlen($comment) > 255) {
			$errors[] = "Максимальная длинна комментария 255 символов.";
		}

		if(empty($errors)) {
			return $comment;
		} else {
			return $errors;
		}
	}

	public static function getUserComment($id)
	{
		$id = (int) $id;
	
		$db = \DB\DB::Connect();

		$user_db = $db->prepare("SELECT img, login FROM users WHERE id = :id");
		$user_db->execute([":id"=>$id]);

		$user = $user_db->fetchObject();

		return $user;
	}


	public static function hideComm($comm_id)
	{
		$comm_id = (int) $comm_id;
	
		$db = \DB\DB::Connect();

		$comm_db = $db->prepare("UPDATE `comments` SET `is_active` = 0 WHERE `id` = :id");
		$result = $comm_db->execute([":id"=>$comm_id]);

		return $result;
	}




}

