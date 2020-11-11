<?php

namespace App\Models;

class getNews
{
	public static function getNewsForHomeType1()
	{
		$db = \DB\DB::Connect();

		$news_db = $db->query("
			SELECT DAYOFMONTH(date) as `day`, MONTHNAME(date) as `month`,`id`, `title`,`text`, `date`, `type` 
			FROM `news` 
			WHERE `type` = 1 AND `is_active` = 1
			ORDER BY `id` DESC LIMIT 5");

		while($news = $news_db->fetchObject()) {
			$arr_news[] = $news;
		}

		return $arr_news;
	}

	public static function getNewsForHomeType2()
	{
		$db = \DB\DB::Connect();

		$news_db = $db->query("
			SELECT DAYOFMONTH(date) as `day`, MONTHNAME(date) as `month`,`id`, `title`,`text`, `date`, `type` 
			FROM `news`
			WHERE `type` = 2 AND `is_active` = 1
			ORDER BY `id` DESC LIMIT 5");

		while($news = $news_db->fetchObject()) {
			$arr_news[] = $news;
		}

		return $arr_news;
	}


	public static function getNewsByCat($cat)
	{
		$db = \DB\DB::Connect();

		$news_db = $db->prepare("SELECT DAYOFMONTH(date) as `day`, MONTHNAME(date) as `month`,`id`, `title`,`text`, `date`, `type` FROM `news` WHERE `type` = :cat AND `is_active` = 1 ORDER BY `id` DESC");
		$news_db->execute([":cat"=>$cat]);

		while($news = $news_db->fetchObject()) {
			$arr_news[] = $news;
		}

		return $arr_news;
	}

	public static function getNewsById($id)
	{
		$db = \DB\DB::Connect();

		$news_db = $db->prepare("SELECT * FROM `news` WHERE `id` = :id AND `is_active` = 1");
		$news_db->execute([":id"=>$id]);

		$arr_news = $news_db->fetchObject();

		return $arr_news;
	}

}