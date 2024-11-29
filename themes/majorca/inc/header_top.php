<?php  defined('C5_EXECUTE') or die("Access Denied.");

$loadPageTransition = Config::get('app.theme_majorca.maj_page_transition');
$loadParallaxScript = Config::get('app.theme_majorca.maj_jquery_appear');
$mobileNavPosition = Config::get('app.theme_majorca.maj_mobile_nav_position');

if ($mobileNavPosition == '') {
	$navPosition = 'left';
} else {
	$navPosition = $mobileNavPosition;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php  echo Localization::activeLanguage()?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php  echo Localization::activeLanguage()?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php  echo Localization::activeLanguage()?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php  echo Localization::activeLanguage()?>"> <!--<![endif]-->

    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php View::element('header_required', array('pageTitle' => isset($pageTitle) ? $pageTitle : ''));?>

        <link rel="stylesheet" href="<?php  echo $view->getThemePath()?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php  echo $view->getThemePath()?>/css/bootstrap.css">
        <script src="<?php echo $view->getThemePath()?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <?php if ($loadParallaxScript && (!($c->isEditMode()))) { ?>
		<script src="<?php  echo $view->getThemePath()?>/js/vendor/jquery.appear.js"></script>
		<?php } ?>
		<?php if ($loadPageTransition && (!(User::isLoggedIn()))) { ?><script>
			$(window).on('load', function(){
				//$('body').removeClass('fadeout');
				//$('.loader-container').delay(900).fadeOut(800);
				$('.loader-container').fadeOut(800);
			});
			$(window).on("beforeunload",function(e){
				$('.loader-container').fadeIn();
			});
		</script>
		<?php } ?>
        <?php echo $html->css($view->getStylesheet('main.less'))?>

    </head>
    <body id="page-content" class="<?php echo $c->getCollectionHandle(); ?><?php if (User::isLoggedIn()) { echo ' login'; } ?><?php $cp = new Permissions($c); if ($cp->canViewToolbar()) { echo ' toolbar'; } ?>">
    	<div class="<?php echo $c->getPageWrapperClass()?><?php if ($c->isEditMode()): ?> edit-mode<?php endif ?>">
	    	<?php if ($loadPageTransition && (!(User::isLoggedIn()))) {
	    		echo '<div class="loader-container"><div class="loading"><img src="' .$view->getThemePath(). '/css/img/puff_grey.svg" alt="' .t("Loading..."). '"></div></div>';
			} ?>
	    	<div id="page" class="page-container pure-container" data-effect="pure-effect-slide">
				<input type="checkbox" id="pure-toggle-<?php echo $navPosition; ?>" class="pure-toggle" data-toggle="<?php echo $navPosition; ?>"/>
				<label class="pure-toggle-label" for="pure-toggle-<?php echo $navPosition; ?>" data-toggle-label="<?php echo $navPosition; ?>"><span class="pure-toggle-icon"></span></label>
				<label class="pure-overlay" for="pure-toggle-<?php echo $navPosition; ?>" data-overlay="<?php echo $navPosition; ?>"></label>
				<a class="skip-link screen-reader-text<?php if (User::isLoggedIn()) { echo ' login'; } ?>" href="#main-content"><?php echo t('Skip to content') ?></a>


				<!--[if lt IE 8]>
					<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
				<![endif]-->
