<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$nh = $app->make('helper/navigation');
//$previousLinkURL = is_object($previousCollection) ? $nh->getLinkToCollection($previousCollection) : '';
//$parentLinkURL = is_object($parentCollection) ? $nh->getLinkToCollection($parentCollection) : '';
//$nextLinkURL = is_object($nextCollection) ? $nh->getLinkToCollection($nextCollection) : '';
//$previousLinkText = is_object($previousCollection) ? $previousCollection->getCollectionName() : '';
//$nextLinkText = is_object($nextCollection) ? $nextCollection->getCollectionName() : '';
//$parentLinkText = is_object($parentCollection) ? $parentCollection->getCollectionName() : '';
?>

<?php if ($previousLinkURL || $nextLinkURL || $parentLinkText): ?>

<div class="contents-next-previous-wrapper">
	<div class="contents-previous-container">
    <?php if ($previousLabel && $previousLinkURL != ''): ?>
	    <div class="contents-next-previous-header">
	        <h5><?php echo $previousLabel ?></h5>
	    </div>
    <?php endif; ?>

    <?php if ($previousLinkText): ?>
		<p class="contents-next-previous-previous-link">
			<?php echo $previousLinkURL ? '<a href="' . $previousLinkURL . '">' . $previousLinkText . '</a>' : '' ?>
	 	</p>
	<?php endif; ?>
	</div>

	<div class="contents-top-container">
	<?php if ($parentLabel && $parentLinkURL != ''): ?>
        <div class="contents-next-previous-header">
            <h5><?php echo $parentLabel ?></h5>
        </div>
        <?php if ($parentLinkText): ?>
		<p class="contents-next-previous-parent-link">
			<?php echo $parentLinkURL ? '<a href="' . $parentLinkURL . '">' . $parentLinkText . '</a>' : '' ?>
	 	</p>
		<?php endif; ?>
    <?php endif; ?>
	</div>

	<div class="contents-next-container">
    <?php if ($nextLabel && $nextLinkURL != ''): ?>
        <div class="contents-next-previous-header">
            <h5><?php echo $nextLabel ?></h5>
        </div>
    <?php endif; ?>

    <?php if ($nextLinkText): ?>
        <p class="contents-next-previous-next-link">
            <?php echo $nextLinkURL ? '<a href="' . $nextLinkURL . '">' . $nextLinkText . '</a>' : '' ?>
        </p>
    <?php endif; ?>
    </div>

</div>

<?php endif; ?>
