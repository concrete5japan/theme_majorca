<?php  defined('C5_EXECUTE') or die("Access Denied.");

$chooseFooterLayout = Config::get('app.theme_majorca.maj_footer_layout');
$showLoginButton = Config::get('app.theme_majorca.maj_show_login_button');

if ($chooseFooterLayout == '') {
	$footerLayout = 'default';
} else {
	$footerLayout = $chooseFooterLayout;
}
?>

					<div class="scroll-page-top">
						<a href="#page-content" class="top"><i class="fas fa-angle-up icon-arrow slideOutUp" aria-hidden="true"></i><span><?php echo t('Back to Top')?></span></a>
					</div>

					<?php  $this->inc('inc/layout/footer_' .$footerLayout. '.php'); ?>

					<?php
					$a = new GlobalArea('Footer Bottom');
					if ($a->getTotalBlocksInArea($c) > 0) {}
					$a->setBlockWrapperStart('<div class="footer-bottom-container">',true);
					$a->setBlockWrapperEnd('</div>');
					//$a->setBlockLimit(1);
					$a->display();
					?>
					<?php if ($showLoginButton) { $this->inc('inc/layout/footer_show_login_button.php'); } ?>
					<div class="copyright">
						<?php
						$a = new GlobalArea('Footer Legal');
						$a->display();
						?>
					</div>
					<div id="ccm-account-menu-container"></div>
				</footer>
			</div>
		</div>
	</div>

	<?php View::element('footer_required'); ?>

    </body>
</html>
