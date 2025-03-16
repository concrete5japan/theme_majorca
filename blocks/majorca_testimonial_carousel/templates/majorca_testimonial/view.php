<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$navigationTypeText = ($navigationType == 0) ? 'arrows' : 'pages';
$noAvatarSrc = $this->getBlockURL(). '/img/avatar_none.png';
$id = $controller->getIdentifier();
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
$slickslidesToShow = $slidesToShow;

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
        <i style="font-size:40px; margin-bottom:20px; display:block;" class="far fa-user-circle" aria-hidden="true"></i>
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Testmonial Carousel disabled in edit mode.')?>
			<div style="margin-top: 15px; font-size:9px;">
				<i class="fas fa-circle" aria-hidden="true"></i>
				<?php if (count($rows) > 0) { ?>
					<?php foreach (array_slice($rows, 1) as $row) { ?>
						<i class="far fa-circle" aria-hidden="true"></i>
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
<div class="container">
	<div class="row">
		<div class="col-sm-12 testimonial-carousel">
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
						slidesToShow: <?php echo $slidesToShow; ?>,
						slidesToScroll: 1,
						//centerMode: true,
						//centerPadding: '70px',
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
			});
		</script>

<?php if (count($rows) > 0) {
?>
			<div id="carousel-item-<?php echo h($bID); ?>" class="<?php echo $slickCarouselItem; ?>">
				<div class="row">
					<div class="carousel-team carousel-item">
					<?php foreach($rows as $row){
	    			?>

						<div class="majorca-testimonial-wrapper">
							<div class="majorca-testimonial">
							<?php if(intval($row['fID'])) :
								$f = \File::getByID($row['fID']); ?>
								<?php   if (is_object($f)) :
									$image = $app->make('html/image', ['f' => $f])->getTag();
									$image->alt(h($row['name']));
								?>
								<div class="majorca-testimonial-image"><?php echo $image; ?></div>
								<?php endif; ?>
							<?php else: ?>
								<div class="majorca-testimonial-image"><img src="<?php echo $noAvatarSrc; ?>" alt="No Avatar"></div>
							<?php endif; ?>

								<div class="majorca-testimonial-text">
									<div class="majorca-testimonial-name">
									<?php echo h($row['name']); ?>
	          						</div>

						        <?php if ($row['position'] && $row['company'] && $row['companyURL']): ?>
						        	<div class="majorca-testimonial-position">
						            <?php echo t('%s, <a href="%s">%s</a>', h($row['position']), $row['companyURL'], h($row['company'])); ?>
						        	</div>
						        <?php endif; ?>

						        <?php if ($row['position'] && !$row['company'] && $row['companyURL']): ?>
						            <div class="majorca-testimonial-position">
						            <?php echo t('<a href="%s">%s</a>', $row['companyURL'], h($row['position'])); ?>
						            </div>
						        <?php endif; ?>

						        <?php if ($row['position'] && $row['company'] && !$row['companyURL']): ?>
						        	<div class="majorca-testimonial-position">
						            <?php echo t('%s, %s', h($row['position']), h($row['company'])); ?>
									</div>
						        <?php endif; ?>

						        <?php if ($row['position'] && !$row['company'] && !$row['companyURL']): ?>
									<div class="majorca-testimonial-position">
									<?php echo h($row['position']); ?>
									</div>
						        <?php endif; ?>

						        <?php if ($row['paragraph']): ?>
						        	<div class="majorca-testimonial-paragraph"><?php echo h($row['paragraph']); ?></div>
						        <?php endif; ?>
								<?php if(is_array($row['socialLink'])): ?>
									<?php if(count($row['socialLink']) > 0): ?>
							        	<ul class="testimonial-sns list-inline">
							            <?php foreach($row['socialLink'] as $key => $value){
											if($value['isView'] == 1){
										 ?>
											<li><a href="<?php echo $value['url']; ?>" class="testimonial-circle-icon"><i class="fab fa-<?php echo $key ?>"></i></a></li>
											<?php } ?>
							            <?php } ?>
							        	</ul>
							        <?php endif; ?>
								<?php endif; ?>
	      						</div>
							</div>
    					</div>
	  				<?php } ?>
	  				</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{ ?>

<?php } ?>
<?php
} ?>
