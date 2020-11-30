<?php
include_once(ROOT.'/components/header.php');
?>




<div class="slider-container">

</div>


<div class="news-block">
	<div class="row">
		<div class="col-md-6 announcement">
			<div class="title_block">
				<span>Обновления аниме</span>
			</div>

			<?php foreach($news_type_1 as $news) :?>
				<a href="/news/item/<?=$news->id?>" class="news-link">
					<div class="news-item">
						<span class="news-hover"></span>
						<span class="news-date"><?=$news->day?> <?php echo mb_substr($news->month, 0, 3);?></span>
						<span class="news-title"><?=$news->title;?></span>
					</div>
				</a>
			<?php endforeach; ?>
			
		</div>

		<div class="col-md-6 news">
			<div class="title_block">
				<span>Новости</span>
			</div>

			<?php foreach($news_type_2 as $news) :?>
				<a href="/news/item/<?=$news->id?>" class="news-link">
					<div class="news-item">
						<span class="news-hover"></span>
						<span class="news-date"><?=$news->day?> <?php echo mb_substr($news->month, 0, 3);?></span>
						<span class="news-title"><?=$news->title;?></span>
					</div>
				</a>
			<?php endforeach; ?>

		</div>
	</div>
</div>

<div class="content-container">

	<div class="new-block">
		<div class="title_block">
			<span>Новое на сайте</span>
		</div>

		<div class="proj-home">

			<?php foreach($proj as $proj) :?>
				<div class="proj-home-block">
					<div class="proj-home-first-block">
						<a href="/catalog/item/<?=$proj->id;?>"><img src="/media/images/projUpload/<?=$proj->img?>" alt=""></a>
					</div>

					<div class="proj-home-second-block">
						<div class="proj-home-name">
							<a href="/catalog/item/<?=$proj->id;?>"><?=$proj->title;?></a>
						</div>
						<div class="proj-home-info">
							Жанры:

							<?php for($i = 0; $i < count($proj->info['genre']); $i++) : ?>
								<a href="catalog/category<?=$proj->info["translit"][$i]?>"><?=$proj->info["genre"][$i]?></a><?php if($i == (count($proj->info['genre']) - 1)) {echo "";} else {echo ",";}?>
							<?php endfor; ?>

						</div>
					</div>
				</div>
			<?php endforeach; ?>

			

		</div>

		<button class="load-more btn btn-success" value="2">Загрузить еще</button>

	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>






<?php
include_once(ROOT.'/components/footer.php');
?>

