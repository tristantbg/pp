<?php snippet('header') ?>

<div id="container">

<div class="inner">

<?php if($page->text()->isNotEmpty()): ?>
<section class="error">
	<?= $page->text()->kt() ?>
</section>
<?php endif ?>

</div>
	
</div>

<?php snippet('footer') ?>