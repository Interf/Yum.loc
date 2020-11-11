<?php
include_once(ROOT.'/components/header.php');
?>



<h1>Регистрация</h1>

<div class="content-container">

	<div class="new-block cat-container">

		<div class="register">
			<h1>Регистрация нового пользователя</h1>

			<ol style="padding: 18px;">
				<li>Все поля - обязательные</li>
				<li>Вводите только рабочий корректный e-mail, он используется для восстановления пароля</li>
				<li>Ник должен быть уникальным в пределах сайта, минимальная длина 3 символа, максимальная - 13 символов, можно использовать нижнее подчеркивание, дефис, латиницу и кириллицу (русские буквы)</li>
				<li>Не рекомендуем использовать в нике спецсимволы, если они будут мешать (в чате или комментариях), администратор будет в праве их убрать.</li>
			</ol>

			<p>После заполнения формы вам на e-mail придет письмо с подтверждением.</p>

			<p>Отправка писем на сервера @ex.ua, @i.ua, @online.ua, @meta.ua не поддерживается, используйте другие почтовые сервисы.</p>
			<div class="reg-error"></div>
			<form action="/register" method="POST" class="form-reg">
				<div class="reg-input"><input type="email" name="email" placeholder="Ваш E-mail"></div>
				<div class="reg-input"><input type="text" name="login" placeholder="Ваш ник"></div>
				<div class="reg-input"><input type="password" name="pass1" placeholder="Ваш пароль"></div>
				<div class="reg-input"><input type="password" name="pass2" placeholder="Повторите ваш пароль"></div>
				<button type="button" class="do_reg btn btn-success" name="do_reg">Зарегистрироваться</button>
			</form>

		</div>

	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>