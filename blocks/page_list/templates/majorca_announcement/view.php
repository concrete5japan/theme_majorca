<?php
defined('C5_EXECUTE') or die("Access Denied.");

if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$th = $app->make('helper/text');
$dh = $app->make('helper/date');
$c = Page::getCurrentPage();

if ($c->isEditMode() && $controller->isBlockEmpty()) {
    ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.') ?></div>
    <?php
} else {
    ?>

    <div class="majorca-announcement-wrapper">

        <?php if (isset($pageListTitle) && $pageListTitle) {
            ?>
            <div class="majorca-announcement-header">
                <h5><?php echo h($pageListTitle) ?></h5>
            </div>
            <?php
        } ?>

        <?php if (isset($rssUrl) && $rssUrl) {
            ?>
            <a href="<?php echo $rssUrl ?>" target="_blank" class="majorca-announcement-rss-feed">
                <i class="fas fa-rss"></i>
            </a>
            <?php
        } ?>

        <ul class="majorca-announcement-pages">

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

            foreach ($pages as $page) {

                // Prepare data for each page being listed...
                //$buttonClasses = 'ccm-block-page-list-read-more';
                $entryClasses = '';
                $title = $page->getCollectionName();
                if ($page->getCollectionPointerExternalLink() != '') {
                    $url = $page->getCollectionPointerExternalLink();
                    if ($page->openCollectionPointerExternalLinkInNewWindow()) {
                        $target = '_blank';
                    }
                } else {
                    $url = $page->getCollectionLink();
                    $target = $page->getAttribute('nav_target');
                }
                $target = empty($target) ? '_self' : $target;
                $description = $page->getCollectionDescription();
                $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
                $thumbnail = false;
                if ($displayThumbnail) {
                    $thumbnail = $page->getAttribute('thumbnail');
                }
                if (is_object($thumbnail) && $includeEntryText) {
                    $entryClasses = 'ccm-block-page-list-page-entry-horizontal';
                }
				//$thumbnail = $page->getAttribute('thumbnail');

                //$date = $dh->formatDateTime($page->getCollectionDatePublic(), true);
                $date = $dh->date( t('F d, Y'),strtotime($page->getCollectionDatePublic()));
				$datetime = $dh->date('Y-m-d\TH:i:s', strtotime($page->getCollectionDatePublic()));
				$pubTime = strtotime($page->getCollectionDatePublic());
				$new = ((time() - $pubTime) < (60 * 60 * 24 * 7)) ? '<span class="new">New</span>' : '';

				//$noImgSrc = $this->getThemePath(). '/img/no_image.png';

                //Other useful page data...

                //$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();

                /* DISPLAY PAGE OWNER NAME
                 * $page_owner = UserInfo::getByID($page->getCollectionUserID());
                 * if (is_object($page_owner)) {
                 *     echo $page_owner->getUserDisplayName();
                 * }
                 */

                /* CUSTOM ATTRIBUTE EXAMPLES:
                 * $example_value = $page->getAttribute('example_attribute_handle', 'display');
                 *
                 * When you need the raw attribute value or object:
                 * $example_value = $page->getAttribute('example_attribute_handle');
                 */

                /* End data preparation. */

                /* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>

                <li class="<?php echo $entryClasses ?>">

                    <?php if ($includeEntryText) {
                        ?>
                        <div class="majorca-announcement-page-entry-text">

                            <?php if (isset($includeName) && $includeName) {
                                ?>
                                <div class="majorca-announcement-date"><time datetime="<?php echo h($datetime); ?>"><?php echo h($date); ?></time></div>

                                <div class="majorca-announcement-title">
	                                <?php if (isset($useButtonForLink) && $useButtonForLink) { ?>
										<?php echo $title ?><?php echo t($new) ?>
									<?php } else { ?>
										<a href="<?php echo $url ?>" target="<?php echo $target ?>"><?php echo $title ?></a><?php echo t($new) ?>
									<?php } ?>
                                </div>
                                 <?php if (is_object($thumbnail)) {
			                    ?>
			                    <div class="majorca-announcement-page-entry-thumbnail">
									<?php $altText = $thumbnail->getTitle(); ?>
									<?php
										$img = $app->make('html/image', ['f' => $thumbnail]);
						                $tag = $img->getTag();
						                $tag->addClass('img-responsive');
						                $tag->alt(h($altText));
									    echo $tag;
									?>
			                    </div>
			                    <?php
			                    } ?>
                                <?php
                            } ?>

                            <?php if (isset($includeDescription) && $includeDescription) {
                                ?>
                                <div class="majorca-announcement-description"><?php echo h($description) ?></div>
                                <?php
                            } ?>

                            <?php if (isset($useButtonForLink) && $useButtonForLink) {
                                ?>
                                <div class="majorca-announcement-page-entry-read-more">
                                    <a href="<?php echo h($url) ?>" target="<?php echo h($target) ?>"
                                       class="<?php echo h($buttonClasses) ?>"><?php echo h($buttonLinkText) ?></a>
                                </div>
                                <?php
                            } ?>

                        </div>
                        <?php
                    } ?>
                </li>

                <?php
            } ?>
        </ul><!-- end .ccm-block-page-list-pages -->

        <?php if (count($pages) == 0) { ?>
            <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage) ?></div>
        <?php } ?>

    </div><!-- end .ccm-block-page-list-wrapper -->


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
