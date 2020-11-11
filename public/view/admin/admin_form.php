<?php include_once(ROOT.'/components/admin_header.php'); ?>



<div class="admin-content col-md-9">
	<?php if($arr_category != false) : ?>
		<div class="error-message"></div>
		<?php if($category == "news") :?>
			<form action="/administrator" method="POST" class="form-news">
				<h1>Изменение новости</h1>
				<button 
				type="button" 
				class="do_hide_and_active" 
				is_active='<?php if($arr_category->is_active){echo 0;} else {echo 1;}?>'
				category="<?=$category?>"
				data-id="<?=$arr_category->id;?>">
				<?php if($arr_category->is_active){echo "Скрыть новость";} else {echo "Отобразить новость";}?>
			</button>
			<h5>Заголовок новости</h5>
			<div class="admin-input">
				<input type="text" name="news-title" value="<?=$arr_category->title?>">
			</div>
			<h5>Описание новости</h5>
			<div class="admin-input">
				<textarea name="news-text"><?=$arr_category->text;?></textarea>
			</div>
			<h5>Тип новости</h5>
			<div class="admin-input">
				<select name="news-type">
					<option value="1" <?php if($arr_category->type == 1) echo "selected";?>>Обновления аниме</option>
					<option value="2" <?php if($arr_category->type == 2) echo "selected";?>>Новость на сайте</option>
				</select>
			</div>
			<br>
			<button type="button" name="do_edit_news" class="do_edit_news" value="<?=$arr_category->id;?>">Изменить новость</button>
		</form>

	<?php elseif($category == "catalog") : ?>

		<form action="" method="POST" class="form-catalog" enctype="multipart/form-data">
			<h1>Изменение проекта</h1>
			<button 
			type="button" 
			class="do_hide_and_active" 
			is_active='<?php if($arr_category->is_active){echo 0;} else {echo 1;}?>'
			category="<?=$category?>"
			data-id="<?=$arr_category->id;?>">
			<?php if($arr_category->is_active){echo "Скрыть новость";} else {echo "Отобразить новость";}?>
		</button>
		<h5>Название проекта</h5>
		<div class="admin-input">
			<input type="text" name="proj-title" value="<?=$arr_category->title;?>">
		</div>
		<h5>Описание проекта</h5>
		<div class="admin-input">
			<textarea name="proj-text"><?=$arr_category->html?></textarea>
		</div>
		<div class="admin-input">
			<h5>Статус проекта</h5>
			<select name="proj-status">
				<option value="announ" <?php if($arr_category->status == "announ") echo "selected"?>>Анонс</option>
				<option value="ongoing" <?php if($arr_category->status == "ongoing") echo "selected"?>>Онгоинг</option>
				<option value="end" <?php if($arr_category->status == "end") echo "selected"?>>Вышел</option>
			</select>
		</div>
		<h5>Год</h5>
		<div class="admin-input">
			<input type="text" name="proj-year" value="<?=$arr_category->year;?>">
		</div>
		<h5>Жанры проекта</h5>
		<div class="proj-genre">
			<?php foreach($arr_genre as $genre) : ?>
				<div class="form-check">
					<label for="genre<?=$genre->id;?>"><?=$genre->genre;?></label>
					<input type="checkbox" name="proj-genre" id="genre<?=$genre->id;?>" <?php if(preg_match("~$genre->genre~", $arr_category->genre)) echo "checked";?> value="<?=$genre->id;?>">
				</div>
			<?php endforeach; ?>
		</div>
		
		<br>	
		<button type="button" name="do_edit_proj" class="do_edit_proj" value="<?=$arr_category->id;?>">Изменить проект</button>

		<!-- video-section -->
		<h5>Видео-секции</h5>
		<div class="admin-video-section">
			<table class="table">
				<thead class="thead-inverse">
					<tr>
						<th>Название секции</th>
						<th>Изменение</th>
					</tr>
				</thead>
				<tbody class="admin-tr">
					<div class="error_message" id-proj="<?=$id;?>"></div>
					<?php if($arr_section != 0) : ?>
						<?php foreach($arr_section as $section) :?>
							<tr id-section="<?=$section->id;?>">
								<td class="input_section"><input class="input_link" type="text" value="<?=$section->title;?>" id-section="<?=$section->id;?>" disabled></td>
								<td class="btn-change"><button type="button" class="change_video_section">Изменить</button></td>
							</tr>
						<?php endforeach ?>
					<?php endif; ?>
					<tr>
						<td class="input_section"><input class="input_link" type="text" placeholder="Название видео-секции"></td>
						<td class="btn-change"><button type="button" class="btn btn-success add_video_section">Добавить</button></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="admin-input load_proj_img_container">
			<h5>Изменение картинки</h5>
			<div class="error_img_message"></div>
			<input type="file" name="proj_img">
			<button type="button" class="load_proj_img">Изменить картинку</button>
		</div>


	</form>


<?php elseif($category == "users") :?>

	<form action="" method="POST" class="form-users">
		<h1>Изменение пользователя</h1>
		<button 
		type="button" 
		class="do_block_user" 
		is_block='<?php if($arr_category->is_block){echo 'block';} else {echo 'not blocked';}?>'
		data-id="<?=$arr_category->id;?>">
		<?php if($arr_category->is_block){echo "Разблокировать пользователя";} else {echo "Заблокировать пользователя";}?>
	</button>
	<h5>Имя пользователя</h5>
	<div class="admin-input">
		<?=$arr_category->login;?>
	</div>
	<h5>Email</h5>
	<div class="admin-input">
		<input type="email" name="users-email" value="<?=$arr_category->email;?>">
	</div>
	<h5>Роль</h5>
	<div class="admin-input">
		<select name="users-role">
			<option value="2" <?php if($arr_category->role_id <= 2) echo "selected"?>>Админ</option>
			<option value="3" <?php if($arr_category->role_id == 3) echo "selected"?>>Модератор</option>
			<option value="4" <?php if($arr_category->role_id == 4) echo "selected"?>>Пользователь</option>
		</select>
	</div>
	<br>
	<button type="button" name="do_edit_user" class="do_edit_user" value="<?=$arr_category->id;?>">Изменить данные пользователя</button>

</form>
<?php else : ?>
	Ошибка.  <a href="/administrator">Вернитесь на главную страницу.</a>
<?php endif; ?>
<?php else: ?>
	Ошибка.  <a href="/administrator">Вернитесь на главную страницу.</a>
<?php endif; ?>

</div>


<?php include_once(ROOT.'/components/admin_footer.php'); ?>