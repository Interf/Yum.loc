<?php

namespace App\Models;

class Paginator
{
	const PER_PAGE = 4;

	public static function getCountProj()
	{
		$db = \DB\DB::Connect();

		$count_db = $db->query("SELECT COUNT(`id`) as count FROM projects WHERE `is_active` = 1");

		$count = $count_db->fetchObject();

		return $count->count;
	}

	public static function getCountPages()
	{
		$count_pages = ceil(self::getCountProj() / self::PER_PAGE);
		return $count_pages;
	}

	public static function paginator($page = 1)
	{
		$max_page = self::getCountPages();

		if(($page <= 1) || ($page > $max_page)) {
			$page = 1;
		}

		$start = ($page * self::PER_PAGE) - self::PER_PAGE;

		$test = self::PER_PAGE;


		$db = \DB\DB::Connect();

		$proj_db = $db->prepare("SELECT * FROM `projects` WHERE `is_active` = 1 LIMIT :start, :lim");
		$proj_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$proj_db->bindParam(":lim", $test, \PDO::PARAM_INT);
		$proj_db->execute();

		while($proj = $proj_db->fetchObject()) {
			$arr_proj[] = $proj;
		}

		return $arr_proj;
	}


}