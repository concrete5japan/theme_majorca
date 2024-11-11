<?php defined('C5_EXECUTE') or die('Access Denied.');

$linkCount = 1;
$faqEntryCount = 1;
?>

<script>
$(function(){
	$('#nav-tabs-<?php echo $bID ?> li:eq(0)').addClass('active');
	$('#tab-content-<?php echo $bID ?> div:eq(0)').addClass('active in');
});
</script>

<div class="majorca-faq-tabs-container">
    <?php if (count($rows) > 0) { ?>
        <ul class="nav nav-tabs nav-justified" id="nav-tabs-<?php echo $bID ?>">
            <?php foreach ($rows as $row) { ?>
            	<li class="nav-item">
					<a href="#tab-content-<?php echo $bID . $linkCount; ?>" data-toggle="tab"><?php echo $row['linkTitle']; ?></a></li>
                <?php
                ++$linkCount;
            } ?>
        </ul>
        <div class="tab-content" id="tab-content-<?php echo $bID ?>">
            <?php foreach ($rows as $row) { ?>
	            <div class="tab-pane fade" id="tab-content-<?php echo $bID . $faqEntryCount; ?>">
	                <?php if ($row['title']) { ?><h3><?php echo $row['title']; ?></h3><?php } ?>
					<?php echo $row['description']; ?>
	            </div>
            <?php
                ++$faqEntryCount;
            } ?>
        </div>
    <?php
    } else {
    ?>
        <div class="ccm-faq-block-links">
            <p><?php echo t('No Entries Entered.'); ?></p>
        </div>
    <?php
    }
    ?>
</div>
