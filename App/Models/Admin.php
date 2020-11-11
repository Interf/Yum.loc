<?php

namespace App\Models;

class Admin
{
	public static function getDataByGet($get)
	{
		$get = trim(strip_tags($get));

		if($get == "news") {
			return self::getNewsByGet();
		}
		elseif($get == "catalog") {
			return self::getCatalogByGet();
		}
		elseif($get == "video-links") {
			return self::getFullCatalogByGet();
		}
		elseif(($get == "users") && (Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 2 )) {
			return self::getUsersByGet();
		}
		elseif($get == "comments") {
			return self::getHideComments();
		}
		else {
			return self::getLogs();
		}
	}

	const LIMIT = 5;

	public static function getLogs(int $page = 1)
	{
		if(isset($_GET['page'])) {$page = (int) $_GET['page'];}

		$lim = self::LIMIT;

		if($page <= 0) {$page = 1;}

		$start = ($page * self::LIMIT) - self::LIMIT;

		$db = \DB\DB::Connect();

		$log_db = $db->prepare("
			SELECT id, log_info, log_user
			FROM logs
			ORDER BY id DESC LIMIT :start, :lim");
		$log_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$log_db->bindParam(":lim", $lim, \PDO::PARAM_INT);
		$result = $log_db->execute();


		if($result) {
			while($logs = $log_db->fetchObject()) {
				$arr_logs[] = $logs;
			}

			return $arr_logs;
		} else {
			return false;
		}
	}

	public static function getHideComments(int $page = 1)
	{
		if(isset($_GET['page'])) {$page = (int) $_GET['page'];}

		$lim = self::LIMIT;

		if($page <= 0) {$page = 1;}

		$start = ($page * self::LIMIT) - self::LIMIT;

		$db = \DB\DB::Connect();

		$comm_db = $db->prepare("
			SELECT comments.id, comments.comment, comments.id_proj, users.login 
			FROM `comments` JOIN users 
			ON comments.id_user = users.id AND comments.is_active = 0
			ORDER BY id DESC LIMIT :start, :lim");
		$comm_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$comm_db->bindParam(":lim", $lim, \PDO::PARAM_INT);
		$result = $comm_db->execute();


		if($result) {
			while($comm = $comm_db->fetchObject()) {
				$arr_comm[] = $comm;
			}

			return $arr_comm;
		} else {
			return false;
		}
	}

	public static function getNewsByGet(int $page = 1)
	{
		if(isset($_GET['page'])) {$page = (int) $_GET['page'];}

		$lim = self::LIMIT;
		
		if($page <= 0) {$page = 1;}

		$start = ($page * self::LIMIT) - self::LIMIT;

		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT news.id, news.title
			FROM news
			ORDER BY news.id DESC LIMIT :start, :lim");
		$proj_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$proj_db->bindParam(":lim", $lim, \PDO::PARAM_INT);
		$proj_db->execute();

		$rowCount = $proj_db->rowCount();

		if($rowCount != 0) {
			while($proj = $proj_db->fetchObject()) {
				$arr_proj[] = $proj;
			}

			return $arr_proj;
		} else {
			return false;
		}
	}

	public static function getCatalogByGet(int $page = 1)
	{
		if(isset($_GET['page'])) {$page = (int) $_GET['page'];}

		$lim = self::LIMIT;

		if($page <= 0) {$page = 1;}

		$start = ($page * self::LIMIT) - self::LIMIT;

		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT projects.id, projects.title
			FROM projects
			ORDER BY projects.id DESC LIMIT :start, :lim");
		$proj_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$proj_db->bindParam(":lim", $lim, \PDO::PARAM_INT);
		$proj_db->execute();

		$rowCount = $proj_db->rowCount();

		if($rowCount != 0) {
			while($proj = $proj_db->fetchObject()) {
				$arr_proj[] = $proj;
			}

			return $arr_proj;
		} else {
			return false;
		}
	}

	public static function getFullCatalogByGet()
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->query("
			SELECT projects.id, projects.title
			FROM projects
			ORDER BY projects.id
			");

		if($proj_db->rowCount() != 0) {
			while($proj = $proj_db->fetchObject()){
				$arr_proj[] = $proj;
			}
			return $arr_proj;
		} else {
			return false;
		}
		

		
	}

	public static function getUsersByGet(int $page = 1)
	{
		if(isset($_GET['page'])) {$page = (int) $_GET['page'];}

		$lim = self::LIMIT;
		
		if($page <= 0) {$page = 1;}

		$start = ($page * self::LIMIT) - self::LIMIT;

		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT users.id, users.login
			FROM users
			ORDER BY users.id DESC LIMIT :start, :lim");
		$proj_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$proj_db->bindParam(":lim", $lim, \PDO::PARAM_INT);
		$proj_db->execute();

		$rowCount = $proj_db->rowCount();

		if($rowCount != 0) {
			while($proj = $proj_db->fetchObject()) {
				$arr_proj[] = $proj;
			}

			return $arr_proj;
		} else {
			return false;
		}
	}




	public static function getItemByCategorAndId($categor, $id)
	{
		$categor = trim(strip_tags($categor));
		$id = (int) $id;


		if($categor == "news") {
			return self::getOneNewsById($id);
		}
		elseif($categor == "catalog") {
			return self::getOneProjById($id);
		}
		elseif(($categor == "users") &&(Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 2)) {
			return self::getOneUserById($id);
		}
		else {
			return false;
		}
	}

	public static function getOneNewsById($id)
	{
		$db = \DB\DB::Connect();

		$news_db = $db->prepare("SELECT * FROM `news` WHERE `id` = :id");
		$news_db->execute([":id"=>$id]);

		$rowCount = $news_db->rowCount();

		if($rowCount != 0) {
			return $one_news = $news_db->fetchObject();
		} else {
			return false;
		}
	}

	public static function getOneProjById($id)
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT projects.id, projects.title, projects.img, projects.html, projects.status, projects.year, GROUP_CONCAT(genres.genre) as genre, projects.is_active
			FROM projects JOIN proj_genre JOIN genres 
			ON proj_genre.id_proj = projects.id AND proj_genre.id_genre = genres.id 
			GROUP BY(projects.id) HAVING projects.id = :id");
		$proj_db->execute([":id"=>$id]);

		$rowCount = $proj_db->rowCount();

		if($rowCount != 0) {
			$arr_proj = $proj_db->fetchObject();

			$arr_proj->info["genre"] = explode(",", $arr_proj->genre);

			return $arr_proj;
		} else {
			return false;
		}
	}

	public static function getOneUserById($id)
	{
		$db = \DB\DB::Connect();

		$user_db = $db->prepare("
			SELECT users.id, users.login, users.email, users.img, role.role_ru, role.id as 'role_id', users.is_block
			FROM `users` JOIN `role`
			ON users.role = role.id
			WHERE users.id = :id
			GROUP BY (users.login)");
		$user_db->execute([":id"=>$id]);

		$rowCount = $user_db->rowCount();

		if($rowCount != 0) {
			return $one_user = $user_db->fetchObject();
		} else {
			return false;
		}
	}



	public static function editNews($id, $title, $text, $type)
	{
		$id = (int) $id;
		$title = trim(strip_tags($title));
		$text = trim(strip_tags($text));
		$type = (int) $type;

		if($title == "") {
			$errors[] = "Заполнить заголовок новости";
		}
		if($text == "") {
			$errors[] = "Заполнить описание новости.";
		}

		if(empty($errors)) {
			if(self::updateNewsById($id, $title, $text, $type)) {
				$log_info = "Изменена новость. ID:".$id;
				self::recordLog($log_info);
				echo 1;
			} else {
				echo 0;
			}

		} else {
			echo json_encode($errors);
		}


	}

	public static function updateNewsById($id, $title, $text, $type)
	{
		$db = \DB\DB::Connect();

		$news_db = $db->prepare("UPDATE `news` SET `title`=:title, `text`=:text, `type`=:type WHERE `id`=:id");
		$result = $news_db->execute([":title"=>$title, ":text"=>$text, ":type"=>$type, ":id"=>$id]);

		if($result == true) {
			return 1;
		} else {
			return 0;
		}
	}



	public static function editUser($id, $email, $role)
	{
		$id = (int) $id;
		$email = trim(strip_tags($email));
		$role = (int) $role;
		#Нельзя установить через админку роль: супер-админ
		if($role <= 2) { 
			$role = 2;
		}
		#Нельзя установить не существующую роль
		if($role >= 4) {
			$role = 4;
		}

		if(!preg_match("~^([a-zA-Z0-9]{1})([a-zA-Z0-9]+)([a-zA-Z0-9]{1})@([a-zA-Z0-9]+)\.([a-z0-9]+)([a-z0-9]{1})$~", $email)) {
			$errors[] = "Некорректная почта.";
		}
		if(empty($errors)) {
			if(self::updateUserById($id,$email,$role)) {
				$log_info = "Изменен пользователь. ID:".$id;
				self::recordLog($log_info);
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo json_encode($errors);
		}
	}

	public static function updateUserById($id, $email, $role)
	{
		$db = \DB\DB::Connect();

		$user_db = $db->prepare("UPDATE `users` SET `email` = :email, `role` = :role WHERE `id` = :id");
		$result = $user_db->execute([':email'=>$email, ":role"=>$role, ":id"=>$id]);

		if($result == true) {
			return 1;
		} else {
			return 0;
		}
	}



	public static function editProj($id, $title, $text, $status, $year, $genre)
	{
		$id = (int) $id;
		$title = trim(strip_tags($title));
		$text = trim(strip_tags($text));
		$status = trim(strip_tags($status));
		$year = (int) $year;

		if($title ==  "") {
			$errors[] = "Заполните название проекта";
		}
		if($text == "") {
			$errors[] = "Заполните описание проекта";
		}
		if($year == "") {
			$errors[] = "Укажите год выпуска проекта.";
		}
		if(empty($genre)) {
			$errors[] = "Укажите жанры проекта";
		}

		if(empty($errors)) {
			if(self::updateProj($id, $title, $text, $status, $year, $genre)) {
				$log_info = "Изменен проект. ID:".$id;
				self::recordLog($log_info);
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo json_encode($errors);
		}
	}

	public static function updateProj($id, $title, $text, $status, $year, $genre)
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("UPDATE `projects` SET `title` = :title, `html` = :text, `status`=:status, `year`=:year WHERE `id` = :id");
		$result = $proj_db->execute([":title"=>$title, ":text"=>$text,":status"=>$status,":year"=>$year, ":id"=>$id]);

		if($result) {
			if(self::updateGenreProj($id, $genre)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public static function updateGenreProj($id, $genre)
	{
		$count_genre = 0;
		if(self::delProjGenres($id)) {
			for($i = 0; $i < count($genre); $i++) {
				$count_genre += self::addProjGenre($id, $genre[$i]);
			}
		}

		if($count_genre == count($genre)) {
			return 1;
		} else {
			return 0;
		}
	}

	public static function delProjGenres($id)
	{
		$db = \DB\DB::Connect();

		$del_genre_db = $db->prepare("DELETE FROM `proj_genre` WHERE id_proj = :id");
		$result = $del_genre_db->execute([":id"=>$id]);

		return $result;
	}

	public static function addProjGenre($id_proj, $id_genre)
	{
		$db = \DB\DB::Connect();

		$genre_db = $db->prepare("INSERT INTO `proj_genre` VALUES (:id_proj, :id_genre)");
		$result = $genre_db->execute([":id_proj"=>$id_proj,":id_genre"=>$id_genre]);

		return $result;
	}



	public static function recordLog($log_info)
	{
		$log_info = trim(strip_tags($log_info));
		$log_user = trim(strip_tags($_SESSION["user"]['user_login']));

		$db = \DB\DB::Connect();

		$log_db = $db->prepare("INSERT INTO `logs`(`log_info`, `log_user`) VALUES (:log_info, :log_user)");
		$result = $log_db->execute([":log_info"=>$log_info, ":log_user"=>$log_user]);

		return $result;
	}


	
	public static function getMaxPageByCategory($category)
	{
		$cat = trim(strip_tags($category));

		if($cat != "news" && $cat != "catalog" && $cat != "users" && $cat != "comments") {
			$cat = "logs";
		}

		if($cat == "catalog") {$cat = "projects";}
		if($cat == "comments") {$cond = "WHERE is_active = 0";}

		$db = \DB\DB::Connect();

		$max_id_db = $db->prepare("SELECT COUNT(`id`) as `cnt` FROM $cat $cond");
		$result = $max_id_db->execute();

		if($result) {
			$count_id = $max_id_db->fetchObject();
			$count_pages = ceil($count_id->cnt / self::LIMIT);
			return $count_pages;
		} else {
			return 0;
		}
	}


	public static function addNews($title, $text, $type)
	{
		$title = trim(strip_tags($title));
		$text = trim(strip_tags($text));
		$type = (int) $type;


		if($title == "") {
			$errors[] = "Заполнить заголовок новости";
		}
		if($text == "") {
			$errors[] = "Заполнить описание новости.";
		}

		if(empty($errors)) {
			if($id_news = self::insertNews($title,$text,$type)) {
				$log_info = "Добавлена новая новость. ID:".$id_news;
				self::recordLog($log_info);
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo json_encode($errors);
		}

	}

	public static function insertNews($title, $text, $type)
	{
		$db = \DB\DB::Connect();

		$news_db = $db->prepare("INSERT INTO `news`(`title`, `text`, `type`) VALUES (:title, :text, :type)");
		$news_db->execute([":title"=>$title,":text"=>$text, ":type"=>$type]);

		$result = $db->lastInsertId();

		return $result;
	}


	public static function addProj($title, $text, $status, $year, $genre)
	{
		$title = trim(strip_tags($title));
		$text = trim(strip_tags($text));
		$status = trim(strip_tags($status));
		$year = (int) $year;

		if($title ==  "") {
			$errors[] = "Заполните название проекта";
		}
		if($text == "") {
			$errors[] = "Заполните описание проекта";
		}
		if($year == "") {
			$errors[] = "Укажите год выпуска проекта.";
		}
		if(empty($genre)) {
			$errors[] = "Укажите жанры проекта";
		}

		if(empty($errors)) {
			if($id_proj = self::insertProj($title, $text, $status, $year)) {
				if(self::updateGenreProj($id_proj, $genre)) {
					$log_info = "Добавлен новый проект. ID:".$id_proj;
					self::recordLog($log_info);
					echo 1;
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			echo json_encode($errors);
		}
	}


	public static function insertProj($title, $html, $status, $year)
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			INSERT INTO `projects`(`title`, `html`, `status`, year) 
			VALUES (:title, :html, :status, :year)");
		$proj_db->execute([":title"=>$title,":html"=>$html, ":status"=>$status,":year"=>$year]);

		$id_proj = $db->lastInsertId();

		return $id_proj;
	}


	public static function hideAndActiveBlockById($id, $category, $is_active)
	{
		# Скрывает определенные новости или проекты
		$id = (int) $id;
		$category = trim(strip_tags($category));
		$is_active = (int) $is_active; // 1 = active/ 0 = hide

		switch ($category) {
			case 'news':
			$table_name = "news";
			break;
			case 'catalog':
			$table_name = "projects";
			break;
			
			default:
			return false;
			break;
		}

		$db = \DB\DB::Connect();

		$id = (int) $id;

		$hide_db = $db->prepare("UPDATE $table_name SET `is_active` = :is_active WHERE `id` = :id");
		$result = $hide_db->execute([":id"=>$id, ":is_active"=>$is_active]);

		if($result) {
			$log_info = "Изменено отображение ".$category.". ID:".$id; 
			self::recordLog($log_info);
			echo 1;
		} else {
			echo 0;
		}
	}

	public static function blockUser($id, $is_block)
	{
		$id = (int) $id;
		$is_block = trim(strip_tags($is_block));

		# 0 - Разблокировать. 1 - Заблокировать
		switch ($is_block) {
			case 'block':
			$block = 0; 
			break;
			case 'not blocked':
			$block = 1; 
			break;
			
			default:
			echo 0;
			return false;
			break;
		}

		$db = \DB\DB::Connect();

		$user_db = $db->prepare("UPDATE `users` SET `is_block` = :is_block WHERE `id` = :id");
		$result = $user_db->execute([":is_block"=>$block, ":id"=>$id]);

		if($result)
		{
			$log_info = ($block) ? "Пользователь ID:".$id." заблокирован" : "Пользователь ID:".$id." разблокирован";
			self::recordLog($log_info);
			echo 1;
		}else {
			echo 0;
		}
	}


	public static function showComment($id_comm)
	{
		$id_comm = (int) $id_comm;
		
		$db = \DB\DB::Connect();

		$comm_db = $db->prepare("UPDATE `comments` SET `is_active` = 1 WHERE `id` = :id_comm");
		$result = $comm_db->execute([":id_comm"=>$id_comm]);

		if($result)
		{
			echo 1;
		}else {
			echo 0;
		}

	}

	public static function getVideoSections($id_proj)
	{
		$db = \DB\DB::Connect();

		$id_proj = (int) $id_proj;

		$section_db = $db->prepare("SELECT id, title FROM `video_section` WHERE `id_proj` = :id AND `is_active` = 1");
		$section_db->execute([':id'=>$id_proj]);

		if($section_db->rowCount() != 0) {
			while($section = $section_db->fetchObject()) {
				$arr_section[] = $section;
			}

			return $arr_section;
		} else {
			return 0;
		}
	}

	public static function getVideoLinks($id_section)
	{
		$id = (int) $id_section;

		$db = \DB\DB::Connect();

		$links_db = $db->prepare("SELECT * FROM `video_link` WHERE `id_section` = :id AND `is_active` = 1");
		$links_db->execute([':id'=>$id]);

		if($links_db->rowCount() != 0)
		{
			while($link = $links_db->fetchObject()) {
				$arr_links[] = $link;
			}
			return $arr_links;
		} else {
			return 0;
		}

	}

	public static function overwriteVideoLink($input_data, $id_link, $id_section)
	{
		$id_section = (int) $id_section;
		$id_link = (int) $id_link;
		$title = trim(strip_tags($input_data[0]));
		$url = trim(strip_tags($input_data[1]));
		$indexNum = trim(strip_tags($input_data[2]));



		if($title == "") {
			$errors[] = "Заполните поле Title";
		}
		if($url == "") {
			$errors[] = "Заполните поле Url";
		}
		if($indexNum == "") {
			$errors[] = "Заполните поле Index";
		}

		if(empty($errors)) {
			if(self::updateVideoLink($id_link,$title,$url,$id_section,$indexNum)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return json_encode($errors);
		}
	}
	
	public static function updateVideoLink($id_link, $title, $url, $id_section, $index_num)
	{
		$db = \DB\DB::Connect();

		$link_db = $db->prepare(
			"UPDATE `video_link`
			SET `title` = :title, `url` = :url, `index_number` = :index_num
			WHERE `id` = :id AND `id_section` = :id_section");
		$result = $link_db->execute([':title'=>$title,':url'=>$url,':index_num'=>$index_num,':id'=>$id_link,':id_section'=>$id_section]);

		if($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function addVideoLink($input_data, $id_section)
	{
		$id_section = (int) $id_section;
		$title = trim(strip_tags($input_data[0]));
		$url = trim(strip_tags($input_data[1]));
		$indexNum = trim(strip_tags($input_data[2]));

		if($title == "") {
			$errors[] = "Заполните поле Title";
		}
		if($url == "") {
			$errors[] = "Заполните поле Url";
		}
		if($indexNum == "") {
			$errors[] = "Заполните поле Index";
		}

		if(empty($errors)) {
			if(self::insertVideoLink($title,$url,$id_section,$indexNum)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return json_encode($errors);
		}
	}

	public static function insertVideoLink($title, $url, $id_section, $indexNum)
	{
		$db = \DB\DB::Connect();

		$link_db = $db->prepare(
			"INSERT INTO `video_link` (`title`, `url`, `id_section`, `index_number`)
			VALUES (:title,:url,:id_section,:index_number)");
		$link_db->execute([':title'=>$title,':url'=>$url,':id_section'=>$id_section,':index_number'=>$indexNum]);

		if($link_db->rowCount() != 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function overwriteVideoSection($id_section,$title, $id_proj)
	{
		$id_section = (int) $id_section;
		$id_proj = (int) $id_proj;
		$title = trim(strip_tags($title));

		if($title == "") {
			$errors[] = "Заполните название видео-секции.";
		}

		if(empty($errors)) {
			if(self::updateVideoSection($id_section,$title,$id_proj)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return json_encode($errors);
		}
	}

	public static function updateVideoSection($id_section,$title, $id_proj)
	{
		$db = \DB\DB::Connect();

		$update_db = $db->prepare("UPDATE `video_section` SET `title`= :title WHERE `id`= :id AND `id_proj` = :id_proj");
		$result = $update_db->execute([':title'=>$title,':id'=>$id_section, ":id_proj"=>$id_proj]);

		if($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function addVideoSection($id_proj, $title)
	{
		$id_proj = (int) $id_proj;
		$title = trim(strip_tags($title));

		if($title == "") {
			$errors[] = "Заполните название видео-секции";
		}

		if(empty($errors)) {
			if(self::insertVideoSection($id_proj,$title)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return json_encode($errors);
		}
	}

	public static function insertVideoSection($id_proj, $title)
	{
		$db = \DB\DB::Connect();

		$section_db = $db->prepare(
			"INSERT INTO `video_section` (`title`, `id_proj`)
			VALUES (:title,:id_proj)");
		$result = $section_db->execute([':title'=>$title,':id_proj'=>$id_proj]);

		if($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function hideVideoSection($id_section)
	{
		$id_section = (int) $id_section;

		$db = \DB\DB::Connect();

		$section_db = $db->prepare("UPDATE `video_section` SET `is_active` = 0 WHERE `id` = :id");
		$result = $section_db->execute([':id'=>$id_section]);

		if($result) {
			return 1;
		} else {
			return 0;
		}
	}

	public static function delVideoLink($id_link)
	{
		$id_link = (int) $id_link;

		$db = \DB\DB::Connect();

		$link_db = $db->prepare("DELETE FROM `video_link` WHERE `id`=:id");
		$result = $link_db->execute([':id'=>$id_link]);

		if($result) {
			return 1;
		} else {
			return 0;
		}
	}


	public static function uploadProjImg($id_proj)
	{
		$id_proj = (int) $id_proj;
		if(empty($_FILES)) {return false;}

		$file = $_FILES[0];
		$uploadDir = ROOT."/media/images/projUpload/";
		$nameImg = date("YmdHis").rand(100,1000).".jpg";

		$uploadPath = "$uploadDir$nameImg";

		if(!($file['type'] == 'image/gif' || $file['type'] == 'image/jpeg' || $file['type'] == 'image/png')) {
			$errors["type-size"][] = "Ошибка типа файла";
		}

		if($file['size'] == 0 || $file['size']>=512000) {
			$errors["type-size"][] = "Превышение максимального размера файла";
		}

		if(empty($errors)) {
			if(!move_uploaded_file($file['tmp_name'], $uploadPath)) {
				$errors[] = "Не удалось загрузить картинку";
				return json_encode($errors);
			} else {
				$size = getimagesize($uploadPath); // size[0] = ширина. $size[1] = высота.
				if($size[0] < 1501 && $size[1] < 1501) {
					if(self::updateProjImg($id_proj, $nameImg)) {
						$log = "Изменен проект ID:".$id_proj;
						self::recordLog($log);
						return 1;
					} else {
						return 0;
					}
				} else {
					$errors[] = "Превышен допустимый размер картинки.";
					unlink($uploadPath); // удаление картинки
					return json_encode($errors);
				}
			}
		} else {
			return json_encode($errors);
		}

	}

	public static function updateProjImg($id_proj, $img_name)
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("UPDATE `projects` SET `img` = :img WHERE `id` = :id");
		$result = $proj_db->execute([':id'=>$id_proj,':img'=>$img_name]);

		if($result) {
			return true;
		} else {
			return false;
		}
	}


}