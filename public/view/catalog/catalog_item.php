<?php
include_once(ROOT.'/components/header.php');
?>

<div class="content-container">
	<?php if($proj == false) :?>
		<h1>Ошибка. Вернитесь на главную страницу.</h1>
	<?php else : ?>
		<div class="new-block single_block">

			<div class="proj_container">
				<div class="single_img">
					<img src="/media/images/projUpload/<?=$proj->img?>" alt="">
				</div>

				<div class="single_text">
					<h1><?=$proj->title;?></h1>
					<p>Жанры:
						<?php for($i = 0; $i < count($proj->info['genre']); $i++) : ?>
							<a href="/catalog/category<?=$proj->info["translit"][$i]?>"><?=$proj->info["genre"][$i]?></a><?php if($i == (count($proj->info['genre']) - 1)) {echo "";} else {echo ",";}?>
						<?php endfor; ?>

					</p>
					<p>Год: <?=$proj->year;?> </p>
					<p><?=$proj->html?></p>

				</div>
				<div class="proj_video">
					<div class="title_block">
						<span>Видео</span>
					</div>
					
					<?php if($section != false) : ?>
						<div class="section_container">
							<div class="section_block">
								<?php foreach($section as $section) :?>
									<div class="section" section-id="<?=$section->id;?>">
										<?=$section->title;?>
									</div>
								<?php endforeach; ?>
							</div>

							<div class="choose_video_block">

							</div>
						</div>
						<div class="video_block">
							<!-- <iframe align="absmiddle" width="100%" height="350" src="" frameborder="0" allowfullscreen></iframe> -->
						</div>
					<?php endif; ?>

				</div>
			</div>

			<div class="single_comment">
				<div class="title_block">
					<span>Комментарии</span>
				</div>

				<?php if(isset($_SESSION['user']["user_token"]) && App\Models\Auth::isBlockUser($_SESSION['user']['user_login'])) : ?>
					<div class="comment-error"></div>
					<div class="form-comment">
						<h1>Форма комментариев</h1>
						<form action="/catalog/item/<?=$id;?>" method="POST" class="form-comment">
							<input type="hidden" name="idItem" value="<?=$id;?>">
							<div class="form-input">
								<textarea name="comment" placeholder="Введите свой комментарий"></textarea>
							</div>
							<button type="button" class="btn btn-success do_comment" name="do_comment">Оставить комментарий</button>
						</form>
					</div>
				<?php endif; ?>

				<?php if($comm == null) :?>
					<h3>нет комментов</h3>
				<?php else : ?>
					<div class="comm_container">
						<?php foreach($comm as $comm) : ?>
							<div class="comment">
								<a href="">
									<img src="/media/images/userUpload/<?=$comm->img?>" alt="">
								</a>
								<div class="comment_info">
									<a href=""><?=$comm->login?></a>
									<p class="comment_date"><?php echo "$comm->day $comm->month $comm->time";?></p>
									<p class="comment_body"><?=$comm->comment?></p>
								</div>
							</div>
							<?php if(isset($_SESSION['user']['user_role']) && $_SESSION['user']['user_role'] <= 3) : ?>
								<button type="button" class="do_hide_comm" data-id="<?=$comm->id;?>">Скрыть комментарий</button>
							<?php endif; ?>
							<hr>
						<?php endforeach; ?>
					</div>
					
				<?php endif; ?>
				<?php include_once(ROOT."/components/comment_paginator.php"); ?>
			</div>


		</div>
	<?php endif; ?>

	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>