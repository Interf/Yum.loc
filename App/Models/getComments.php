<?php

namespace App\Models;

class getComments
{
	const LIMIT = 5;

	public static function getCountCommByProj($id)
	{
		$db = \DB\DB::Connect();

		$count_db = $db->prepare("SELECT COUNT(`id`) as `cnt` FROM `comments` WHERE `id_proj` = :id AND is_active = 1");
		$count_db->execute([':id'=>$id]);

		$count = $count_db->fetchObject();

		return $count->cnt;
	}

	public static function getMaxPagesComm($id_proj)
	{
		$count_comm = self::getCountCommByProj($id_proj);
		$max_pages = ceil($count_comm / self::LIMIT);
		return $max_pages;
	}

	public static function getCommentByProj($id, int $page = 1)
	{
		$db = \DB\DB::Connect();

		$limit = self::LIMIT;

		$page = (int) $page;
		$id = (int) $id;
		if($page > self::getMaxPagesComm($id)) {
			return false;
		}

		$start = ($limit * $page) - $limit;
		
		$comm_db = $db->prepare("
			SELECT 
			comments.id, users.login, users.img, comments.comment, comments.id_proj, 
			DATE_FORMAT(comments.date,'%d') as 'day', SUBSTRING(MONTHNAME(comments.date), 1, 3) as 'month', 
			DATE_FORMAT(comments.date,'%H:%i') as 'time' 
			FROM `comments` JOIN `users` 
			ON comments.id_user = users.id 
			WHERE `id_proj` = :id AND is_active = 1 
			ORDER BY `id` DESC LIMIT :start, :lim");
		$comm_db->bindParam(":start", $start, \PDO::PARAM_INT);
		$comm_db->bindParam(":lim", $limit, \PDO::PARAM_INT);
		$comm_db->bindParam(":id", $id, \PDO::PARAM_INT);
		$comm_db->execute();

		while($comm = $comm_db->fetchObject()) {
			$arr_comm[] = $comm;
		}

		return $arr_comm;
	}
}