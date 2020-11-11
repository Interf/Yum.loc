<?php

namespace App\Models;

class getGenre
{
	public static function getGenreForSidebar()
	{
		$db = \DB\DB::Connect();

		$genre_db = $db->query("SELECT id,genre,translit FROM genres");

		while($genre = $genre_db->fetchObject()) {
			$arr_genre[] = $genre;
		}

		return $arr_genre;
	}
}