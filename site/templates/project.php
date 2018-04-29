<?php snippet('header') ?>

<?php $images = $page->medias()->toStructure() ?>
<?php

$title = $page->title()->html();
$client = $page->client(); 

?>

<div id="container">

	<div class="inner page">
		
		<div class="page-content">
			<?php foreach ($images as $key => $image): ?>
				<?php $image = $image->toFile(); ?>

				<?php if($image->videolink()->isNotEmpty()): ?>
					<div class="content-item video-item <?= $image->contentsize() ?>">
						<?= $image->videolink()->embed([
							'lazyvideo' => true,
							'thumb' => thumb($image, array('width'=>1500))->url()
						]) ?>
						<?php if($image->caption()->isNotEmpty()): ?>
						<div class="item-caption">
							<?= $image->caption()->kt() ?>
						</div>
						<?php endif ?>
					</div>
				<?php else: ?>
					
					<div class="content-item image-item <?= $image->contentsize() ?>">
							<?php 
							$srcset = '';
							for ($i = 500; $i <= 2000; $i += 500) $srcset .= resizeOnDemand($image, $i) . ' ' . $i . 'w,';
							?>

							<img 
							src="<?= thumb($image, array('width'=>200, 'quality'=> 8))->url() ?>" 
							data-src="<?= resizeOnDemand($image, 1500) ?>" 
							data-srcset="<?= $srcset ?>" 
							data-sizes="auto" 
							data-optimumx="1.5" 
							class="lazyimg lazyload" 
							alt="<?= $title.' — © '.$page->date("Y").', '.$site->title()->html(); ?>" 
							width="100%" height="auto">
							<noscript>
								<img src="<?= resizeOnDemand($image, 1500) ?>" alt="<?= $title.' — © '.$page->date("Y").', '.$site->title()->html(); ?>" width="100%" height="auto" />
							</noscript>
							<?php if($image->caption()->isNotEmpty()): ?>
							<div class="item-caption">
								<?= $image->caption()->kt() ?>
							</div>
							<?php endif ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>

		<div class="project-description">
			<div class="row">
				<div class="col-2">
					Project:
					<h1><?= $title ?></h1>
				</div>
				<?php if($page->date()): ?>
				<div class="col-2">
					Year:
					<br><?= $page->date('Y') ?>
				</div>
				<?php endif ?>
			</div>
			<?php if($client->isNotEmpty()): ?>
			<div class="row">
				<div class="col-2">
					Client:
					<h2><?= $client->html() ?></h2>
				</div>
			</div>
			<?php endif ?>
			<div class="row x xas">
				<div class="col-2">
					<?= $page->text()->kt() ?>
				</div>
				<div class="col-2 x xafe">
					<div id="next-project">
						<?php if($page->hasNextVisible()): ?>
						<?php
						$next = $page->nextVisible();
						while ($next->imageonly()->bool()) {
							if($next->hasNextVisible()){
								$next = $next->nextVisible();
							}
							else {
								$next = $page->parent()->children()->visible()->first();
							}
						}
						?>
						<?php else: ?>
						<?php $next = $page->parent()->children()->visible()->first() ?>
						<?php endif ?>
						<?php
						$ntitle = $next->title()->html(); 
						if($next->subtitle()->isNotEmpty()):
							$ntitle .= ' '.$next->subtitle()->html();
						endif
						?>
						<a href="<?= $next->url() ?>" data-title="<?= $ntitle ?>" data-target="project">
						Next project:
						<br><?= $ntitle ?>
						</a>	
					</div>
				</div>
			</div>
		</div>

	</div>
	
</div>

<?php snippet('footer') ?>