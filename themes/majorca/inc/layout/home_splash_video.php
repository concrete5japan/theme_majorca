<?php
defined('C5_EXECUTE') or die("Access Denied.");

$mp4fID = Config::get('app.theme_majorca.maj_splash_video_mp4');
$webmfID = Config::get('app.theme_majorca.maj_splash_video_webm');
$oggfID = Config::get('app.theme_majorca.maj_splash_video_ogg');
$postefID = Config::get('app.theme_majorca.maj_splash_video_poster');
$splashVideoPlay = Config::get('app.theme_majorca.maj_splash_video_play');
$splashVideoPreload = Config::get('app.theme_majorca.maj_splash_video_preload');
$splashVideoLoop = Config::get('app.theme_majorca.maj_splash_video_loop');
$splashSkipButton = Config::get('app.theme_majorca.maj_splash_skip_button');
$splashHeading = Config::get('app.theme_majorca.maj_splash_heading');
$splashCaption = Config::get('app.theme_majorca.maj_splash_caption');
$splashButtonText = Config::get('app.theme_majorca.maj_splash_button_text');

$splashVideoMp4 = \File::getByID($mp4fID);
$splashVideoWebm = \File::getByID($webmfID);
$splashVideoOgg = \File::getByID($oggfID);
$splashVideoPoster = \File::getByID($postefID);

if ($splashVideoPlay == 1) {
	$videoAutoStart = ' autoplay';
	$playButton = 'pause';
} else {
	$playButton = 'play';
}

if ($splashVideoLoop == 1) {
	$videoLoop = ' loop';
}

if ($splashButtonText) {
	$splashButtonText;
} else {
	$splashButtonText = 'View contents';
}

function ua_discriminant() {
	$ua = \Request::getInstance()->server->get('HTTP_USER_AGENT', '');
	$ua_list = array('iPhone','iPad','iPod','Android');
	foreach ($ua_list as $ua_discriminant) {
		if (strpos($ua, $ua_discriminant) !== false) {
			return true;
		}
	}
	//var_dump($ua);
	return false;
}

if (ua_discriminant() == true) {
	$playButton = 'play';
}
?>

	<?php if ($c->isEditMode()) {
    //$loc = Localization::getInstance();
    //$loc->pushActiveContext(Localization::CONTEXT_UI);
    ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : '' ?><?php echo isset($height) ? "height: $height;" : '' ?>">
        <i style="font-size:40px; margin:20px 0; display:block;" class="fa fa-film" aria-hidden="true"></i>
        <div style="padding: 40px 0px 40px 0px">
	        <?php echo t('Splash Video disabled in edit mode.')?><br><?php echo t('Please edit with theme option.')?>
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
		<?php if ($splashVideoMp4 || $splashVideoWebm || $splashVideoOgg): ?>
		<script>
			$(function() {
				$('.play-button').click(function() {
					if($('#splash-video')[0].paused) {
						$('#splash-video')[0].play();
						$(this).addClass('pause');
						$(this).removeClass('play');
						$(this).text('pause');
			        } else {
						$('#splash-video')[0].pause();
						$(this).addClass('play');
						$(this).removeClass('pause');
						$(this).text('play');
			        }
			    });
			});
		</script>
		<?php endif; ?>

				<div class="splash-container">
					<div class="video-wrapper">
						<?php if ($splashVideoMp4 || $splashVideoWebm || $splashVideoOgg): ?>
						<video id="splash-video" <?php echo $splashVideoPoster ? 'poster="' . h($splashVideoPoster->getURL()) . '"' : '' ?> webkit-playsinline playsinline<?php echo h($videoAutoStart); ?><?php echo h($videoLoop); ?> onclick="this.play()"<?php if ($splashVideoPreload == 1) { echo ' preload="none"'; } ?>>
							<?php if ($splashVideoMp4) { ?>
					        <source src="<?php echo h($splashVideoMp4->getURL()); ?>" type="video/mp4">
					        <?php } if ($splashVideoWebm) { ?>
					        <source src="<?php echo h($splashVideoWebm->getURL()); ?>" type="video/webm">
					        <?php } if ($splashVideoOgg) { ?>
					        <source src="<?php echo h($splashVideoOgg->getURL()); ?>" type="video/ogg">
					        <?php } echo t("Your browser doesn't support the HTML5 video tag."); ?>
						</video>
						<?php else: ?>
						<img src="<?php echo $view->getThemePath()?>/img/empty_video.png" alt="Empty Video">
						<p class="not-select"><?php echo t('No Video Files Selected.'); ?></p>
						<?php endif; ?>
					</div>
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
					<?php if ($splashVideoMp4 || $splashVideoWebm || $splashVideoOgg): ?><a class="play-button <?php echo h($playButton); ?>"><?php echo t($playButton); ?></a><?php endif; ?>
				</div>
	<?php } ?>