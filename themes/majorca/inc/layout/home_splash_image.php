<?php
defined('C5_EXECUTE') or die("Access Denied.");

$fID = Config::get('app.theme_majorca.maj_splash_image');
$splashSkipButton = Config::get('app.theme_majorca.maj_splash_skip_button');
$splashHeading = Config::get('app.theme_majorca.maj_splash_heading');
$splashCaption = Config::get('app.theme_majorca.maj_splash_caption');
$splashButtonText = Config::get('app.theme_majorca.maj_splash_button_text');

$splashImage = \File::getByID($fID);

if ($splashButtonText) {
	$splashButtonText;
} else {
	$splashButtonText = 'View contents';
}

$noImage = $view->getThemePath(). '/img/empty_image.png';
?>

	<?php if ($c->isEditMode()) {
    //$loc = Localization::getInstance();
    //$loc->pushActiveContext(Localization::CONTEXT_UI);
    ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <i style="font-size:40px; margin:20px 0; display:block;" class="fa fa-picture-o" aria-hidden="true"></i>
        <div style="padding: 40px 0px 40px 0px">
	        <?php echo t('Splash Image disabled in edit mode.')?><br><?php echo t('Please edit with theme option.')?>
        </div>
    </div>
    <?php
    //$loc->popActiveContext();
	} else {
    ?>
    	<?php if ($splashSkipButton): ?>
		<script>
			$(function(){
				var top_flg = false;

				if ( navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPad') > 0 || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
					$(function() {
						$('.start-scroll').bind('click', function(event) {
							var $anchor = $(this);
							top_flg = true;
							$('html, body').stop().animate({
								scrollTop : $($anchor.attr('href')).offset().top
							}, 1500, 'easeInOutExpo', function() {
								$('html, body').stop().animate({
									//scrollTop : 0
								}, 0, function() {
									//$('.splash-container').css('display', 'none');
								});

							});

							event.preventDefault();
						});
					});

				} else {

					$(function() {
						$('.start-scroll').bind('click', function(event) {
							var $anchor = $(this);
							top_flg = true;
							$('html, body').stop().animate({
								scrollTop : $($anchor.attr('href')).offset().top
							}, 1500, 'easeInOutExpo', function() {
								$('html, body').stop().animate({
									//scrollTop : 0
								}, 0, function() {
									//$('.splash-container').css('display', 'none');
								});

							});

							event.preventDefault();
						});
					});
				}

				var header_area = $('.header-container'),
				offset = header_area.offset();
				//var top_flg = false;
				if ( !offset === false ) {
					$(window).scroll(function () {
						if($(window).scrollTop() > offset.top) {
							if (top_flg == false) {
			                		top_flg = true;
									$('html, body').stop().animate({
										//scrollTop : 0
									}, 0, function() {
										$('.splash-container').animate({
											//opacity : 0
										}, 0
									);
									//$('.splash-container').css('display', 'none');
								});
							};
						};
					});
				};

			});
		</script>
		<?php endif; ?>
		<?php if ($splashImage): ?>
		<style>
			.image-wrapper:before {
				background: url('<?php echo h($splashImage->getURL()); ?>');
				background-position: center center;
				background-repeat: no-repeat;
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
				background-size: cover;
				/*background-attachment: fixed;*/
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				height: 100vh;
				padding: 0;
				content: '';
				z-index: -1;
				overflow: hidden;
			}
		</style>
		<?php endif; ?>

				<div class="splash-container">
					<?php if ($splashImage): ?>
					<div class="image-wrapper"></div>
					<?php else: ?>
					<div class="image-wrapper">
						<img src="<?php echo $view->getThemePath()?>/img/empty_image.png" alt="Empty Image">
						<p class="not-select"><?php echo t('No Image Files Selected.'); ?></p>
					</div>
					<?php endif; ?>
					<?php if ($splashHeading || $splashCaption || $splashSkipButton): ?>
					<div class="cover-wrapper">
						<div class="cover-container">
							<?php if ($splashHeading): ?>
							<div class="splash-heading">
								<?php echo h($splashHeading); ?>
							</div>
							<?php endif; ?>
							<?php if ($splashCaption): ?>
							<div class="splash-caption">
								<?php echo h($splashCaption); ?>
							</div>
							<?php endif; ?>
							<?php if ($splashSkipButton): ?>
							<div class="start-scroll-btn">
								<a class="start-scroll" href="#header-content"><p><?php echo t($splashButtonText); ?></p><p><?php echo t('scroll'); ?><i class="fa fa-angle-down icon-arrow" aria-hidden="true"></i></p></a>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
	<?php } ?>