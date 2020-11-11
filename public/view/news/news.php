<?php
include_once(ROOT.'/components/header.php');
?>



<div class="slider-container">

</div>


<div class="content-container">

	<div class="new-block">

		<div class="col-md-12 announcement">
			<div class="title_block">
				<span>Новости</span>
			</div>
			<div class="choise_block">
				<a href="/news">Новости аниме</a>
				<a href="/news/?cat=2">Новости</a>
			</div>

			<?php foreach($news as $news) :?>
				<a href="/news/item/<?=$news->id?>" class="news-link">
					<div class="news-item">
						<span class="news-hover"></span>
						<span class="news-date">
							<?=$news->day?> <?php echo mb_substr($news->month, 0, 3);?>
						</span>
						<span class="news-title"><?=$news->title;?></span>

					</div>
				</a>
			<?php endforeach; ?>


		</div>

	</div>



	<?php
	include_once(ROOT."/components/sidebar.php");
	?>



</div>



<?php
include_once(ROOT.'/components/footer.php');
?>
