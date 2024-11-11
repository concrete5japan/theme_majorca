<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('inc/header_home.php');
?>

				<!--  Main Contents -->
				<div class="pure-pusher-container">
					<div class="pure-pusher">
						<div id="main-content" class="main-container">
						<?php
						$a = new Area('Page Header Image');
						if ($a->getTotalBlocksInArea($c) > 0) {}
						$a->setBlockWrapperStart('<div class="page-header-image-container">',true);
						$a->setBlockWrapperEnd('</div>');
						$a->setBlockLimit(1);
						$a->display($c);
						?>
						<?php
						$a = new Area('Page Header');
						$a->enableGridContainer();
						$a->display($c);
						?>
						<main>
							<article>
								<?php
								$a = new Area('Main');
								$a->enableGridContainer();
								$a->display($c);
								?>
							</article>
						</main>
						<?php
						$a = new Area('Page Footer');
						$a->enableGridContainer();
						$a->display($c);
						?>
					</div>
				</div><!-- // Main Contents -->

<?php  $this->inc('inc/footer_home.php'); ?>
