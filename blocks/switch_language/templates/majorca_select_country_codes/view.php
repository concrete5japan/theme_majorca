<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$ih = $app->make('multilingual/interface/flag');
?>
<div class="majorca-switch-language">
	<div class="majorca-switch-language-label"><?php echo $label?></div>
	<ul>
		<?php foreach ($languageSections as $ml): ?>
			<li>
				<a href="<?php echo $controller->resolve_language_url($cID, $ml->getCollectionID()) ?>" title="<?php echo h($ml->getLanguageText($locale)) ?>" <?php if (is_object($defaultLocale) && $defaultLocale->getCollectionID() == $ml->getCollectionID()) { ?>class="majorca-switch-language-active"<?php } ?>><?php echo t($ml->getCountry($locale)); ?></a>
			</li>
		<?php //var_dump($ml->getLanguageText()) ?>
		<?php //echo t($ml->getCountry($locale)); ?>
		<?php endforeach; ?>
	</ul>
</div>
