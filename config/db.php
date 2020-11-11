<?php

namespace DB;

use App\DATA;

class DB
{
	public static function Connect()
	{
		$db = new \PDO(DATA::DB_TYPE.":localhost=".DATA::HOST_NAME.";dbname=".DATA::DB_NAME."", DATA::DB_LOG, DATA::DB_PASS,[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
		$db->query("SET lc_time_names = 'ru_RU'"); // January => Январь
		return $db;
	}
}