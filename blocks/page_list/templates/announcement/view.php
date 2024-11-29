<?php
defined('C5_EXECUTE') or die("Access Denied.");

if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$th = $app->make('helper/text');
$dh = $app->make('helper/date');
$c = Page::getCurrentPage();
?>

<?php if ($c->isEditMode() && $controller->isBlockEmpty()) {
    ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php
} else {
    ?>

<div class="announcement-page-list-wrapper">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="announcement-page-list-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php endif;
    ?>

    <?php if (isset($rssUrl) && $rssUrl): ?>
        <a href="<?php echo $rssUrl ?>" target="_blank" class="announcement-page-list-rss-feed"><i class="fa fa-rss"></i></a>
    <?php endif;
    ?>

    <ul class="announcement-page-list-pages">

    <?php

    $includeEntryText = false;
    if (
        (isset($includeName) && $includeName)
        ||
        (isset($includeDescription) && $includeDescription)
        ||
        (isset($useButtonForLink) && $useButtonForLink)
    ) {
        $includeEntryText = true;
    }

    foreach ($pages as $page):

        // Prepare data for each page being listed...
        $buttonClasses = 'announcement-page-list-read-more';
	    $entryClasses = 'announcement-page-list-page-entry';
	    $title = $th->entities($page->getCollectionName());
	    $url = ($page->getCollectionPointerExternalLink() != '') ? $page->getCollectionPointerExternalLink() : $nh->getLinkToCollection($page);
	    $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
	    $target = empty($target) ? '_self' : $target;
	    $description = $page->getCollectionDescription();
	    $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
	    $description = $th->entities($description);
	    $thumbnail = false;
	    if ($displayThumbnail) {
	        $thumbnail = $page->getAttribute('thumbnail');
	    }
	    if (is_object($thumbnail) && $includeEntryText) {
	        $entryClasses = 'announcement-page-list-page-entry-horizontal';
	    }

	    //$date = $dh->formatDateTime($page->getCollectionDatePublic(), true);
	    $date = $dh->date( t('F d, Y'),strtotime($page->getCollectionDatePublic()));
		$datetime = $dh->date('Y-m-d\TH:i:s', strtotime($page->getCollectionDatePublic()));
		$pubTime = strtotime($page->getCollectionDatePublic());
		$new = ((time() - $pubTime) < (60 * 60 * 24 * 7)) ? '<span class="new">New</span>' : '';

        ?>

        <li class="<?php echo $entryClasses?>">
        <?php echo t($new) ?>

        <?php if (is_object($thumbnail)): ?>
        	<?php
        		$img_src = $thumbnail->getRelativePath();
        		$altText = $thumbnail->getTitle();
        	?>
            <div class="announcement-page-list-page-entry-thumbnail">
                <?php
                $img = $app->make('html/image', ['f' => $thumbnail]);
			    $tag = $img->getTag();
			    $tag->addClass('img-responsive');
			    $tag->alt(h($altText));
			    echo $tag;
			    ?>
            </div>
        <?php endif;
    ?>

        <?php if ($includeEntryText): ?>
            <div class="announcement-page-list-page-entry-text">

                <?php if (isset($includeDate) && $includeDate): ?>
                    <div class="ccm-block-page-list-date"><?php echo $date?></div>
                <?php endif;
    ?>

                <?php if (isset($includeName) && $includeName): ?>
                <div class="announcement-page-list-title">
                    <?php if (isset($useButtonForLink) && $useButtonForLink) {
    ?>
                        <?php echo $title;
    ?>
                    <?php
} else {
    ?>
                        <a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo $title ?></a>
                    <?php
}
    ?>
                </div>
                <?php endif;
    ?>

                <?php if (isset($includeDescription) && $includeDescription): ?>
                    <div class="announcement-page-list-description">
                        <?php echo $description ?>
                    </div>
                <?php endif;
    ?>

                <?php if (isset($useButtonForLink) && $useButtonForLink): ?>
                <div class="announcement-page-list-page-entry-read-more">
                    <a href="<?php echo $url?>" target="<?php echo $target?>" class="<?php echo $buttonClasses?>"><?php echo $buttonLinkText?></a>
                </div>
                <?php endif;
    ?>

                </div>
        <?php endif;
    ?>
        </li>

	<?php endforeach;
    ?>
    </ul>

    <?php if (count($pages) == 0): ?>
        <div class="announcement-page-list-no-pages"><?php echo h($noResultsMessage)?></div>
    <?php endif;
    ?>

</div><!-- end .ccm-block-page-list -->


    <?php if ($showPagination) { ?>
        <?php //echo $pagination; ?>
		<?php
			$pagination = $list->getPagination();
			if ($pagination->getTotalPages() > 1) {
				$options = array(
					'prev_message' => t('Previous'),
		            'next_message' => t('Next'),
		            'css_container_class' => 'pl-pagination pagination',
				);
				echo $pagination->renderDefaultView($options);
			}
		?>
    <?php } ?>

<?php
} ?>
