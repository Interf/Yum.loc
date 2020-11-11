<?php
include_once(ROOT.'/components/header.php');
?>

<h1>Поиск</h1>

<div class="content-container">

	<div class="new-block cat-container">
		<?php if(is_string($proj)) :?>
			<h1><?=$proj;?></h1>
		<?php elseif($proj == null) : ?>
			<h1>нет такого аниме</h1>
		<?php else: ?>
			<div class="catalog_blog row">
				<?php foreach($proj as $proj) :?>
					<div class="col-md-3 test">
						<a href="/catalog/item/<?=$proj->id;?>">
							<span class="catalog_year"><?=$proj->year;?></span>
							<img src="/media/images/projUpload/<?=$proj->img?>"; alt="">
							<p><?=$proj->title?></p>
						</a>
					</div>
				<?php endforeach; ?>
			</div>

		<?php endif; ?>

	</div>

	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>

<?php
include_once(ROOT.'/components/footer.php');
?>