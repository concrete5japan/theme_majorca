<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
?>

<style>
	div.ccm-page .ccm-block-feature-item.hover-icon.feature-item-<?php echo $bID; ?> a i {
		box-shadow: 0 0 0 1px <?php echo h($colorPicker); ?>;
	}
	div.ccm-page .ccm-block-feature-item.hover-icon.feature-item-<?php echo $bID; ?> a:hover i {
		color: #fff;
		<?php $shadowColor = substr($colorPicker,4,strlen($colorPicker)-5); ?>
		box-shadow: 0 0 0 6px rgba(<?php echo $shadowColor; ?>, 0.2);
	}
</style>

<div class="ccm-block-feature-item hover-icon feature-item-<?php echo $bID; ?>">
    <?php if ($title) {
    ?>
	<h4><?php if ($linkURL) : ?><a href="<?php echo $linkURL; ?>"><?php endif; ?><i class="<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i> <?php echo $title; ?><?php if ($linkURL) : ?></a><?php endif; ?></h4>
    <?php
} ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
</div>