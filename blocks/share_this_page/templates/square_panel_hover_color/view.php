<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div class="majorca-share-this-page square-panel hover-color-bg">
    <ul class="list-inline">
    <?php foreach ($selected as $service) { ?>
        <li class="<?php echo h($service->getIcon()); ?>">
            <a href="<?php echo h($service->getServiceLink()) ?>" target="_blank" aria-label="<?php echo h($service->getDisplayName()) ?>"><?php echo $service->getServiceIconHTML()?></a>
        </li>
    <?php } ?>
    </ul>
</div>
