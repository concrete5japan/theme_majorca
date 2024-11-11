<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

					<div class="container simple">
						<div class="row">
							<div class="col-sm-12 footer-logo">
								<?php
			                    $a = new GlobalArea('Footer Site Title');
			                    $a->display();
			                    ?>
							</div>
							<?php
							$a = new GlobalArea('Footer Social');
							$a->setBlockWrapperStart('<div class="col-sm-12 footer-social">', false);
							$a->setBlockWrapperEnd('</div>');
							$a->setBlockLimit(1);
							$a->display();
							?>
							<div class="col-sm-12 footer-navigation-container">
								<div class="footer-navigation">
									<?php
									$a = new GlobalArea('Footer Navigation');
									$a->display();
									?>
								</div>
							</div>
						</div>
					</div>
