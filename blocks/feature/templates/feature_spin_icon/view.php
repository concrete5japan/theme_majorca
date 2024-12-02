<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
/*
if ($linkURL) {
    $title = '<a href="' . $linkURL . '">' . $title . '</a>';
}
*/
?>
<div class="ccm-block-feature-item spin">
    <?php if ($title) {
    ?>
        <h4><?php if ($linkURL) : ?><a href="<?php echo $linkURL ?>"><?php endif; ?><i class="<?php echo $icon; ?>" aria-hidden="true"></i> <?php echo $title; ?><?php if ($linkURL) : ?></a><?php endif; ?></h4>
    <?php } ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
</div>