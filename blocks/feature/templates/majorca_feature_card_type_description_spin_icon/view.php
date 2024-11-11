<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
//$title = h($title);
/*
if ($linkURL) {
    $title = '<a href="' . $linkURL . '">' . $title . '</a>';
}
*/
?>
<div class="majorca-feature-card-item spin">
	<?php if ($linkURL) : ?>
		<a href="<?php echo $linkURL ?>">
	<?php else: ?>
		<span>
	<?php endif; ?>
    <?php  if ($title) { ?>
        <h4><?php echo h($title)?></h4>
    	<div class="icon">
    		<i class="fa fa-<?php echo $icon?>" aria-hidden="true"></i>
    	</div>
    <?php  } ?>
    	<div class="card-body">
		<?php
		if ($paragraph) {
			echo $paragraph;
		}
	    ?>
	    </div>
	<?php if ($linkURL) : ?>
		</a>
	<?php else: ?>
		</span>
	<?php endif; ?>
</div>