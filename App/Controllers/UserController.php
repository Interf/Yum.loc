<?php

class UserController
{
	public function actionIndex()
	{
		if(isset($_SESSION['user']['user_token']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login'])) {

			$user_info = App\Models\getUser::getUserInfoByLoginToken($_SESSION['user']['user_login'], $_SESSION['user']['user_token']);
			
			include_once(ROOT.'/public/view/user/profile.php');
		} else {
			header("Location: /logout");
		}
		return true;
	}

	public function actionChange()
	{
		if(isset($_SESSION['user']['user_token']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login'])) { 
			include_once(ROOT.'/public/view/user/changeData.php');
		} else {
			header("Location: /logout");
		}

		return true;
	}

	public static function actionCheck()
	{
		if(!empty($_POST)) {
			if(isset($_SESSION['user']['user_token']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login'])) {
				if(isset($_POST['do_change_pass'])) {
					$result = App\Models\changeUserData::changePassByUser($_SESSION['user']['user_login'], $_SESSION['user']['user_token'], $_POST['pass']);
					
					if(is_array($result)) {
						$arr[] = 0;
						$arr[] = $result;
						echo json_encode($arr);
					} else {
						echo 1;
					}
				}

				if(isset($_POST['do_upload'])) {
					$result = App\Models\Upload::uploadImage($_FILES);

					if(is_array($result)) {
						$arr[] = 0;
						$arr[] = $result;
						echo json_encode($arr);
					} else {
						echo 1;
					}
				}
			} else {
				echo 0;
			}
		} else {
			header("Location: /");
		}
		return true;
	}





}