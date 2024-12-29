<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
/*
if ($linkURL) {
    $title = '<a href="' . $linkURL . '"><i class="fa fa-angle-right" aria-hidden="true"></i>' . $title . '</a>';
}
*/
?>
<div class="majorca-feature-item button">
	<i class="<?php echo $icon ?>" aria-hidden="true"></i>
	<?php if (!($linkURL)) : ?>
    	<?php if ($title): ?>
    		<h4><?php echo $title ?></h4>
    	<?php endif; ?>
    <?php endif; ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
    <?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL ?>" class="btn">
			<?php if ($title) : ?>
				<p><?php echo $title ?></p>
			<?php else: ?>
				<p>Submit</p>
			<?php endif; ?>
		</a>
	<?php endif; ?>
</div>