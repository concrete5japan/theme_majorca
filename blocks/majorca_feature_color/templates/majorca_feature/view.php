<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
if ($linkURL) {
    $title = '<a href="' . $linkURL . '"><i class="fas fa-angle-right" aria-hidden="true"></i>' . $title . '</a>';
}
?>
<style>
	div.ccm-page .majorca-feature-item.feature-item-<?php echo $bID; ?> a i {
		background-color: <?php echo h($colorPicker); ?>;
		    -webkit-transition: all 0.3s linear;
			-o-transition: all 0.3s linear;
    	transition: all 0.3s linear;
	}
	div.ccm-page .majorca-feature-item.feature-item-<?php echo $bID; ?> a:hover i {
		color: #fff;
		<?php $shadowColor = substr($colorPicker,4,strlen($colorPicker)-5); ?>
		background-color: rgba(<?php echo $shadowColor; ?>, 0.5);
	}
</style>

<div class="majorca-feature-item feature-item-<?php echo $bID; ?>">
    <?php if ($title) {
    ?>
    	<i class="<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i>
        <h4><?php echo $title; ?></h4>
    <?php
} ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
</div>