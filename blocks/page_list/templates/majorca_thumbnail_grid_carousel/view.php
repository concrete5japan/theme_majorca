<?php
defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$th = $app->make('helper/text');
$c = Page::getCurrentPage();
?>

<script>
	$(document).ready(function(){
		$(function() {
			$('#carousel-thumbnail-grid-<?php echo $bID ?>').slick({
				lazyLoad: 'ondemand',
				infinite: true,
				dots: true,
				slidesToShow: 4,
				slidesToScroll: 1,
				//centerMode: true,
				//centerPadding: '70px',
				autoplay: true,
				responsive: [{
					breakpoint: 992,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
					}
				},{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1,
					}
				},{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
					}
				}]
			});

		});
	});
</script>

<div class="carousel-thumbnail-grid-wrapper">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="carousel-thumbnail-grid-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php endif; ?>


	<div class="carousel-thumbnail-grid" id="carousel-thumbnail-grid-<?php echo $bID ?>">

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

		$noImgSrc = $this->getThemePath(). '/img/no_image.png';
        ?>

        <div class="carousel-grid-item">
            <div class="carousel-grid">
                <a href="<?php echo $url ?>" target="<?php echo $target ?>">
	            <div class="card-thumb">

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
					<span class="more-content"><?php echo t('Read More'); ?></span>
				</div>
                </a>
            </div>
        </div>

	<?php endforeach; ?>
	</div>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage)?></div>
    <?php endif;?>

</div>

<!--
<?php //if ($showPagination): ?>
    <?php //echo $pagination;?>
<?php //endif; ?>
-->

<?php if ($c->isEditMode() && $controller->isBlockEmpty()): ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.')?></div>
<?php endif; ?>