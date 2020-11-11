<?php

class CatalogController
{
	public function actionIndex()
	{
		$page = (int) $_GET['page'];
		if($page < 1) {
			$page = 1;
		}


		$proj = App\Models\Paginator::paginator($page);
		$max_page = App\Models\Paginator::getCountPages();

		include_once(ROOT.'/public/view/catalog/catalog.php');
		return true;
	}


	public function actionView($id)
	{
		$id = (int) $id;

		$page_comm = (int) $_GET['page_comm'];
		if($page_comm <= 1) {$page_comm = 1;$_GET['page_comm'] = 1;}

		$proj = App\Models\getProject::getProjectById($id);
		if($proj != false) {
			$section = App\Models\getProject::getVideoSection($id);
			$link = App\Models\getProject::getVideoLink($section[0]->id);

			$comm = App\Models\getComments::getCommentByProj($id, $page_comm);
		}


		include_once(ROOT.'/public/view/catalog/catalog_item.php');
		return true;
	}

	public function actionComment()
	{
		if(!empty($_POST)) {

			if(isset($_SESSION['user']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login'])) {
				if(isset($_POST['do_comment'])) {
					if($user_id = App\Models\isAuth::isAuthByTokenId($_SESSION['user']['user_token'], $_SESSION['user']['user_login'])) {
						$result = App\Models\Comment::insertComment($user_id, $_POST['comment'], $_POST['idItem']);

						if(is_array($result)) {
							$arr[] = 0;
							$arr[] = $result;
							echo json_encode($arr);
						} else {
							echo 1;
						}
					}
				}

				if((App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 3 && isset($_SESSION['user'])) ) {
					if(isset($_POST['do_hide_comm'])) {
						echo App\Models\Comment::hideComm($_POST['comm_id']);
					}
				}

			} else {
				echo 0;
			}

			if(isset($_POST['get_links'])) {
				echo App\Models\getProject::getLinksBySection($_POST['section_id']);
			}

		} else {
			header("Location: /logout");
		}



		

		return true;
	}



	public function actionTop()
	{
		include_once(ROOT.'/public/view/catalog/catalog_top.php');
		return true;
	}

	public function actionCategory($cat)
	{
		
		$cat = trim(htmlspecialchars($cat));

		$proj = App\Models\getProject::getProjectByCat($cat);

		include_once(ROOT.'/public/view/catalog/catalog_cat.php');
		return true;
	}
}