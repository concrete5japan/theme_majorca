<?php  defined('C5_EXECUTE') or die("Access Denied.");
$f = $controller->getFileObject();
$fp = new Permissions($f);
if ($f && $fp->canViewFile()) {
    $c = Page::getCurrentPage();
    if ($c instanceof Page) {
        $cID = $c->getCollectionID();
    }

    ?>
	<div class="ccm-block-file<?php if ($forceDownload == 1) { ?> download-file<?php } ?>">
		<a href="<?php echo $forceDownload ? $f->getForceDownloadURL() : $f->getDownloadURL();
    ?>"><?php echo stripslashes($controller->getLinkText()) ?></a>
	</div>

<?php
}

$c = Page::getCurrentPage();
 if (!$f && $c->isEditMode()) {
     ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty File Block.'); ?></div>
<?php
 }
