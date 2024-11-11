<?php  defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
$linkCount = 1;
$faqEntryCount = 1;
?>

<div class="majorca-faq-collapse-container">
	<div>
	<?php  if (count($rows) > 0) : ?>

		<div class="collapse-nav" id="collapse-nav-<?php echo $bID ?>">
			<?php foreach ($rows as $row) { ?>
				<button class="btn btn-default" role="button" data-toggle="collapse" data-target="#collapse-<?php echo $bID . $linkCount; ?>" aria-controls="collapse-<?php echo $bID . $linkCount; ?>">
					<?php echo $row['linkTitle']; ?>
				</button>
            <?php
                ++$linkCount;
			} ?>
		</div>

		<?php foreach ($rows as $row) { ?>
		<div id="collapse-<?php echo $bID . $faqEntryCount; ?>" class="collapse">
			<div class="_well">
				<?php if ($row['title']) { ?><h3><?php echo $row['title']; ?></h3><?php } ?>
				<?php  echo $row['description'] ?>
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
</div>