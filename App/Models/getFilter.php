<?php

namespace App\Models;

class getFilter
{
	public function checkGetQuery(array $get)
	{
		$arr_filter = array();
			// Экранирование get массива
		if(!empty($get)) {
						// Поиск по жанру
			if(!empty($get["genre"])) {
				foreach($get["genre"] as $genre) {
					$arr_filter["genre"][] = strip_tags($genre); 
				}
			}

				// Поиск по статусу
			if(!empty($get["status"])) {
				$arr_filter["status"] = strip_tags($get['status']); 
			}

				// Поиск от определенного года
			if(!empty($get["year_start"])) {
				$arr_filter["year_start"] =  (int) $get["year_start"];
			}

				// Поиск до определенного года
			if(!empty($get["year_end"])) {
				$arr_filter["year_end"] =  (int) $get["year_end"];
			}
		}

		return $arr_filter;

	}


	public static function getMinMaxYear()
	{
		$db = \DB\DB::Connect();

		$year_db = $db->query("SELECT MIN(year) as `min`, MAX(year) as `max` FROM `projects`");

		while($year = $year_db->fetchcObject()) {
			$arr_year[] = $year;
		}

		return $arr_year;
	}

	public static function getProjectByFilter(array $filter)
	{
		$db = \DB\DB::Connect();

		$param = array(); // execute param

		$condition = false; // having query

		//Посик по жанрам
		if(!empty($filter["genre"])) {
			foreach($filter["genre"] as $genre) {
				$condition .= "AND `genre` LIKE CONCAT('%', ? , '%') ";
				$param[] = $genre;
			}
		}

		// Поиск по статусу
		if(!empty($filter["status"])) {
			$condition .= "AND projects.status = ? ";
			$param[] = $filter["status"];
		}

		// Поиск от определенного года
		if(!empty($filter["year_start"])) {
			$condition .= "AND projects.year >= ? ";
			$param[] = $filter["year_start"];
		}

		// Поиск до определенного года
		if(!empty($filter["year_end"])) {
			$condition .= "AND projects.year <= ? ";
			$param[] = $filter["year_end"];
		}

		if($condition != false) {
			$cond = "HAVING ".strstr($condition," ");
		} else {
			$cond = "";
		}


		$proj_db = $db->prepare("
			SELECT projects.*, GROUP_CONCAT(genres.translit) as genre 
			FROM projects JOIN proj_genre ON proj_genre.id_proj = projects.id JOIN genres ON genres.id = proj_genre.id_genre AND projects.is_active = 1
			GROUP BY(projects.title)
			$cond 
			ORDER BY (projects.id) DESC");
		$proj_db->execute($param);

		while($proj = $proj_db->fetchObject()) {
			$arr_proj[] = $proj;
		}

		return $arr_proj;
	}
}