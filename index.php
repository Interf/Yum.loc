<?php

session_start();





function debug($value)
{
	echo '<pre style="
	background-color: #222;
	height: 500px;
	overflow-y: scroll;
	border-bottom: 30px solid #82b344;
	color: #82b344;
	border-top: 30px solid #82b344;
	padding: 25px;
	width: 95%;
	margin: 0 auto;
	">';
	print_r($value);
	echo "</pre>";

}







define("ROOT", dirname(__FILE__));

require_once(ROOT.'/vendor/autoload.php'); // composer autoload


$db = \DB\DB::Connect();






#Авторизация через куки
use App\Models\Auth;

if(isset($_COOKIE['token']) && !isset($_SESSION['user']['user_token'])) {
	if($login = Auth::getUsername($_COOKIE['token'])) {
		if(Auth::isBlockUser($login) == false) {
			App\Models\isAuth::delSession();
		} else {
			Auth::updateToken($login);
			Auth::writeSession($login, Auth::getToken($login), Auth::getImage($login), Auth::getUserRole($login, Auth::getToken($login)));
			setcookie('token', Auth::getToken($login), time()+86400 * 30);
		}
	}
}





$router = new App\Router;
