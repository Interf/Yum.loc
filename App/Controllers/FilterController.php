<?php

class FilterController
{
	public function actionIndex()
	{
		if(empty($_GET['filter'])) {header("Location: /");}
		$arr_get = App\Models\getFilter::checkGetQuery($_GET["filter"]);

		$proj = App\Models\getFilter::getProjectByFilter($arr_get);

		include_once(ROOT.'/public/view/filter/filter.php');
		return true;
	}
}