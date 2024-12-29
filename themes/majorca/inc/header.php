<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('inc/header_top.php');

$chooseHeaderLayout = Config::get('app.theme_majorca.maj_header_layout');
$mobileNavPosition = Config::get('app.theme_majorca.maj_mobile_nav_position');
$headerDarkColor = Config::get('app.theme_majorca.maj_header_dark_color');
$headerColor = '';

if ($mobileNavPosition == '') {
	$navPosition = 'left';
} else {
	$navPosition = $mobileNavPosition;
}

if ($chooseHeaderLayout == '') {
	$headerLayout = 'default';
} else {
	$headerLayout = $chooseHeaderLayout;
}

if ($headerDarkColor == 1) {
	$headerColor = ' header-dark-color';
}

?>
				<!-- Header -->
				<header id="header-content" class="header-container toggle-label-<?php echo $navPosition; ?><?php echo $headerColor; ?>">
				<?php  $this->inc('inc/layout/header_' .$headerLayout. '.php'); ?>
