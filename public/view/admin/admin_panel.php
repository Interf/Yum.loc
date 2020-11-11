<?php include_once(ROOT.'/components/admin_header.php'); ?>



<div class="admin-content col-md-9">
	<?php if($_GET['data'] == "news") : ?>
		<div class="news">
			<h1>Новости</h1>
			<?php if(App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 2) : ?>
				<a href="/administrator/add/?data=news">Добавить новость</a>
			<?php endif; ?>
			<table class="table">
				<thead class="thead-inverse">
					<tr>
						<th>id</th>
						<th>Название новости</th>
						<th>Ссылка на редактирование</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($arr_get as $arr) :?>
						<tr>
							<th scope="row"><?=$arr->id;?></th>
							<td><?=$arr->title;?></td>
							<td><a href="/administrator/edit/news/<?=$arr->id;?>">Редактировать</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php include_once(ROOT.'/components/admin_paginator.php'); ?>
		</div>
	<?php elseif($_GET['data'] == "catalog") : ?>
		<div class="catalog">
			<h1>Каталог</h1>
			<?php if(App\Models\Auth::getUserRole($_SESSION['user']['user_login'], $_SESSION['user']['user_token']) <= 2) : ?>
				<a href="/administrator/add/?data=catalog">Создать проект</a>
			<?php endif; ?>
			<table class="table">
				<thead class="thead-inverse">
					<tr>
						<th>id</th>
						<th>Название аниме</th>
						<th>Ссылка на редактирование</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($arr_get as $arr) :?>
						<tr>
							<th scope="row"><?=$arr->id;?></th>
							<td><?=$arr->title;?></td>
							<td><a href="/administrator/edit/catalog/<?=$arr->id;?>">Редактировать</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php include_once(ROOT.'/components/admin_paginator.php'); ?>
		</div>
	<?php elseif($_GET['data'] == "users") : ?>
		<div class="users">
			<h1>Пользователи</h1>
			<table class="table">
				<thead class="thead-inverse">
					<tr>
						<th>id</th>
						<th>Имя пользователя</th>
						<th>Ссылка на редактирование</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($arr_get as $arr) :?>
						<tr>
							<th scope="row"><?=$arr->id;?></th>
							<td><?=$arr->login;?></td>
							<td><a href="/administrator/edit/users/<?=$arr->id;?>">Редактировать</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php include_once(ROOT.'/components/admin_paginator.php'); ?>
		</div>
	<?php elseif($_GET['data'] == "comments") : ?>
		<div class="comments">
			<h1>Скрытие комментарии</h1>
			<?php if($arr_get != false) :?>
				<table class="table">
					<thead class="thead-inverse">
						<tr>
							<th>id проекта</th>
							<th>Комментарий</th>
							<th>Автор</th>
							<th>Разблокировать</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($arr_get as $arr) :?>
							<tr>
								<th scope="row"><?=$arr->id_proj;?></th>
								<td><?=$arr->comment?></td>
								<td><?=$arr->login?></td>
								<td>
									<button  class="do_show_comm" type="button" data-id="<?=$arr->id;?>">Показать</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php include_once(ROOT.'/components/admin_paginator.php'); ?>
			<?php else : ?>
				<h1>Нет скрытых комментариев</h1>
			<?php endif; ?>
			
		</div>
	<?php elseif($_GET['data'] == "video-links") : ?>
		<div class="video-links">
			<h1>Добавление и редактирование видео-ссылок</h1>
			<?php if($arr_get != false) : ?>
				<h3 class="video-title">Проекты</h3>
				<select class="custom-select" size="5">
					<option selected>---Выберите проект---</option>
					<?php foreach($arr_get as $get) : ?>
						<option value="1" class="video-projects" id-proj="<?=$get->id?>"><?=$get->title;?></option>
					<?php endforeach; ?>
				</select>
				<h3 class="video-title">Видео-секции</h3>
				
				<div class="selects-section-links">
					<select class="custom-select section-list" size="5">
						
					</select>
				</div>
				<div class="table-video-links">
					<table class="table">
						<thead class="thead-inverse">
							<tr>
								<th>Название ссылки</th>
								<th>Ссылка</th>
								<th>Index</th>
								<th>Изменение</th>
							</tr>
						</thead>
						<tbody class="admin-tr body-video-link">
							<tr>
								<td><input class="input_link" type="text" placeholder="title" disabled></td>
								<td><input class="input_link" type="text" placeholder="url"></td>
								<td><input class="input_link" type="text" placeholder="index"></td>
								<td><button type="button" class="change-video-link">Изменить</button></td>
							</tr>
						</tbody>
					</table>
				</div>
			<?php else : ?>
				<h1>Ошибка, попробуйте позже</h1>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<div class="home">
			<div class="news">
				<h1>Главная. Последние изменения.</h1>
				<table class="table">
					<thead class="thead-inverse">
						<tr>
							<th>id</th>
							<th>Запись изменения</th>
							<th>Админ</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($arr_get as $arr) :?>
							<tr>
								<th scope="row"><?=$arr->id;?></th>
								<td><?=$arr->log_info;?></td>
								<td><?=$arr->log_user?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php include_once(ROOT.'/components/admin_paginator.php'); ?>
			</div>
		</div>
	<?php endif; ?>

</div>


<?php include_once(ROOT.'/components/admin_footer.php'); ?>