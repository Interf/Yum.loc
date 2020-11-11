<?php
include_once(ROOT.'/components/header.php');
?>


<h1>Изменение данных пользователя</h1>

<div class="content-container">

	<div class="new-block cat-container">

		<!-- если нет get -->
		<h3>Что вы хотите изменить?</h3>
		<p><a href="/user/change-data/?change=pass">Изменить пароль</a></p>
		<p><a href="/user/change-data/?change=img">Изменить картинку</a></p>


		<?php if(isset($_GET['change']) && $_GET['change'] == "pass") :?>
			<!-- Изменение пароля -->
			<div class="change-errors"></div>
			<form action="" method="POST" class="user-form-change-pass">
				<div class="log-input">
					<input type="password" name="oldPass" placeholder="Ваш текущий пароль">
				</div>
				<div class="log-input">
					<input type="password" name="newPass1" placeholder="Ваш новый пароль">
				</div>
				<div class="log-input">
					<input type="password" name="newPass2" placeholder="Повторите ваш новый пароль">
				</div>
				<button class="do_change_pass btn btn-success" type="button" name="do_change_pass">Сменить пароль</button>
			</form>
		<?php endif; ?>

		<?php if(isset($_GET['change']) && $_GET['change'] == "img") :?>
			<div class="change-errors" style="color: red;"></div>
			<!-- Сменить аватарку -->
			<!-- <form action="/user/change-data" method="POST"></form> -->
			<h2>Размер изображения не превышает 512 Кб, пиксели по ширине не более 500, по высоте не более 1500. </h2>
			<form name="upload" method="POST" ENCTYPE="multipart/form-data" class="user-form-upload"> 
				Выберите файл для загрузки: 
				<input type="file" name="userfile">
				<input type="button" class="do_upload" name="do_upload" value="Загрузить"> 
			</form>


		<?php endif; ?>

	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>