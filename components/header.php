<?php
if(isset($_SESSION['user']) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login']) == false ) {
	header("Location: /logout");
}

$menu = App\Models\getMenu::getMenu();

$url = $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- Адаптивность -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- text -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

	
	<link rel="stylesheet" href="/media/css/style.css">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
	
	<div class="top">
		<div class="container">
			<div class="auth-block">
				<?php if(isset($_SESSION['user']['user_token'])) : ?>
					
					<a href="/user/profile" class="auth-first">Здравствуйте, <?=$_SESSION['user']['user_login'];?></a>
					<a href="/logout" class="auth-first">Выйти</a>
				<?php else : ?>
					<a href="/login" class="auth-first">Вход</a>
					<a href="/register" class="auth-second">Регистрация</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<header>
		<div class="container">

			<nav class="navbar navbar-expand-md navbar-light">
				

				<a class="navbar-brand" href="/"><img src="/media/images/new-logo3.png" alt=""></a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-menu">Меню</span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
						<?php foreach($menu as $menu) :?>
							<li class="nav-item">
								<a class="nav-link <?php echo ($url==$menu->url ?  'active_menu' :  '') ?>" href="<?=$menu->url;?>"><?=$menu->title;?></a>
							</li>
						<?php  endforeach; ?>
					</ul>
				</div>
			</nav>

		</div>
	</header>


	<div class="container">

		<div class="search">
			<form action="/search/" method="GET">
				<input type="text" placeholder="Найти аниме по названию" class="input_search" name="search" autocomplete="off">
				<input type="submit" value="Поиск" class="btn_search btn btn-success">
			</form>
		</div>

		<div class="button-filter">
			<button class="btn btn-success">Фильтр аниме</button>
		</div>