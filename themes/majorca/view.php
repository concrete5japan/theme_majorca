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
										<div class="col-sm-12">
											<?php View::element('system_errors', array('format' => 'block', 'error' => $error, 'success' => $success, 'message' => $message)); ?>
											<?php  print $innerContent; ?>
										</div>
									</div>
								</main>
							</div>
						</div>
					</div>
				</div><!-- // Main Contents -->

<?php  $this->inc('inc/footer.php'); ?>
