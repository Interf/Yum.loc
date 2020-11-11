<?php
include_once(ROOT.'/components/header.php');
?>





<div class="content-container">

	<div class="new-block cat-container">

		<div class="catalog_blog row">
			<?php foreach($proj as $proj) :?>
				<div class="col-md-3 test">
					<a href="/catalog/item/<?=$proj->id?>">
						<span class="catalog_year"><?=$proj->year;?></span>
						<img src="/media/images/projUpload/<?=$proj->img?>"; alt="">
						<p><?=$proj->title?></p>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		
		<div class="paginator">
			<h1>Paginator</h1>

			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<?php if($_GET['page'] > 1) :?>
						<li class="page-item"><a class="page-link" href="/catalog/?page=<?php echo $_GET['page'] - 1; ?>">Previous</a></li>
					<?php else : ?>
						<li class="page-item disabled">
							<span class="page-link">Previous</span>
						</li>
					<?php endif; ?>

					<?php for($i=1; $i <= $max_page; $i++) :?>
						<?php if($i == $page) : ?>
							<li class="page-item active">
								<a class="page-link" href="#"><?=$i?><span class="sr-only">(current)</span></a>
							</li>
						<?php else: ?>
							<li class="page-item"><a class="page-link" href="/catalog/?page=<?=$i?>"><?=$i?></a></li>
						<?php endif; ?>
					<?php endfor; ?>
	
					<?php if($_GET['page'] != $max_page) :?>
						<li class="page-item"><a class="page-link" href="/catalog/?page=<?php echo $_GET['page'] + 1; ?>">Next</a></li>
					<?php else : ?>
						<li class="page-item disabled">
							<span class="page-link">Next</span>
						</li>
					<?php endif; ?>
				</ul>
			</nav>

		</div>





	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>












<?php
include_once(ROOT.'/components/footer.php');
?>