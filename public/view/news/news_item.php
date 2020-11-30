<?php
include_once(ROOT.'/components/header.php');
?>


<div class="content-container">

	<div class="new-block single_news_block">

		<div class="news_container">
			<h1><?=$news->title;?></h1>
			<p>
				<?=$news->text;?>
			</p>
			<a href="/">На главную</a>
		</div>

	</div>


	<?php
	include_once(ROOT."/components/sidebar.php");
	?>

</div>

<?php
include_once(ROOT.'/components/footer.php');
?>
