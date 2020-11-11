<?php

class SearchController
{
	public function actionIndex()
	{
		$search = trim(htmlspecialchars($_GET['search']));
		$proj = App\Models\getProject::getProjectBySearch($search);

		include_once(ROOT.'/public/view/search/search.php');
		return true;
	}
}