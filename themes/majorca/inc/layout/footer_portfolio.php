<?php  defined('C5_EXECUTE') or die("Access Denied.");

$fas = new GlobalArea('Second Footer Navigation');
$fblocks = $fas->getTotalBlocksInArea();
$displaySecondFooterNav = $fblocks > 0 || $c->isEditMode();
?>

					<div class="container portfolio">
						<div class="row">
							<div class="col-sm-9 footer-logo">
								<?php
			                    $a = new GlobalArea('Footer Site Title');
			                    $a->display();
			                    ?>
							</div>
							<div class="col-sm-3 footer-social right">
								<?php
								$a = new GlobalArea('Footer Social');
								$a->display();
								?>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-md-3 footer-contact-container">
								<?php
				                $a = new GlobalArea('Footer Contact');
				                $a->display();
				                ?>
							</div>
							<div class="col-md-3 footer-navigation">
								<?php
								$a = new GlobalArea('Footer Navigation');
								$a->display();
								?>
							</div>
							<div class="col-md-6 second-footer-navigation">
								<?php $fas->display(); ?>
							</div>
						</div>
					</div>
