<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
?>
<div class="majorca-feature-card feature-item-<?php echo $bID; ?>">
	<?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL; ?>">
	<?php else: ?>
		<span>
	<?php endif; ?>
	<i class="fa fa-<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i>
    <?php if ($title) {
    ?>
    	<div class="card-container">
        <h4><?php echo $title; ?></h4>

	    <?php
	    if ($paragraph) {
	        echo $paragraph;
	    }
	    ?>
    	</div>
    <?php
	} ?>
	<?php if ($linkURL) : ?>
		</a>
	<?php else: ?>
		</span>
	<?php endif; ?>
</div>