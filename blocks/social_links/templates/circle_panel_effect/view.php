<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div id="ccm-block-social-links<?php echo $bID?>" class="majorca-social-links circle-panel expand">
    <ul class="list-inline">
    <?php foreach($links as $link) {
        $service = $link->getServiceObject();
        ?>
        <li><a target="_blank" href="<?php echo h($link->getURL()); ?>"><?php echo $service->getServiceIconHTML(); ?></a></li>
    <?php } ?>
    </ul>
</div>