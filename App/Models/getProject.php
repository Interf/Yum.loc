<?php

namespace App\Models;

class getProject
{
	public static function getProjectForHome(int $page = 1)
	{
		if($page <= 0) {$page = 1;}
		# 4 - limit
		$start = ($page * 4) - 4;

		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT projects.id, projects.title, projects.img, GROUP_CONCAT(genres.genre) as `genre`, GROUP_CONCAT(genres.translit) as `translit`
			FROM projects JOIN proj_genre JOIN genres 
			ON projects.id = proj_genre.id_proj 
			AND genres.id = proj_genre.id_genre
			AND projects.is_active = 1
			GROUP BY(projects.title)
			ORDER BY projects.id DESC LIMIT :test, 4");
		$proj_db->bindParam(":test", $start, \PDO::PARAM_INT);
		$proj_db->execute();

		$rowCount = $proj_db->rowCount();

		if($rowCount != 0) {
			while($proj = $proj_db->fetchObject()) {
				$proj->info["genre"] = explode(",", $proj->genre);
				$proj->info["translit"] = explode(",", $proj->translit);
				$arr_proj[] = $proj;
			}

			return $arr_proj;
		} else {
			return false;
		}
	}

	public static function getProjectByCat($cat)
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT projects.id, projects.title, projects.img, projects.year, GROUP_CONCAT(genres.genre) as `genre`, GROUP_CONCAT(genres.translit) as `translit`
			FROM projects JOIN proj_genre JOIN genres 
			ON projects.id = proj_genre.id_proj 
			AND genres.id = proj_genre.id_genre
			AND projects.is_active = 1
			GROUP BY(projects.title)
			HAVING translit LIKE :cat
			ORDER BY projects.id DESC");
		$proj_db->execute([":cat"=>"%$cat%"]);

		while($proj = $proj_db->fetchObject()) {
			$proj->info["genre"] = explode(",", $proj->genre);
			$proj->info["translit"] = explode(",", $proj->translit);
			$arr_proj[] = $proj;
		}

		return $arr_proj;
	}

	public static function getAllProject()
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->query("SELECT * FROM `projects` WHERE is_active = 1");

		while($proj = $proj_db->fetchObject()) {
			$arr_proj[] = $proj;
		}

		return $arr_proj;
	}

	public static function getProjectById($id)
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("
			SELECT projects.id, projects.title, projects.img, projects.html, projects.status, projects.year, GROUP_CONCAT(genres.genre) as genre, GROUP_CONCAT(genres.translit) as translit
			FROM projects JOIN proj_genre JOIN genres 
			ON proj_genre.id_proj = projects.id 
			AND proj_genre.id_genre = genres.id
			AND projects.is_active = 1
			GROUP BY(projects.title) HAVING projects.id = :id");
		$proj_db->execute([":id"=>$id]);

		if($proj_db->rowCount() == 0) {
			return false;
		} 

		$arr_proj = $proj_db->fetchObject();

		$arr_proj->info["genre"] = explode(",", $arr_proj->genre);
		$arr_proj->info["translit"] = explode(",", $arr_proj->translit);
		
		return $arr_proj;
	}

	public static function getVideoSection($id_proj)
	{
		$db = \DB\DB::Connect();

		$id_proj = (int) $id_proj;

		$section_db = $db->prepare("SELECT * FROM `video_section` WHERE `id_proj` = :id_proj AND `is_active` = 1");
		$result = $section_db->execute([':id_proj'=>$id_proj]);

		if($result) {
			while($section = $section_db->fetchObject()) {
				$arr_section[] = $section;
			}

			return $arr_section;
		} else {
			return false;
		}
	}

	public static function getVideoLink($id_section)
	{
		$id_section = (int) $id_section;

		$db = \DB\DB::Connect();

		$link_db = $db->prepare("SELECT * FROM `video_link` WHERE `id_section` = :id_section");
		$result = $link_db->execute([':id_section'=>$id_section]);

		if($result) {
			while($link = $link_db->fetchObject()) {
				$arr_link[] = $link;
			}

			return $arr_link;
		} else {
			return false;
		}
	}

	public static function getProjectBySearch($search)
	{
		if(mb_strlen($search) < 3) {
			return "Длина строки должна быть минимум 3 символа";
		} else {
			$db = \DB\DB::Connect();

			$proj_db = $db->prepare("SELECT * FROM `projects` WHERE `title` LIKE :search AND is_active = 1");
			$proj_db->execute([":search"=>"%$search%"]);

			while($proj = $proj_db->fetchObject()) {
				$arr_proj[] = $proj;
			}

			return $arr_proj;
		}
	}



	public static function getLinksBySection($section_id)
	{
		$section_id = (int) $section_id;

		$db = \DB\DB::Connect();

		$link_db = $db->prepare("SELECT * FROM `video_link` WHERE `id_section` = :id_section");
		$result = $link_db->execute([':id_section'=>$section_id]);

		if($result) {
			while($link = $link_db->fetchObject()) {
				$arr_link[] = $link;
			}
			return json_encode($arr_link);
		} else {
			return false;
		}
	}



	public static function getIdActiveProj()
	{
		$db = \DB\DB::Connect();

		$proj_db = $db->query('SELECT GROUP_CONCAT(id) as proj_id_list FROM `projects` WHERE is_active = 1');
		
		if($proj_db->rowCount() != 0) {
			return $proj_db->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}


	}




}