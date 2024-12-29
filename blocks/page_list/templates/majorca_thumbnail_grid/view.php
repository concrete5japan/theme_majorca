<?php
defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$th = $app->make('helper/text');
$dh = $app->make('helper/date');
$c = Page::getCurrentPage();
?>

<div class="ccm-block-page-list-thumbnail-grid-wrapper">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="majorca-thumbnail-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php endif; ?>

    <?php foreach ($pages as $page):

        $title = $th->entities($page->getCollectionName());
        $url = $nh->getLinkToCollection($page);
        $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
        $target = empty($target) ? '_self' : $target;
        $thumbnail = $page->getAttribute('thumbnail');
        $hoverLinkText = $title;
        $description = $page->getCollectionDescription();
        $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
        $description = $th->entities($description);
        if ($useButtonForLink) {
            $hoverLinkText = $buttonLinkText;
        }

		$date = $dh->date( 'Y-m-d',strtotime($page->getCollectionDatePublic()));

		$noImgSrc = $this->getThemePath(). '/img/no_image.png';
        ?>

		<div class="ccm-block-page-list-page-entry-grid-item">
        	<div class="ccm-block-page-list-page-entry-grid-thumbnail">
                <a href="<?php echo $url ?>" target="<?php echo $target ?>">
                <?php if (is_object($thumbnail)): ?>
                <?php $altText = $thumbnail->getTitle(); ?>
                <?php
                $img = $app->make('html/image', ['f' => $thumbnail]);
                $tag = $img->getTag();
                $tag->addClass('img-responsive');
                $tag->alt(h($altText));
			    echo $tag;
                ?>
                <?php else: ?>
                	<img src="<?php echo $noImgSrc; ?>" alt="No Image" class="img-responsive">
				<?php endif; ?>
                    <div class="ccm-block-page-list-page-entry-grid-thumbnail-hover">
                        <div class="ccm-block-page-list-page-entry-grid-thumbnail-title-wrapper">
                        <div class="ccm-block-page-list-page-entry-grid-thumbnail-title">
                            <i class="ccm-block-page-list-page-entry-grid-thumbnail-icon" aria-hidden="true"></i>
                            <?php echo $hoverLinkText?>
                        </div>
                        </div>
                    </div>
                </a>

                <?php if ($useButtonForLink) {
    ?>
                <div class="ccm-block-page-list-title majorca-list-title">
                    <?php echo $title;
    ?>
                </div>
                <?php
} ?>

				<div class="ccm-block-page-list-title majorca-list-title">
					<?php echo $title; ?>
                </div>
                <?php if ($includeDate): ?>
				<div class="ccm-block-page-list-date">
					<?php echo $date?>
				</div>
                <?php endif; ?>

                <?php if ($includeDescription): ?>
				<div class="ccm-block-page-list-description">
					<?php echo $description ?>
				</div>
                <?php endif; ?>

            </div>
		</div>

	<?php endforeach; ?>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage)?></div>
    <?php endif;?>

</div>

<?php if ($showPagination): ?>
    <?php //echo $pagination;?>
    <div class="majorca-pagination">
    <?php
    $pagination = $list->getPagination();
    if ($pagination->getTotalPages() > 1) {
        $options = array(
            'prev_message'        => 'Previous',
            'next_message'        => 'Next',
        );
        echo $pagination->renderDefaultView($options);
    }
    ?>
    </div>
<?php endif; ?>

<?php if ($c->isEditMode() && $controller->isBlockEmpty()): ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php endif; ?>