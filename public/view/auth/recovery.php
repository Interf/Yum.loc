<?php
include_once(ROOT.'/components/header.php');
?>



<div class="content-container">

	<div class="new-block cat-container">

		
		<?php if(isset($_GET['recovery']) && $_GET['recovery'] == "mode" && $_GET['rec_hash'] != "") : ?>
			<!-- форма установки нового пароля по ссылке из почты-->
			<h1>Установка нового пароля</h1>
			<div class="recovery-error"></div>
			<form action="<?=$url?>" method="POST" class="form-log form-recovery">
				<div class="log-input"><input type="password" name="pass1" placeholder="Ваш пароль"></div>
				<div class="log-input"><input type="password" name="pass2" placeholder="Повторите ваш пароль"></div>
				<button type="button" class="do_recovery btn btn-success" name="do_recovery">Восстановить</button>
			</form>

		<?php else: ?>
			<!-- Форма проверки почты -->
			<h1>Введите вашу почту</h1>
			<div class="recovery-error"></div>
			
			<form action="/forgot-pass" method="POST" class="form-log form-email">
				<div class="log-input"><input type="email" name="email" placeholder="Ваш E-mail"></div>
				<button type="button" class="do_check_email btn btn-success" name="do_check_email">Восстановить</button>
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