<?php  defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
?>

					<div id="concrete5-brand" class="login-container">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<span><?php echo t('Built with <a href="http://www.concrete5.org" class="concrete5" rel="nofollow">concrete5</a> CMS.') ?></span>
									<span class="pull-right login-btn"><?php echo $app->make('helper/navigation')->getLogInOutLink() ?></span>
								</div>
							</div>
						</div>
					</div>
