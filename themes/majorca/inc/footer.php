<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

				<!-- Footer -->
				<footer class="footer-container">
					<?php
					$a = new GlobalArea('Bread Crumb');
					if ($a->getTotalBlocksInArea($c) > 0) {}
					$a->setBlockWrapperStart('<div class="container"><div class="row"><div class="bread-crumb-container">',true);
					$a->setBlockWrapperEnd('</div></div></div>');
					$a->setBlockLimit(1);
					$a->display();
					?>

<?php $this->inc('inc/footer_bottom.php');?>