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
} elseif($navigationType == 2) {
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

if ($slidesToShow > 4) {
	$slickslidesToShow = 4;
} else {
	$slickslidesToShow = $slidesToShow;
}

if ($slidesToShow == 1) {
	$slickCarouselItem = "single";
	$breakpointOne = 1;
	$breakpointTwo = 1;
} elseif($slidesToShow == 2) {
	$slickCarouselItem = "double";
	$breakpointOne = 2;
	$breakpointTwo = 2;
} elseif($slidesToShow == 3) {
	$slickCarouselItem = "triple";
	$breakpointOne = 3;
	$breakpointTwo = 2;
} elseif($slidesToShow == 4) {
	$slickCarouselItem = "quad";
	$breakpointOne = 3;
	$breakpointTwo = 2;
} else {
	$slickCarouselItem = "quad";
	$breakpointOne = 3;
	$breakpointTwo = 2;
}

if ($infinite == 1) {
	$slickInfinite = "true";
} else {
	$slickInfinite = "false";
}

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
			$('#carousel-item-<?php echo h($bID); ?> .carousel-item').slick({
				lazyLoad: 'ondemand',
				infinite: <?php echo $slickInfinite; ?>,
				autoplaySpeed: <?php echo $slickAutoplaySpeed; ?>,
				speed: <?php echo $slickSpeed; ?>,
				arrows: <?php echo $slickArrows; ?>,
				dots: <?php echo $slickDots; ?>,
				slidesToShow: <?php echo $slickslidesToShow; ?>,
				slidesToScroll: 1,
				autoplay: <?php echo $slickAutoStart; ?>,
				pauseOnHover: <?php echo $slickPauseOnHover; ?>,
				responsive: [{
					breakpoint: 992,
					settings: {
						slidesToShow: <?php echo $breakpointOne; ?>,
						slidesToScroll: 1,
					}
				},{
					breakpoint: 768,
					settings: {
						slidesToShow: <?php echo $breakpointTwo; ?>,
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

		$(function(){
			var $gallery = $('.lightbox-image a').simpleLightbox({
				captionsData: 'alt',
				showCounter: false,
				loop: false
			});
		});
	});
</script>

<div class="container">
	<div class="row">
		<div class="col-sm-12 majorca-slick-carousel-container">
	        <?php if(count($rows) > 0) : ?>
	        <div id="carousel-item-<?php echo h($bID); ?>" class="majorca-slick-carousel <?php echo $slickCarouselItem; ?>">
		        <div class="_row">
			        <ul class="carousel-team carousel-item">
		            <?php foreach($rows as $row) : ?>
		            <?php
			            $f = File::getByID($row['fID']);
			            if(is_object($f)) {
						$img_src = $f->getRelativePath();
						//var_dump($f->getRelativePath());
						//var_dump($f->getTitle());
						//var_dump($img_src);
						}
					?>
		                <li class="carousel-list lightbox-image">
		                	<?php //if(is_object($f)) { $img_src = $f->getRelativePath(); } ?>
					        <a href="<?php echo $img_src; ?>" title="<?php echo $row['title']; ?>">
				                <div class="carousel-image">
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
					                    print $tag;
					                    //var_dump($img_src); ?>
									<?php } ?>
									<i class="fa fa-plus-circle" aria-hidden="true"></i>
								</div>
					        </a>
		                </li>
		            <?php endforeach; ?>
		        	</ul>
		        </div>
	        <?php else : ?>
	        <div class="slick-image-slider-placeholder">
	            <p><?php echo t('No Slides Entered.'); ?></p>
	        </div>
	        <?php endif; ?>
	        </div>
		</div>
    </div>
</div>
<?php
} ?>
