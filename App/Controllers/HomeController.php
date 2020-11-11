<?php

class HomeController
{
	public function actionIndex()
	{
		$news_type_1 = App\Models\getNews::getNewsForHomeType1();
		$news_type_2 = App\Models\getNews::getNewsForHomeType2();

		$proj = App\Models\getProject::getProjectForHome();

		include_once(ROOT.'/public/view/home/home.php');
		return true;
	}

	public function actionLoad()
	{
		if(isset($_POST['do_load'])) {
			$page = (int) $_POST['page'];
			$proj = App\Models\getProject::getProjectForHome($page);
			echo json_encode($proj);
		}

		return true;
	}
}