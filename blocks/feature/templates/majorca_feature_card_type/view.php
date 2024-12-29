<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
/*
if ($linkURL) {
    $title = '<a href="' . $linkURL . '"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>' . $title . '</a>';
}
*/
?>
<div class="majorca-feature-card">
	<?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL ?>">
	<?php else: ?>
		<span>
	<?php endif; ?>
	<i class="<?php echo $icon ?>" aria-hidden="true"></i>
    <?php if ($title) {
    ?>
    	<div class="card-container">
        <h4><?php echo $title ?></h4>

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