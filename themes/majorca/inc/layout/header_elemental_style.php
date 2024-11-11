<?php
defined('C5_EXECUTE') or die("Access Denied.");

$globalNavPosition = Config::get('app.theme_majorca.maj_global_nav_position');
$mobileNavPosition = Config::get('app.theme_majorca.maj_mobile_nav_position');

$as = new GlobalArea('Header Search');
$blocks = $as->getTotalBlocksInArea();
$displayThirdColumn = $blocks > 0 || $c->isEditMode();
?>

					<div class="header-container-inner elemental">
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
							<div class="row header-item-container">
								<div class="col-sm-6 col-md-6 col-lg-3 site-name">
				                	<?php
									$a = new GlobalArea('Header Site Title');
									$a->display();
									?>
								</div>
								<div class="<?php echo ($displayThirdColumn) ? 'col-sm-6 col-md-7 col-lg-6' : 'col-sm-6 col-md-6 col-lg-9' ?> header-contents">
					                <?php
					                $a = new GlobalArea('Header Contents');
					                $a->display();
					                ?>
					            </div>
					            <?php if ($displayThirdColumn) { ?>
								<div class="col-sm-6 col-md-5 col-lg-3 header-search">
									<?php $as->display(); ?>
								</div>
								<?php } ?>
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
