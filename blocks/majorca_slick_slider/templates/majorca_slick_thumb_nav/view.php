<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$navigationTypeText = ($navigationType == 0) ? 'arrows' : 'pages';
$c = Page::getCurrentPage();

if ($navigationType == 0) {
	$slickArrows = "true";
	$slickDots = "false";
} elseif($navigationType == 1) {
	$slickArrows = "false";
	$slickDots = "true";
} else {
	$slickArrows = "true";
	$slickDots = "true";
}

if ($noAnimate == 1) {
	$slickAutoStart = "false";
} else {
	$slickAutoStart = "true";
}

if ($pause == 1) {
	$slickPauseOnHover = "true";
} else {
	$slickPauseOnHover = "false";
}

$slickSpeed = $speed;
$slickAutoplaySpeed = $timeout;

if ($infinite == 1) {
	$slickInfinite = "true";
} else {
	$slickInfinite = "false";
}

if ($fade == 1) {
	$slickFade = "true";
} else {
	$slickFade = "false";
}

if ($centerModeThumbNav == 1) {
	$slickCenterMode = "true";
} else {
	$slickCenterMode = "false";
}

$slickThumbNavSlides = $slidesToShow;

if ($c->isEditMode()) {
    //$loc = Localization::getInstance();
    //$loc->pushActiveContext(Localization::CONTEXT_UI);
    ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <i style="font-size:40px; margin-bottom:20px; display:block;" class="fa fa-picture-o" aria-hidden="true"></i>
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Image Slider disabled in edit mode.')?>
			<div style="margin-top: 15px; font-size:9px;">
				<i class="fa fa-circle" aria-hidden="true"></i>
				<?php if (count($rows) > 0) { ?>
					<?php foreach (array_slice($rows, 1) as $row) { ?>
						<i class="fa fa-circle-thin" aria-hidden="true"></i>
						<?php }
					}
				?>
			</div>
        </div>
    </div>
    <?php
    //$loc->popActiveContext();
} else {
    ?>

<script>
	$(document).ready(function(){
		$(function() {
			$('.slick-image-slider-inner');

			$('#slick-image-slider-<?php echo $bID; ?>').slick({
			    lazyLoad: 'ondemand',
				infinite: <?php echo $slickInfinite; ?>,
				autoplaySpeed: <?php echo $slickAutoplaySpeed ?>,
		    	speed: <?php echo $slickSpeed ?>,
		    	//arrows: <?php echo $slickArrows ?>,
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: <?php echo $slickFade; ?>,
				autoplay: <?php echo $slickAutoStart; ?>,
		    	pauseOnHover: <?php echo $slickPauseOnHover; ?>,
				asNavFor: '.thumb-nav-<?php echo $bID; ?>',
				responsive: [{
		    	breakpoint: 480,
		    		settings: {
						centerMode: false,
					}
				}]
		     });
		     $('.thumb-nav-<?php echo $bID; ?>').slick({
		          infinite: true,
		          slidesToShow: <?php echo $slickThumbNavSlides; ?>,
		          slidesToScroll: 1,
		          asNavFor: '#slick-image-slider-<?php echo $bID ?>',
		          centerMode: <?php echo $slickCenterMode; ?>,
				  centerPadding:'0px',
				  arrows: <?php echo $slickArrows ?>,
		          dots: <?php echo $slickDots ?>,
		          focusOnSelect: true,
		     });
		});
	});
</script>

<div class="slick-image-slider-container slick-block-image-slider-<?php echo $navigationTypeText; ?>" >
    <div class="slick-image-slider">
        <div class="slick-image-slider-inner">

        <?php if(count($rows) > 0) : ?>
        <ul class="slider fade-item" id="slick-image-slider-<?php echo $bID; ?>">
            <?php foreach($rows as $row) : ?>
                <li>
                <?php if($row['linkURL']) { ?>
                    <a href="<?php echo $row['linkURL'] ?>">
                <?php } ?>
                <?php
                $f = File::getByID($row['fID'])
                ?>
                <?php if(is_object($f)) {
                    $tag = $app->make('html/image', ['f' => $f])->getTag();
                    if($row['title']) {
                    	$tag->alt($row['title']);
                    }else{
                    	$tag->alt(h($f->getTitle()));
                    }
                    print $tag; ?>
                <?php } ?>
                <?php if($row['linkURL']) { ?>
                    </a>
                <?php } ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <ul class="slider slider-nav thumb-nav-<?php echo $bID; ?>">
            <?php foreach($rows as $row) : ?>
                <li>
                <?php
                $f = File::getByID($row['fID'])
                ?>
                <?php if(is_object($f)) {
                    $tag = $app->make('html/image', ['f' => $f])->getTag();
                    print $tag; ?>
                <?php } ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <div class="slick-image-slider-placeholder">
            <p><?php echo t('No Slides Entered.'); ?></p>
        </div>
        <?php endif; ?>
        </div>

    </div>
</div>

<?php
} ?>
