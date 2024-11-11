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
											<div class="not-found">
												<h1><?php echo t('404 Error')?></h1>
												<div class="caption">
													<p><?php echo t('Page not found, so please search.')?></p>
													<?php
														$bt = BlockType::getByHandle('search');
														$bt->controller->title = t('Search');
														$bt->controller->buttonText = t('Search');
														//$bt->controller->postTo_cID = 'search';
														//$bt->controller->externalTarget = true;
														$bt->controller->resultsURL = h('search');
														$bt->render();
													?>
												</div>
											</div>
										</div>
									</div>
								</main>
							</div>
						</div>
					</div>
				</div><!-- // Main Contents -->

<?php  $this->inc('inc/footer.php'); ?>
