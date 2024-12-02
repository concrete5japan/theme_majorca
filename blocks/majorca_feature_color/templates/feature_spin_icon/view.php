<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
?>
<div class="ccm-block-feature-item spin feature-item-<?php echo $bID; ?>">
    <?php if ($title) {
    ?>
        <h4><?php if ($linkURL) : ?><a href="<?php echo $linkURL; ?>"><?php endif; ?><i class="<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i> <?php echo $title; ?><?php if ($linkURL) : ?></a><?php endif; ?></h4>
    <?php } ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
</div>