<?php

class AuthController
{
	public function actionLogin()
	{
		if(isset($_SESSION['user']['user_token'])) {
			header("Location: /");
		}

		include_once(ROOT.'/public/view/auth/login.php');
		return true;
	}


	public function actionRegister()
	{
		if(isset($_SESSION['user']['user_token'])) {
			header("Location: /");
		}

		include_once(ROOT.'/public/view/auth/register.php');
		return true;
	}


	public function actionCheck()
	{
		if(!empty($_POST)) {
			if(isset($_POST["do_reg"])) {
				$reg = App\Models\Auth::checkFormData($_POST["reg"]);

				if(is_array($reg)) {
					$arr[] = 0;
					$arr[] = $reg;
					echo json_encode($arr);
				} else {
					echo 1;
				}


			}

			if(isset($_POST['do_log'])) {
				$log = App\Models\Auth::authUser($_POST['log']);
				
				if(is_array($log)) {
					$arr[] = 0;
					$arr[] = $log;
					echo json_encode($arr);
				} else {
					echo 1;
				}
			}
		} else {
			header("Location: /logout");
		}
		

		return true;
	}

	public function actionLogout()
	{
		App\Models\isAuth::delSession();

		header("Location: /");

		return true;
	}

}