<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('inc/header.php'); ?>

				<!--  Main Contents -->
				<div class="pure-pusher-container">
					<div class="pure-pusher">
						<div id="main-content" class="main-container">
							<main class="main-container-inner">
								<div class="container">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<div class="jumbo">
												<h1><?php echo t('403 Error')?></h1>
												<p><?php echo t('You are not allowed to access this page.')?></p>
											</div>
										</div>
									</div>
								</main>
							</div>
						</div>
					</div>
				</div><!-- // Main Contents -->

<?php  $this->inc('inc/footer.php'); ?>
