<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
/*
if ($linkURL) {
    $title = '<a href="' . $linkURL . '"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>' . $title . '</a>';
}
*/
?>
<div class="majorca-feature-item spin">
	<?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL ?>">
	<?php endif; ?>

    <?php if ($title) {
    ?>
    	<i class="<?php echo $icon ?>" aria-hidden="true"></i>
        <h4><?php echo $title ?></h4>
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