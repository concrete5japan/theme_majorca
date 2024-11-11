<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$title = h($title);
if ($linkURL) {
    $title = '<a href="' . $linkURL . '"><i class="fa fa-angle-right" aria-hidden="true"></i>' . $title . '</a>';
}
?>
<div class="majorca-feature-item">
    <?php if ($title) {
    ?>
    	<i class="fa fa-<?php echo $icon ?>" aria-hidden="true"></i>
        <h4><?php echo $title ?></h4>
    <?php
} ?>
    <?php
    if ($paragraph) {
        echo $paragraph;
    }
    ?>
</div>