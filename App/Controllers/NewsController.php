<?php

class NewsController
{
	public function actionIndex()
	{
		if($_GET['cat'] < 1) {
			$cat = 1;
		} else {
			$cat = (int) $_GET['cat'];
		}

		$news = App\Models\getNews::getNewsByCat($cat);

		include_once(ROOT.'/public/view/news/news.php');
		return true;
	}

	public function actionView($id)
	{
		$id = (int) $id;

		$news = App\Models\getNews::getNewsById($id);



		include_once(ROOT.'/public/view/news/news_item.php');
		return true;
	}

}