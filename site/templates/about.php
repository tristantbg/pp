<?php snippet('header') ?>

<div id="container">

	<div class="inner page">

		<div class="page-content about">

			<div class="content-item">
				<?= $site->description()->kt() ?>
			</div>

			<div class="content-item">
				<?= $page->text()->kt() ?>
			</div>

			<div id="credits" class="content-item">
				<?= $page->credits()->kt() ?>
			</div>
		</div>

	</div>
	
</div>

<?php snippet('footer') ?>