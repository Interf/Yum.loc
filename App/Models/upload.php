<?php

namespace App\Models;

class Upload
{
	public static function uploadImage()
	{
		$file = $_FILES[0];
		$uploadDir = ROOT."/media/images/userUpload/";
		$nameImg = date("YmdHis").rand(100,1000).".jpg";

		$uploadPath = "$uploadDir$nameImg"; // Путь загрузки картинки

		// Проверка типа и размера картинки
		if(!($file['type'] == 'image/gif' || $file['type'] == 'image/jpeg' || $file['type'] == 'image/png')) {
			$errors["type-size"][] = "Ошибка типа файла";
		}

		if($file['size'] == 0 || $file['size']>=512000) {
			$errors["type-size"][] = "Превышение максимального размера файла";
		}

		if(empty($errors)) {
			if(!move_uploaded_file($file['tmp_name'], $uploadPath)) {
				$errors[] = "Не удалось загрузить картинку";
				return $errors;
			} else {
				$size = getimagesize($uploadPath); // size[0] = ширина. $size[1] = высота.
				if($size[0] < 1501 && $size[1] < 1501) {

					if(changeUserData::changeImageUser($_SESSION['user']['user_login'],$_SESSION['user']['user_token'],$nameImg)) {
						return 1;
					} else {
						$errors[] = "Ошибка загрузки изображения в БД";
						return $errors;
					}

				} else {
					$errors[] = "Превышен допустимый размер картинки.";
					return $errors;
					unlink($uploadPath); // удаление картинки
				}
			}
		} else {
			return $errors;
		}



	}
}