<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$nh = $app->make('helper/navigation');
//$previousLinkURL = is_object($previousCollection) ? $nh->getLinkToCollection($previousCollection) : '';
//$parentLinkURL = is_object($parentCollection) ? $nh->getLinkToCollection($parentCollection) : '';
//$nextLinkURL = is_object($nextCollection) ? $nh->getLinkToCollection($nextCollection) : '';
?>

<?php if ($previousLinkURL || $nextLinkURL || $parentLinkText): ?>

<div class="contents-next-previous-wrapper button">
	<div class="contents-previous-container">
    <?php if ($previousLabel && $previousLinkURL != ''): ?>
	    <div class="contents-next-previous-previous-link">
	        <h5><a href="<?php echo $previousLinkURL ?>"><?php echo $previousLabel ?></a></h5>
	    </div>
    <?php else: ?>
	    <div class="contents-next-previous-previous-link">
	        <h5><a href="<?php echo $previousLinkURL ?>">Prev</a></h5>
	    </div>

    <?php endif; ?>
	</div>

	<div class="contents-top-container">
	<?php if ($parentLabel && $parentLinkURL != ''): ?>
        <div class="contents-next-previous-parent-link">
            <h5><a href="<?php echo $parentLinkURL ?>"><?php echo $parentLabel ?></a></h5>
        </div>
    <?php else: ?>
    	<div class="contents-next-previous-parent-link">
        	<h5><a href="<?php echo $parentLinkURL ?>">Parent</a></h5>
		</div>
    <?php endif; ?>
	</div>

	<div class="contents-next-container">
    <?php if ($nextLabel && $nextLinkURL != ''): ?>
        <div class="contents-next-previous-next-link">
            <h5><a href="<?php echo $nextLinkURL ?>"><?php echo $nextLabel ?></a></h5>
        </div>
    <?php else: ?>
    	<div class="contents-next-previous-next-link">
        	<h5><a href="<?php echo $nextLinkURL ?>">Next</a></h5>
		</div>
    <?php endif; ?>
    </div>

</div>

<?php endif; ?>
