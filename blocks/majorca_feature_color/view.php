<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
if ($linkURL) {
    $title = '<a href="' . $linkURL . '">' . $title . '</a>';
}
?>
<div class="ccm-block-feature-item">
    <?php if ($title) {
    ?>
        <h4><i class="<?php echo $icon; ?>" aria-hidden="true" style="background-color: <?php echo h($colorPicker); ?>"></i> <?php echo $title; ?></h4>
    <?php
} ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
</div>