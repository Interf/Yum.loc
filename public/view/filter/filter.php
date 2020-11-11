<?php
include_once(ROOT.'/components/header.php');
?>



<h1>Фильтр</h1>

<div class="content-container">

	<div class="new-block cat-container">

		<div class="catalog_blog row">
			<?php if($proj == null) :?>
				<h1>Измените параметры запроса</h1>
			<?php else : ?>
				<?php foreach($proj as $proj) : ?>
					<div class="col-md-3 test">
						<a href="/catalog/item/<?=$proj->id?>">
							<span class="catalog_year"><?=$proj->year?></span>
							<img src="/media/images/projUpload/<?=$proj->img?>"; alt="">
							<p><?=$proj->title;?></p>
						</a>
					</div>
				<?php endforeach ?>

			<?php endif; ?>
		</div>
	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>