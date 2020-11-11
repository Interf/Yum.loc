<?php include_once(ROOT.'/components/admin_header.php'); ?>



<div class="admin-content col-md-9">
	<div class="error-message"></div>
	<?php if($_GET['data'] == "news") : ?>
		<div class="news">
			<h1>Добавление новости</h1>
			<form action="/administrator" method="POST" class="form-news">
				<h5>Заголовок новости</h5>
				<div class="admin-input">
					<input type="text" name="news-title">
				</div>
				<h5>Описание новости</h5>
				<div class="admin-input">
					<textarea name="news-text"></textarea>
				</div>
				<h5>Тип новости</h5>
				<div class="admin-input">
					<select name="news-type">
						<option value="1">Обновления аниме</option>
						<option value="2">Новость на сайте</option>
					</select>
				</div>
				<br>
				<button type="button" name="do_add_news" class="do_add_news">Добавить новость</button>
			</form>
		</div>
	<?php elseif($_GET['data'] == "catalog") : ?>
		<div class="catalog">
			<h1>Создание проекта</h1>
			<form action="" method="POST" class="form-catalog">
				<h5>Название проекта</h5>
				<div class="admin-input">
					<input type="text" name="proj-title">
				</div>
				<h5>Описание проекта</h5>
				<div class="admin-input">
					<textarea name="proj-text"></textarea>
				</div>
				<div class="admin-input">
					<h5>Статус проекта</h5>
					<select name="proj-status">
						<option value="announ">Анонс</option>
						<option value="ongoing">Онгоинг</option>
						<option value="end">Вышел</option>
					</select>
				</div>
				<h5>Год</h5>
				<div class="admin-input">
					<input type="text" name="proj-year">
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
				<button type="button" name="do_add_proj" class="do_add_proj">Создать проект</button>
			</form>
		</div>
	<?php else : ?>
		<div class="home">
			Home
		</div>
	<?php endif; ?>

</div>


<?php include_once(ROOT.'/components/admin_footer.php'); ?>