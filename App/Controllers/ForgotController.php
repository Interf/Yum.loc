<?php

class ForgotController
{
	public function actionIndex()
	{
		if(isset($_POST['do_check_email'])) {
			if(!App\Models\isAuth::isAuth()) {
				$result = App\Models\Recovery::sendEmail($_POST['email']);
				echo $result;
			}
		}
		elseif(isset($_POST['do_recovery'])) {
			if(!App\Models\isAuth::isAuth()) {
				$result = App\Models\ChangeUserData::changePass($_POST['pass'], $_POST['rec_hash']);
				echo $result;
			}
		} else {
			if(!App\Models\isAuth::isAuth()) {
				if(isset($_GET['recovery']) && $_GET['recovery'] == "mode" && $_GET['rec_hash'] != "") {
					$url = trim(strip_tags($_SERVER['REQUEST_URI']));
				}
				include_once(ROOT.'/public/view/auth/recovery.php');
			}
			else {
				header("Location: /");
			}
		}


		
		return true;
	}
}