<div class="sidebar-filter">
				<div class="title_block">
					<span>Фильтр</span>
				</div>

			<?php $genres = App\Models\getGenre::getGenreForSidebar();?>

				<div class="form-sidebar-search">
					<form action="/filter/" method="GET" class="from_filter">
						<div class="input-genre">
							<h3>Жанр:</h3>
							<select name="filter[genre][]" id="" multiple="" size="5">
								<option disabled>Выберите жанр</option>
								<?php foreach($genres as $genres) : ?>
								<option value="<?=trim($genres->translit,"/")?>"><?=$genres->genre?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="input-statuc">
							<h3>Статус:</h3>
							<select name="filter[status]">
								<option disabled selected="">Выберите статус</option>
								<option value="end">Вышел</option>
								<option value="ongoing">Онгоинг</option>
								<option value="announ">Анонс</option>
							</select>
						</div>
						<div class="input-year">
							<h3>Год:</h3>
							<input type="text" placeholder="От" name="filter[year_start]" autocomplete="off">
							<input type="text" placeholder="До" name="filter[year_end]" autocomplete="off">
						</div>
						<div class="do_search">
							<button class="btn btn-success" value="do_filter">Искать</button>
						</div>
					</form>
				</div>

			</div>