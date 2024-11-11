<?php  defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
$linkCount = 1;
?>

<script>
$(function(){
	$('#collapse-<?php echo $bID . $linkCount; ?>:eq(0)').addClass('in');
});
</script>

<div class="majorca-faq-collapse-container">
	<div class="panel-group" id="accordion-<?php echo $bID ?>">
	<?php if (count($rows) > 0) : ?>

		<?php foreach ($rows as $row) : ?>
		<div class="panel panel-default" id="panel-<?php echo $bID ?>">
			<div class="panel-heading" id="panel-heading-<?php echo $bID . $linkCount; ?>">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-<?php echo $bID ?>" href="#collapse-<?php echo $bID . $linkCount; ?>" aria-controls="collapse-<?php echo $bID . $linkCount; ?>"><?php echo $row['linkTitle']; ?></a>
			    </h4>
			</div>
			<div id="collapse-<?php echo $bID . $linkCount; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-heading-<?php echo $bID . $linkCount; ?>">
				<div class="panel-body">
					<?php if ($row['title']) { ?><h3><?php echo $row['title']; ?></h3><?php } ?>
					<?php echo $row['description'] ?>
			       </div>
			</div>
		</div>
		<?php ++$linkCount; ?>
		<?php  endforeach; ?>

	<?php else: ?>
		<div class="ccm-faq-block-links">
			<p><?php  echo t('No Entries Entered.'); ?></p>
		</div>
	<?php  endif; ?>
	</div>
</div>