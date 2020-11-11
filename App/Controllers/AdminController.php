<?php

class AdminController
{
	public function actionIndex()
	{
		if(!(App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 3 && isset($_SESSION['user'])) ) {
			header("Location: /");
			return true;
		}

		if(isset($_SESSION['user']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login']) == false) {
			header("Location: /logout");
		}


		$arr_get = App\Models\Admin::getDataByGet($_GET['data']);

		if(($_GET['data'] == "users") && App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) >= 3) {
			$_GET['data'] = null;
		}

		if(($_GET['data'] == "video-links") && App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) >= 3) {
			$arr_get = false;
		}

		if($_GET['page'] == null) {
			$_GET['page'] = 1;
		}

		if($_GET['data'] == null) {
			$_GET['data'] = "logs";
		}		

		include_once(ROOT.'/public/view/admin/admin_panel.php');
		return true;
	}

	public function actionEdit($category, $id)
	{
		$arr_category = App\Models\Admin::getItemByCategorAndId($category, $id);
		if(($category == "catalog") && $arr_category != false) {
			$arr_genre = App\Models\getGenre::getGenreForSidebar();
			$arr_section = App\Models\Admin::getVideoSections($id);
		}
		
		include_once(ROOT."/public/view/admin/admin_form.php");
		return true;
	}

	public function actionForms()
	{

		if(isset($_SESSION['user']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login'])) {
			
			$user_role = App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']);

			if($user_role <= 3) {

				if(isset($_POST['do_edit_news'])) {
					App\Models\Admin::editNews($_POST['do_edit_news'], $_POST['title'], $_POST['text'], $_POST['type']);
				}
				if(isset($_POST['do_edit_proj'])) {
					App\Models\Admin::editProj($_POST["do_edit_proj"], $_POST['title'], $_POST['text'], $_POST['status'], $_POST['year'], $_POST['genre']);
				}
				if(isset($_POST['do_hide_block'])) {
					App\Models\Admin::hideAndActiveBlockById($_POST['id'], $_POST['category'], $_POST['is_active']);
				}
				if(isset($_POST['do_show_comm'])) {
					App\Models\Admin::showComment($_POST['id_comm']);
				}
				if(isset($_POST['change_section'])) {
					$result =  App\Models\Admin::overwriteVideoSection($_POST['id_section'], $_POST['title'], $_POST['id_proj']);

					if($result == 1) {
						$test[] = 1;
						$test[] = App\Models\Admin::getVideoSections($_POST['id_proj']);
						echo json_encode($test);
					} else {
						echo $result;
					}
				}
				if(isset($_POST['add_video_section'])) {
					$result = App\Models\Admin::addVideoSection($_POST['id_proj'], $_POST['title']);

					if($result == 1) {
						$test[] = 1;
						$test[] = App\Models\Admin::getVideoSections($_POST['id_proj']);
						echo json_encode($test);
					} else {
						echo $result;
					}	
				}
				if(isset($_POST['load_proj_img'])) {
					$result = App\Models\Admin::uploadProjImg($_POST['id_proj']);
					echo $result;
				}

				if($user_role <= 2) {
					if(isset($_POST['do_edit_user'])) {
						App\Models\Admin::editUser($_POST['do_edit_user'], $_POST['email'], $_POST['role']);
					}

					if(isset($_POST['do_add_news'])) {
						App\Models\Admin::addNews($_POST['title'], $_POST['text'], $_POST['type']);
					}

					if(isset($_POST['do_add_proj'])) {
						App\Models\Admin::addProj($_POST['title'], $_POST['text'], $_POST['status'], $_POST['year'], $_POST['genre']);
					}

					if(isset($_POST['do_block_user'])) {
						App\Models\Admin::blockUser($_POST['user_id'], $_POST['is_block']);
					}
					if(isset($_POST['get_video_section'])) {
						echo json_encode(App\Models\Admin::getVideoSections($_POST['id_proj']));
					}
					if(isset($_POST['get_video_links'])) {
						echo json_encode(App\Models\Admin::getVideoLinks($_POST['id_section']));
					}
					if(isset($_POST['confirm_video_link_change'])) {
						$result =  App\Models\Admin::overwriteVideoLink($_POST['input_data'],$_POST['id_link'], $_POST['id_section']);

						if($result == 1) {
							$test[] = 1;
							$test[] = App\Models\Admin::getVideoLinks($_POST['id_section']);
							echo json_encode($test);
						} else {
							echo $result;
						}
					}
					if(isset($_POST['add_video_link'])) {
						$result = App\Models\Admin::addVideoLink($_POST['input_data'], $_POST['id_section']);

						if($result == 1) {
							$test[] = 1;
							$test[] = App\Models\Admin::getVideoLinks($_POST['id_section']);
							echo json_encode($test);
						} else {
							echo $result;
						}
					}
					if(isset($_POST['del_video_section'])) {
						$result = App\Models\Admin::hideVideoSection($_POST['id_section']);

						if($result == 1) {
							$test[] = 1;
							$test[] = App\Models\Admin::getVideoSections($_POST['id_proj']);
							echo json_encode($test);
						} else {
							echo $result;
						}
					}
					if(isset($_POST['del_video_link'])) {
						$result = App\Models\Admin::delVideoLink($_POST['id_link']);

						if($result == 1) {
							$test[] = 1;
							$test[] = App\Models\Admin::getVideoLinks($_POST['id_section']);
							echo json_encode($test);
						} else {
							echo $result;
						}
					}
				}


			}


		} else {
			echo 0;
		}


		return true;
	}

	public static function actionAdd()
	{
		if(!(App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 2 && isset($_SESSION['user'])) ) {
			header("Location: /");
			return true;
		}


		if(($_GET['data'] == "catalog")) {
			$arr_genre = App\Models\getGenre::getGenreForSidebar();
		}


		include_once(ROOT.'/public/view/admin/admin_add.php');
		return true;
	}

}