<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<!-- Адаптивность -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- text -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

	
	<link rel="stylesheet" href="/media/css/admin_css.css">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>

	<div class="container">

		<div class="block-container row">
			
			<div class="admin-menu-container col-md-3">

				<nav class="navbar navbar-expand-md navbar-light">

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-menu">Меню</span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="admin-ul navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="/administrator">Главная</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/administrator/?data=news">Новости</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/administrator/?data=catalog">Каталог аниме</a>
							</li>
							<?php if(App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 2 ) : ?>
								<li class="nav-item">
									<a class="nav-link" href="/administrator/?data=video-links">Видео-ссылки</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="/administrator/?data=users">Пользователи</a>
								</li>
							<?php endif; ?>
							<li class="nav-item">
								<a class="nav-link" href="/administrator/?data=comments">Скрытые комментарии</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/" target="_blank">Сайт</a>
							</li>
						</ul>
					</div>
				</nav>

			</div>