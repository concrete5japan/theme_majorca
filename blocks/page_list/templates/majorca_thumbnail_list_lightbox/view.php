<?php
defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$th = $app->make('helper/text');
$dh = $app->make('helper/date');
$c = Page::getCurrentPage();
?>

<script>
	$(document).ready(function(){
		$(function() {
			var $gallery = $('.lightbox-pagelist a').simpleLightbox({
				captionsData: 'alt',
				showCounter: false,
				loop: false
			});
		});
	});
</script>

<div class="majorca-thumbnail-list-wrapper">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="majorca-thumbnail-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php endif; ?>

	<ul class="majorca-thumbnail-list-container">
	    <?php foreach ($pages as $page):

	        $title = $th->entities($page->getCollectionName());
	        $url = $nh->getLinkToCollection($page);
	        $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
	        $target = empty($target) ? '_self' : $target;
	        $thumbnail = $page->getAttribute('thumbnail');
/*
	        $hoverLinkText = $title;
	        $description = $page->getCollectionDescription();
	        $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
	        $description = $th->entities($description);
	        if ($useButtonForLink) {
	            $hoverLinkText = $buttonLinkText;
	        }
	        $date = $dh->date( 'Y-m-d',strtotime($page->getCollectionDatePublic()));
*/

			$noImgSrc = $this->getThemePath(). '/img/no_image.png';
	        ?>

			<li class="majorca-thumbnail-list-item lightbox-pagelist">
				<?php if (is_object($thumbnail)): ?>
				<?php $img_src = $thumbnail->getRelativePath(); ?>
				<a href="<?php echo $img_src ?>" target="<?php echo $target ?>">
	        		<div class="majorca-thumbnail-list-thumbnail">
		                <?php $altText = $thumbnail->getTitle(); ?>
		                <?php
		                $img = $app->make('html/image', array($thumbnail));
		                $tag = $img->getTag();
		                $tag->addClass('img-responsive');
		                $tag->alt(h($altText));
					    echo $tag;
		                ?>
					    <i class="fa fa-plus-circle" aria-hidden="true"></i>
	            	</div>
	            </a>
	            <?php else: ?>
	                <img src="<?php echo $noImgSrc; ?>" alt="No Image" class="img-responsive">
				<?php endif; ?>
			</li>

		<?php endforeach; ?>
	</ul>
    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage)?></div>
    <?php endif;?>

</div>

<!--
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
-->

<?php if ($c->isEditMode() && $controller->isBlockEmpty()): ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php endif; ?>