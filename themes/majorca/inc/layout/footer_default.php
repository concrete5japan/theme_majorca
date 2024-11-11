<?php  defined('C5_EXECUTE') or die("Access Denied.");

$as = new GlobalArea('Footer Logo');
$blocks = $as->getTotalBlocksInArea();
$displayThirdColumn = $blocks > 0 || $c->isEditMode();
$fas = new GlobalArea('Second Footer Navigation');
$fblocks = $fas->getTotalBlocksInArea();
$displaySecondFooterNav = $fblocks > 0 || $c->isEditMode();
?>

					<div class="container">
						<div class="row">
							<?php if ($displayThirdColumn) { ?>
							<div class="col-sm-6 col-md-3 footer-logo">
								<?php $as->display(); ?>
							</div>
							<?php } ?>
							<div class="col-sm-6 col-md-3 footer-content-container">
								<?php
		                        $a = new GlobalArea('Footer Site Title');
		                        $a->display();
		                        ?>
								<?php
								$a = new GlobalArea('Footer Contact');
								if ($a->getTotalBlocksInArea($c) > 0) {}
								$a->setBlockWrapperStart('<div class="footer-contact-container">', false);
								$a->setBlockWrapperEnd('</div>');
								$a->setBlockLimit(1);
								$a->display();
								?>
								<?php
								$a = new GlobalArea('Footer Social');
								$a->setBlockWrapperStart('<div class="footer-social">', false);
								$a->setBlockWrapperEnd('</div>');
								$a->setBlockLimit(1);
								$a->display();
								?>
							</div>
							<div class="<?php echo ($displayThirdColumn) ? 'col-sm-12 col-md-6' : 'col-sm-12 col-md-9' ?>">
								<div class="<?php echo ($displaySecondFooterNav) ? 'col-sm-6' : 'col-sm-12' ?> footer-navigation">
								<?php
								$a = new GlobalArea('Footer Navigation');
								$a->display();
								?>
								</div>
								<?php if ($displaySecondFooterNav) { ?>
								<div class="col-sm-6 second-footer-navigation">
									<?php $fas->display(); ?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
