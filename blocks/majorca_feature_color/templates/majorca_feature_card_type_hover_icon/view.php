<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
?>

<style>
	div.ccm-page .majorca-feature-card.hover-icon.feature-item-<?php echo $bID; ?> a i {
		box-shadow: 0 0 0 1px <?php echo h($colorPicker); ?>;
	}
	div.ccm-page .majorca-feature-card.hover-icon.feature-item-<?php echo $bID; ?> a:hover i {
		color: #fff;
		<?php $shadowColor = substr($colorPicker,4,strlen($colorPicker)-5); ?>
		box-shadow: 0 0 0 10px rgba(<?php echo $shadowColor; ?>, 0.2);
	}
</style>

<div class="majorca-feature-card hover-icon feature-item-<?php echo $bID; ?>">
	<?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL; ?>">
	<?php else: ?>
		<span>
	<?php endif; ?>
	<i class="<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i>
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