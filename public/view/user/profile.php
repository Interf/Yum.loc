<?php
include_once(ROOT.'/components/header.php');
?>


<h1>Ваш профиль</h1>

<div class="content-container">

	<div class="new-block cat-container">

		<p>Ваше имя: <?=$user_info->login;?></p>
		<p>Ваша почта: <?=$user_info->email;?></p>
		Ваш аватар:
		<div class="user_img">
			<img src="/media/images/userUpload/<?=$user_info->img;?>" alt="">
		</div>
		<p>Ваша роль: <?=$user_info->role_ru;?></p>

		<?php if($user_info->id <= 3) : ?>
			<div class="link-container">
				<a class="btn btn-warning" href="/administrator">Перейти в админку</a>
			</div>
		<?php endif; ?>
		<a class="btn btn-success" href="/user/change-data">Изменить данные</a>




	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>