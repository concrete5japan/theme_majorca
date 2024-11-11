<?php  defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
$linkCount = 1;
$faqEntryCount = 1;
?>

<div class="majorca-faq-modals-container">
	<?php  if (count($rows) > 0) : ?>

	<div class="modals-nav" id="modals-nav-<?php echo $bID ?>">
		<?php foreach ($rows as $row) { ?>
		<button class="btn btn-default" role="button" data-toggle="modal" data-target=".modals-<?php echo $bID . $linkCount; ?>" aria-controls="modals-<?php echo $bID . $linkCount; ?>">
			<?php echo $row['linkTitle']; ?>
		</button>
		<?php
			++$linkCount;
		} ?>
	</div>

	<?php foreach ($rows as $row) { ?>
	<div class="modal fade modals-<?php echo $bID . $faqEntryCount; ?>" tabindex="-1" role="dialog" aria-labelledby="modals-<?php echo $bID . $faqEntryCount; ?>">

		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('Close'); ?>">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php if ($row['title']) { ?><h3 class="modal-title"><?php echo $row['title']; ?></h3><?php } ?>
				</div>
				<div class="modal-body">
						<?php  echo $row['description'] ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo t('Close'); ?></button>
				</div>
	    	</div><!-- /.modal-content -->
		</div>

	</div>
		<?php
            ++$faqEntryCount;
        } ?>


	<?php  else: ?>
		<div class="ccm-faq-block-links">
			<p><?php echo t('No Entries Entered.'); ?></p>
		</div>
	<?php  endif; ?>
</div>