<div class="admin-paginator">
	<?php $max_pages = App\Models\getComments::getMaxPagesComm($id); ?>
	<nav aria-label="Page navigation example">
		<ul class="pagination">

			<li class="page-item <?php if($_GET['page_comm'] <= 1) echo "disabled"?>">
				<a class="page-link" href="/catalog/item/<?=$id?>/?page_comm=<?=$_GET['page_comm'] - 1?>">Previous</a>
			</li>
			<?php for($i=1; $i <= $max_pages; $i++) :?>
				<?php if($_GET['page_comm'] == $i) : ?>
					<li class="page-item disabled">
						<a class="page-link"><?=$i?></a>
					</li>
				<?php else : ?>
					<li class="page-item">
						<a class="page-link" href="/catalog/item/<?=$id?>/?page_comm=<?=$i?>"><?=$i?></a>
					</li>
				<?php endif; ?>
			<?php endfor; ?>
			<li class="page-item <?php if($_GET['page_comm'] >= $max_pages) echo "disabled"?>">
				<a class="page-link" href="/catalog/item/<?=$id?>/?page_comm=<?=$_GET['page'] + 1?>">Next</a>
			</li>
		</ul>
	</nav>

</div>