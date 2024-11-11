<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div class="majorca-share-this-page circle-panel spin">
    <ul class="list-inline">
    <?php foreach ($selected as $service) { ?>
        <li>
            <a href="<?php echo h($service->getServiceLink()) ?>" target="_blank" aria-label="<?php echo h($service->getDisplayName()) ?>"><?php echo $service->getServiceIconHTML()?></a>
        </li>
    <?php } ?>
    </ul>
</div>
