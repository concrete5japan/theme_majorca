<?php
defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$th = $app->make('helper/text');
$dh = $app->make('helper/date');
$c = Page::getCurrentPage();

/**
 * This block should be used with Full Width.
*/

?>

<?php //if (!($c->isEditMode())) { ?>
<script>
	/* Shuffle & Filter */

	var Shuffle = window.Shuffle;
	var CardShuffle<?php echo $bID; ?> = function (element) {
		this.element = element;
		this.shuffle = new Shuffle(element, {
			itemSelector: '.thumbnail-grid-shuffle',
		});

		this._activeFilters = [];

		this.addFilterButtons();
		this.addSorting();
	};

	/**
	 * Shuffle uses the CustomEvent constructor to dispatch events. You can listen
	 * for them like you normally would (with jQuery for example).
	 */
	CardShuffle<?php echo $bID; ?>.prototype.addFilterButtons = function () {
		var options = document.querySelector('.shuffle-<?php echo $bID; ?>.shuffle-links ol');
		if (!options) {
			return;
		}
		var filterButtons = Array.from(options.children);

		filterButtons.forEach(function (button) {
			button.addEventListener('click', this._handleFilterClick.bind(this), false);
		}, this);
	};

	CardShuffle<?php echo $bID; ?>.prototype._handleFilterClick = function (evt) {
		var btn = evt.currentTarget;
		var isActive = btn.classList.contains('active');
		var btnGroup = btn.getAttribute('data-group');
		if (this.mode === 'additive') {
			if (isActive) {
				this._activeFilters.splice(this._activeFilters.indexOf(btnGroup));
			} else {
				this._activeFilters.push(btnGroup);
			}
			btn.classList.toggle('active');
			this.shuffle.filter(this._activeFilters);
		} else {
			this._removeActiveClassFromChildren(btn.parentNode);
			var filterGroup;
			if (isActive) {
				btn.classList.remove('active');
				filterGroup = Shuffle.ALL_ITEMS;
			} else {
				btn.classList.add('active');
				filterGroup = btnGroup;
			}
			this.shuffle.filter(filterGroup);
		}
	};

	CardShuffle<?php echo $bID; ?>.prototype._removeActiveClassFromChildren = function (parent) {
		var children = parent.children;
		for (var i = children.length - 1; i >= 0; i--) {
			children[i].classList.remove('active');
		}
	};

	CardShuffle<?php echo $bID; ?>.prototype.addSorting = function () {
		var buttonGroup = document.querySelector('.sort-<?php echo $bID; ?>.sort-options');
		if (!buttonGroup) {
			return;
		}
		buttonGroup.addEventListener('change', this._handleSortChange.bind(this));
	};

	CardShuffle<?php echo $bID; ?>.prototype._handleSortChange = function (evt) {
		var wrapper = evt.currentTarget;
		var buttons = Array.from(evt.currentTarget.children);
		buttons.forEach(function (button) {
			if (button.querySelector('input').value === evt.target.value) {
				button.classList.add('active');
			} else {
				button.classList.remove('active');
			}
		});

		var value = evt.target.value;
		var options = {};
		function sortByDate(element) {
			return element.getAttribute('data-date-created');
		}
		function sortByTitle(element) {
	    	//return element.getAttribute('data-title').toLowerCase();
			return element.getAttribute('data-title');
		}
		if (value === 'date-created') {
			options = {
				reverse: false,
				by: sortByDate,
			};
		} else if (value === 'title') {
			options = {
				by: sortByTitle,
			};
		}
		this.shuffle.sort(options);
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
		<div class="ccm-ui" style="margin: 15px 0 0";><div class="alert alert-info"><?php echo t('Please use this block with Full Width.') ?></div></div>
<?php } ?>

<div class="row no-gutter">
	<?php if($displaySortMenu): ?>
	<div class="col-sm-12 col-md-7">
	<?php else: ?>
	<div class="col-sm-12 col-md-12">
	<?php endif; ?>

		<div class="ccm-block-topic-list-flat-filter shuffle-<?php echo $bID; ?> shuffle-links">
		    <?php
		    $tt = new \Concrete\Core\Tree\Type\Topic();
		    $tree = $tt->getByID($topicTreeID);
		    if (is_object($tree)) {
		        $node = $tree->getRootTreeNodeObject();
		        if (is_object($node)) {
		            $node->populateDirectChildrenOnly();
		            ?>
		            <ol class="breadcrumb">
		            <li data-group="<?php echo t('All') ?>" <?php if (!$selectedTopicID) { ?>class="active"<?php } ?>><?php echo t('All')?></li>
		            <?php foreach ($node->getChildNodes() as $child) { ?>
		            <li data-group="<?php echo $child->getTreeNodeDisplayName()?>"><?php echo $child->getTreeNodeDisplayName()?></li>
		            <?php } ?>
		            </ol>
		        <?php } ?>
		    <?php } ?>
		</div>
	</div>
	<?php if($displaySortMenu): ?>
	<div class="col-sm-12 col-md-5">
	<?php else: ?>
	<div class="filters-none">
	<?php endif; ?>
	    <div class="filters-group">
	    	<p class="filter-label"><?php echo t('Sort') ?></p>
	    	<div class="btn-group sort-<?php echo $bID; ?> sort-options">
	    		<label class="btn active">
	    			<input type="radio" name="sort-value" value="dom" /> <?php echo t('Default') ?>
	    		</label>
	    		<label class="btn">
	    			<input type="radio" name="sort-value" value="title" /> <?php echo t('Title') ?>
	    		</label>
	    		<label class="btn">
	    			<input type="radio" name="sort-value" value="date-created" /> <?php echo t('Date Created') ?>
	    		</label>
	    	</div>
	    </div>
	</div>
</div>

<div id="shuffle-grid-<?php echo $bID; ?>" class="grid-card filters-grid">

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

		$date = $dh->date( 'Y-m-d',strtotime($page->getCollectionDatePublic()));

		$noImgSrc = $this->getThemePath(). '/img/no_image.png';
        ?>

		<div data-groups='["<?php echo t('All')?>"<?php $topics = $page->getAttribute($attributeHandle);if (isset($topics) && count($topics)) { foreach ($topics as $topic) { echo ',"' .$topic->getTreeNodeDisplayName(). '"'; ?><?php } } ?>]' data-date-created="<?php echo $date?>" data-title="<?php echo $title; ?>" class="card-item thumbnail-grid-shuffle">
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
				<div class="card-content">
					<h2 class="card-title name"><?php echo $title; ?></h2>
                    <div class="card-date number"><?php echo $date?></div>
					<?php if ($includeDescription): ?>
						<div class="ccm-block-page-list-description">
							<?php echo $description ?>
						</div>
		            <?php endif; ?>
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
