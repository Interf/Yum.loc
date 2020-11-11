<?php
include_once(ROOT.'/components/header.php');
?>




<h1>Category</h1>
<div class="content-container">

	<div class="new-block cat-container">

		<div class="catalog_blog row">
			<?php foreach($proj as $proj) :?>
				<div class="col-md-3 test">
					<a href="/catalog/item/<?=$proj->id;?>">
						<span class="catalog_year"><?=$proj->year;?></span>
						<img src="/media/images/projUpload/<?=$proj->img?>"; alt="">
						<p><?=$proj->title;?></p>
					</a>
				</div>
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