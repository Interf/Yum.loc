<?php
include_once(ROOT.'/components/header.php');
?>


<div class="content-container">

	<div class="new-block cat-container">

		<h1>Вход</h1>
		<div class="login-error"></div>
		<form action="/login" method="POST" class="form-log">
			<div class="log-input">
				<input type="text" name="login" placeholder="Ваш логин">
			</div>
			<div class="log-input">
				<input type="password" name="pass" placeholder="Ваш пароль">
			</div>
			<div class="remember_me">
				<input type="checkbox" name="remember_me" id="remember_me">
				<label for="remember_me">Запомнить меня?</label>
			</div>
			<button type="button" class="do_log btn btn-success" name="do_log">Вход</button>
		</form>
		Забыли пароль? <a href="/forgot-pass">Восстановить пароль</a>

	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>