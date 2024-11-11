<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	$a = $b->getBlockAreaObject();

	$container = $formatter->getLayoutContainerHtmlObject();
	$id = $controller->getIdentifier();
?>
	<div class="row split-area">
    <?php
	foreach($columns as $column) {
		$html = $column->getColumnHtmlObject();
		$container->appendChild($html);
	}
	print $container;
	?>
	</div>