<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="majorca-feature-item spin feature-item-<?php echo $bID; ?>">
	<?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL; ?>">
	<?php endif; ?>

    <?php if ($title) {
    ?>
    	<i class="fa fa-<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i>
        <h4><?php echo $title; ?></h4>
    <?php
} ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
    <?php if ($linkURL) : ?>
		</a>
	<?php endif; ?>
</div>
