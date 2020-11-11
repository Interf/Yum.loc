<div class="admin-paginator">

	<nav aria-label="Page navigation example">
		<ul class="pagination">

			<li class="page-item <?php if($_GET['page'] <= 1) echo "disabled"?>">
				<a class="page-link" href="/administrator/?data=<?=$_GET['data']?>&page=<?=$_GET['page'] - 1;?>">Previous</a>
			</li>
			<?php for($i=1; $i <= App\Models\Admin::getMaxPageByCategory($_GET['data']); $i++) :?>
				<?php if($_GET['page'] == $i) : ?>
					<li class="page-item disabled">
						<a class="page-link"><?=$i?></a>
					</li>
				<?php else : ?>
					<li class="page-item">
						<a class="page-link" href="/administrator/?data=<?=$_GET['data']?>&page=<?=$i?>"><?=$i?></a>
					</li>
				<?php endif; ?>
			<?php endfor; ?>
			<li class="page-item <?php if($_GET['page'] >= App\Models\Admin::getMaxPageByCategory($_GET['data'])) echo "disabled"?>">
				<a class="page-link" href="/administrator/?data=<?=$_GET['data']?>&page=<?=$_GET['page'] + 1;?>">Next</a>
			</li>
		</ul>
	</nav>

</div>