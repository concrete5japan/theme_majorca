<?php
defined('C5_EXECUTE') or die("Access Denied.");

$globalNavPosition = Config::get('app.theme_majorca.maj_global_nav_position');
$mobileNavPosition = Config::get('app.theme_majorca.maj_mobile_nav_position');

?>

					<div class="header-container-inner simple">
						<div class="container">
							<div class="row">
								<div class="header-summary-container">
								<?php
								$a = new GlobalArea('Header Summary');
								$a->display();
								?>
								</div>
							</div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-sm-12 site-name">
				                	<?php
									$a = new GlobalArea('Header Site Title');
									$a->display();
									?>
								</div>
							</div>
							<div class="row">
								<?php
								$a = new GlobalArea('Header Contents');
								if ($a->getTotalBlocksInArea($c) > 0) {}
								$a->setBlockWrapperStart('<div class="col-sm-12 header-contents">',true);
								$a->setBlockWrapperEnd('</div>');
								$a->setBlockLimit(1);
								$a->display();
								?>
								<?php
								$a = new GlobalArea('Header Search');
								if ($a->getTotalBlocksInArea($c) > 0) {}
								$a->setBlockWrapperStart('<div class="col-sm-12 header-search">',true);
								$a->setBlockWrapperEnd('</div>');
								$a->setBlockLimit(1);
								$a->display();
								?>
							</div>
						</div>
					</div>
					<?php
					$a = new Area('Header Image');
					if ($a->getTotalBlocksInArea($c) > 0) {}
					$a->setBlockWrapperStart('<div class="header-image-container">',true);
					$a->setBlockWrapperEnd('</div>');
					$a->setBlockLimit(1);
					$a->display($c);
					?>
				</header><!-- //Headerー -->

				<!-- Global Navigation -->
				<div <?php echo 'class="pure-drawer ' .$globalNavPosition. '" data-position="' .$mobileNavPosition. '"'; ?>>
					<div class="global-nav<?php if (User::isLoggedIn()) { echo ' login'; } ?>">
						<?php
						$a = new GlobalArea('Header Navigation');
						$a->display();
						?>
					</div>
				</div><!-- //Global Navigation -->
