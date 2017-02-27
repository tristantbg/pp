<?php snippet('header') ?>

<div id="container">

<div class="inner work" data-id="<?= $page->hash() ?>">

<?php $projects = $page->children()->visible() ?>

	<div id="project-list">

	<?php foreach ($projects as $key => $project): ?>

		<?php $title = $project->title()->html(); ?>
		<?php $image = $project->image($project->featured()); ?>
		<?php $imageonly = $project->imageonly()->bool(); ?>

		<?php if($image): ?>

		<div class="project<?php e($project->imageonly()->bool(),' image-only') ?>" data-title="<?= $title ?>" data-filter="<?= $project->category() ?>">
			<?php if (!$imageonly): ?>
			<a href="<?= $project->url() ?>" data-title="<?= $title ?>" data-target="project">
			<?php endif ?>
				<?php 
				$srcset = '';
				for ($i = 500; $i <= 1500; $i += 500) $srcset .= resizeOnDemand($image, $i) . ' ' . $i . 'w,';
				?>

				<img 
				src="<?= thumb($image, array('width'=>200, 'quality'=> 8))->url() ?>" 
				data-src="<?= resizeOnDemand($image, 800) ?>" 
				data-srcset="<?= $srcset ?>" 
				data-sizes="auto" 
				data-optimumx="1.5" 
				class="lazyimg lazyload" 
				alt="<?= $title.' — © '.$project->date("Y").', '.$site->title()->html(); ?>" 
				width="100%" height="auto" />
				<?php if ($imageonly): ?>
				<noscript>
					<img src="<?= resizeOnDemand($image, 1500) ?>" alt="<?= $title.' — © '.$project->date("Y").', '.$site->title()->html(); ?>" width="100%" height="auto" />
				</noscript>
				<?php endif ?>
				<div class="project-title"><?= $title ?></div>
			<?php if (!$imageonly): ?>
			</a>
			<?php endif ?>
		</div>

		<?php endif ?>

	<?php endforeach ?>

	<div class="grid-sizer"></div>
	<div class="gutter-sizer"></div>

	</div>

	<?php $filters = $page->categories()->split(',') ?>
	<div id="categories">
		<?php foreach ($filters as $key => $filter): ?>
		<div class="filter" data-filter="<?= $filter ?>"><?= $filter ?></div>
		<?php endforeach ?>
	</div>

	<div id="mouse-title"></div>
</div>
	
</div>

<?php snippet('footer') ?>