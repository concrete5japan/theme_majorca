<?php defined('C5_EXECUTE') or die('Access Denied.');
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
?>

<script>
	$(document).ready(function(){
		$(function(){
			var $gallery = $('.lightbox-image a').simpleLightbox({
				captionsData: 'alt',
				showCounter: false,
				loop: false
			});
		});
	});
</script>

<div class="lightbox-image">
<?php
if (is_object($f) && $f->getFileID()) {
    if ($f->getTypeObject()->isSVG()) {
        $tag = new \HtmlObject\Image();
        $tag->src($f->getRelativePath());
        $tag->addClass('ccm-svg');
    } elseif ($maxWidth > 0 || $maxHeight > 0) {
        $im = $app->make('helper/image');
        $thumb = $im->getThumbnail($f, $maxWidth, $maxHeight, $cropImage);

        $tag = new \HtmlObject\Image();
        $tag->src($thumb->src)->width($thumb->width)->height($thumb->height);
    } else {
        $image = $app->make('html/image', [$f]);
        $tag = $image->getTag();
    }

    $tag->addClass('link-image bID-' . $bID);

    if ($altText) {
        $tag->alt(h($altText));
    } else {
        $tag->alt(h($f->getTitle()));
    }

    if ($title) {
        $tag->title(h($title));
    }

        echo '<a href="' . $f->getRelativePath() . '">';

    echo $tag;

        echo '</a><i class="fa fa-plus-circle" aria-hidden="true"></i>';

} elseif ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Image Block.'); ?></div>
<?php
}

if (is_object($f) && is_object($foS)) {
    if (($maxWidth > 0 || $maxHeight > 0) && !$f->getTypeObject()->isSVG() && !$foS->getTypeObject()->isSVG()) { ?>
    <script>
    $(function() {
        $('.bID-<?php echo $bID; ?>')
            .mouseover(function(){$(this).attr("src", '<?php echo $imgPaths["hover"]; ?>');})
            .mouseout(function(){$(this).attr("src", '<?php echo $imgPaths["default"]; ?>');});
    });
    </script>
    <?php
    }
}
?>
</div>