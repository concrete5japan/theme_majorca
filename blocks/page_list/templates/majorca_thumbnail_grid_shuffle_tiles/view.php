<?php
defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$th = $app->make('helper/text');
$c = Page::getCurrentPage();

/**
 * This template should be used with Full Width.
*/

?>

<?php //if (!($c->isEditMode())) { ?>
<script>
	var Shuffle = window.Shuffle;
	var CardShuffle<?php echo $bID; ?> = function (element) {
		this.element = element;

		this.shuffle = new Shuffle(element, {
			itemSelector: '.thumbnail-grid-shuffle',
		});
	};


	$(document).ready(function(){
		$(function() {
			Shuffle.options = {
			  buffer: 0,
			  easing: 'cubic-bezier(0.4, 0.0, 0.2, 1)',
			  gutterWidth: 0,
			  speed: 700,
			};
		});
	});

	document.addEventListener('DOMContentLoaded', function () {
		window.CardShuffle<?php echo $bID; ?> = new CardShuffle<?php echo $bID; ?>(document.getElementById('shuffle-grid-<?php echo $bID; ?>'));
	});
</script>
<?php //} ?>

<?php if ($c->isEditMode()) {?>
		<div class="ccm-ui" style="margin: 15px 0 0";><div class="alert alert-info"><?php echo t('Please use this template with Full Width.') ?></div></div>
<?php } ?>

<div id="shuffle-grid-<?php echo $bID; ?>" class="grid-tiles">
	<?php if (isset($pageListTitle) && $pageListTitle): ?>
	<div class="ccm-block-page-list-header">
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

		$noImgSrc = $this->getThemePath(). '/img/no_image.png';
		?>
		<div class="tile-item thumbnail-grid-shuffle">
			<a href="<?php echo $url ?>" target="<?php echo $target ?>">
				<div class="card-thumb">

					<?php if (is_object($thumbnail)): ?>
						<?php $altText = $thumbnail->getTitle(); ?>
						<?php
							$img = $app->make('html/image', array($thumbnail));
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