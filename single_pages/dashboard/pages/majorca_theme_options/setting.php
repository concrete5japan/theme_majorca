<?php defined('C5_EXECUTE') or die("Access Denied.");

if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
$ih = $app->make('helper/concrete/ui');
$al = $app->make('helper/concrete/asset_library');

?>

<style>
	div#ccm-dashboard-content fieldset {
		padding-left: 30px;
		padding-right: 30px;
		margin-left: -27px;
		margin-right: 0;
	}
	.ccm-ui fieldset {
		margin: 0 auto 50px;
		padding-top: 30px;
		background-color: #fcfcfc;
		border: none;
	}
	label.control-label {
		display: block;
	}
	.radio-inline label {
		font-weight: normal;
	}
	.ccm-ui legend {
		float: left;
    	font-size: 20px;
    }
    hr {
		border-top: 1px solid #aaaaaa;
    }
</style>

<form method="post" action="<?php echo $view->action('submit'); ?>">
    <?php //$form->getAutocompletionDisabler(); ?>
	<fieldset>
		<legend><?php echo t('Navigation'); ?></legend>
		<div class="form-group">
			<?php
				echo $form->label('maj_global_nav_position', t('Align Global Navigation'));
				echo $form->select('maj_global_nav_position', array('center' => t('Center'), 'left' => t('Left'), 'right' => t('Right'), 'full' => t('Full Width'), 'button' => t('Button')), Config::get('app.theme_majorca.maj_global_nav_position'), array('style' => 'width: 260px;'));
			?>

			<p style="padding-top: 10px; text-align: right;"><a class="btn btn-default" data-toggle="collapse" href="#globalNav" style="padding: 5px 10px; font-size: 14px;"><?php echo t('View image'); ?></a></p>
			<div class="collapse" id="globalNav">
				<div class="row">
					<div class="col-sm-12" style="text-align: center;"><?php echo t('Center'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/global_nav_center.png" style="width: 100%; padding: 5px 0 10px;"></div>
					<div class="col-sm-12" style="text-align: center;"><?php echo t('Left'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/global_nav_left.png" style="width: 100%; padding: 5px 0 10px;"></div>
					<div class="col-sm-12" style="text-align: center;"><?php echo t('Right'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/global_nav_right.png" style="width: 100%; padding: 5px 0 10px;"></div>
					<div class="col-sm-12" style="text-align: center;"><?php echo t('Full Width'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/global_nav_full.png" style="width: 100%; padding: 5px 0 10px;"></div>
					<div class="col-sm-12" style="text-align: center;"><?php echo t('Button'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/global_nav_button.png" style="width: 100%; padding: 5px 0 10px;"></div>
				</div>
			</div>
		</div>

		<hr>

		<div class="form-group">
			<?php echo $form->label('maj_mobile_nav_position', t('Position of Mobile Navigation')); ?>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_mobile_nav_position', 'left', Config::get('app.theme_majorca.maj_mobile_nav_position'), array('checked' => "checked")); ?><?php echo t('Left'); ?>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_mobile_nav_position', 'right', Config::get('app.theme_majorca.maj_mobile_nav_position')); ?><?php echo t('Right'); ?>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_mobile_nav_position', 'top', Config::get('app.theme_majorca.maj_mobile_nav_position')); ?><?php echo t('Top'); ?>
				</label>
			</div>

			<p style="padding-top: 10px; text-align: right;"><a class="btn btn-default" data-toggle="collapse" href="#mobileNav" style="padding: 5px 10px; font-size: 14px;"><?php echo t('View image'); ?></a></p>
			<div class="collapse" id="mobileNav">
				<div class="row">
					<div class="col-sm-4" style="text-align: center;"><?php echo t('Left'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/mobile_nav_left.png" style="width: 100%; padding: 5px 0 10px;"></div>
					<div class="col-sm-4" style="text-align: center;"><?php echo t('Right'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/mobile_nav_right.png" style="width: 100%; padding: 5px 0 10px;"></div>
					<div class="col-sm-4" style="text-align: center;"><?php echo t('Top'); ?><br><img src="<?php echo DIR_REL; ?>/packages/theme_majorca/single_pages/dashboard/pages/majorca_theme_options/img/mobile_nav_top.png" style="width: 100%; padding: 5px 0 10px;"></div>
				</div>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo t('Header Area'); ?></legend>
		<div class="form-group">
			<?php echo $form->label('maj_header_layout', t('Header Layout')); ?>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_header_layout', 'default', Config::get('app.theme_majorca.maj_header_layout'), array('checked' => "checked")); ?><?php echo t('Default'); ?>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_header_layout', 'elemental_style', Config::get('app.theme_majorca.maj_header_layout')); ?><?php echo t('Elemental Style'); ?>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_header_layout', 'simple', Config::get('app.theme_majorca.maj_header_layout')); ?><?php echo t('Simple'); ?>
				</label>
			</div>
		</div>

		<div class="form-group">
            <?php echo $form->label('maj_header_dark_color', t('Header Dark Color')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_header_dark_color', 1, Config::get('app.theme_majorca.maj_header_dark_color')); ?><?php echo t('Inverted to the dark color'); ?>
	            </label>
	        </div>
	    </div>
	</fieldset>

	<fieldset>
		<legend><?php echo t('Footer Area'); ?></legend>
		<div class="form-group">
			<?php echo $form->label('maj_footer_layout', t('Footer Layout')); ?>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_footer_layout', 'default', Config::get('app.theme_majorca.maj_footer_layout'), array('checked' => "checked")); ?><?php echo t('Default'); ?>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_footer_layout', 'portfolio', Config::get('app.theme_majorca.maj_footer_layout')); ?><?php echo t('Portfolio'); ?>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<?php echo $form->radio('maj_footer_layout', 'simple', Config::get('app.theme_majorca.maj_footer_layout')); ?><?php echo t('Simple'); ?>
				</label>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo t('Home Splash Area'); ?></legend>
		<div class="form-group">
			<?php
				echo $form->label('maj_home_splash_area', t('Choose Image or Video'));
				echo $form->select('maj_home_splash_area', array('none' => t('-- None --'), 'splash_image' => t('Splash Image'), 'splash_video' => t('Splash Video')), Config::get('app.theme_majorca.maj_home_splash_area'), array('style' => 'width: 260px;'));
			?>
		</div>

		<hr>

		<div class="form-group">
			<?php
				echo $form->label('maj_splash_image', t('Image'));
				$splashImage = File::getByID(Config::get('app.theme_majorca.maj_splash_image'));
				echo $al->image('maj_splash_image-' .Config::get('app.theme_majorca.maj_splash_image'), 'maj_splash_image', t('Choose Image'), $splashImage);
			?>
		</div>

		<hr>

		<div class="form-group">
			<?php
				echo $form->label('maj_splash_video_mp4', t('MP4'));
				$splashVideoMp4 = File::getByID(Config::get('app.theme_majorca.maj_splash_video_mp4'));
				echo $al->file('maj_splash_video_mp4-' .Config::get('app.theme_majorca.maj_splash_video_mp4'), 'maj_splash_video_mp4', t('Choose MP4 Video File'), $splashVideoMp4);
			?>
		</div>

		<div class="form-group">
			<?php
				echo $form->label('maj_splash_video_webm', t('WebM'));
				$splashVideoWebm = File::getByID(Config::get('app.theme_majorca.maj_splash_video_webm'));
				echo $al->file('maj_splash_video_webm-' .Config::get('app.theme_majorca.maj_splash_video_webm'), 'maj_splash_video_webm', t('Choose WebM Video File'), $splashVideoWebm);
			?>
		</div>
		<div class="form-group">
			<?php
				echo $form->label('maj_splash_video_ogg', t('Ogg'));
				$splashVideoOgg = File::getByID(Config::get('app.theme_majorca.maj_splash_video_ogg'));
				echo $al->file('maj_splash_video_ogg-' .Config::get('app.theme_majorca.maj_splash_video_ogg'), 'maj_splash_video_ogg', t('Choose Ogg Video File'), $splashVideoOgg);
			?>
		</div>
		<div class="form-group">
			<?php
				echo $form->label('maj_splash_video_poster', t('Video Placeholder Image (Optional)'));
				$splashVideoPoster = File::getByID(Config::get('app.theme_majorca.maj_splash_video_poster'));
				echo $al->file('maj_splash_video_poster-' .Config::get('app.theme_majorca.maj_splash_video_poster'), 'maj_splash_video_poster', t('Choose Video Placeholder Image'), $splashVideoPoster);
			?>
		</div>

		<hr>

		<div class="form-group">
            <?php echo $form->label('maj_splash_video_play', t('Video Autoplay')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_splash_video_play', 1, Config::get('app.theme_majorca.maj_splash_video_play')); ?><?php echo t('Start a video automatically'); ?>
	            </label>
	        </div>
	    </div>

	    <div class="form-group">
            <?php echo $form->label('maj_splash_video_loop', t('Video Loop')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_splash_video_loop', 1, Config::get('app.theme_majorca.maj_splash_video_loop')); ?><?php echo t('Start over again'); ?>
	            </label>
	        </div>
	    </div>

		<div class="form-group">
            <?php echo $form->label('maj_splash_video_preload', t('Video Preload')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_splash_video_preload', 1, Config::get('app.theme_majorca.maj_splash_video_preload')); ?><?php echo t('Tells the browser not to download any of the video when autoplay is not used'); ?>
	            </label>
	        </div>
	    </div>

		<hr>

		<div class="form-group">
			<?php
				echo $form->label('maj_splash_heading', t('Splash Heading'));
				echo $form->text('maj_splash_heading', h(Config::get('app.theme_majorca.maj_splash_heading')), array('placeholder' => t('Heading'), 'style' => 'display: block;'));
			?>
		</div>

		<div class="form-group">
			<?php
				echo $form->label('maj_splash_caption', t('Splash Caption'));
				echo $form->text('maj_splash_caption', h(Config::get('app.theme_majorca.maj_splash_caption')), array('placeholder' => t('Caption'), 'style' => 'display: block;'));
			?>
		</div>

		<div class="form-group">
            <?php echo $form->label('maj_splash_skip_button', t('Show Skip button')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_splash_skip_button', 1, Config::get('app.theme_majorca.maj_splash_skip_button')); ?><?php echo t('Show skip button in splash area'); ?>
	            </label>
	        </div>
	    </div>

		<div class="form-group">
			<?php
				echo $form->label('maj_splash_button_text', t('Skip Button Text'));
				echo $form->text('maj_splash_button_text', h(Config::get('app.theme_majorca.maj_splash_button_text')), array('placeholder' => t('View contents'), 'style' => 'display: block;'));
			?>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo t('Others'); ?></legend>
		<div class="form-group">
            <?php echo $form->label('maj_page_transition', t('Page Transition Effect')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_page_transition', 1, Config::get('app.theme_majorca.maj_page_transition')); ?><?php echo t('Load page transition script'); ?>
	            </label>
	        </div>
	    </div>

		<div class="form-group">
            <?php echo $form->label('maj_jquery_appear', t('Load Parallax Script')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_jquery_appear', 1, Config::get('app.theme_majorca.maj_jquery_appear')); ?><?php echo t('Load "jquery.appear.js"'); ?>
	            </label>
	        </div>
            <ul>
            	<li><?php echo t('Item appear from the top : Add "item-top" in a custom class'); ?></li>
            	<li><?php echo t('Item appear from the bottom : Add "item-bottom" in a custom class'); ?></li>
            	<li><?php echo t('Item appear from the left : Add "item-left" in a custom class'); ?></li>
            	<li><?php echo t('Item appear from the right : Add "item-right" in a custom class'); ?></li>
            	<li><?php echo t('Item fade in : Add "item-fade-in" in a custom class'); ?></li>
            </ul>
            <p><i class="fa fa-asterisk"></i> <?php echo t('"jquery.appear.js" does not work in edit mode.'); ?></p>
	    </div>

		<hr>

		<div class="form-group">
            <?php echo $form->label('maj_show_login_button', t('Show Login Button')); ?>
            <div class="checkbox">
	            <label>
	            	<?php echo $form->checkbox('maj_show_login_button', 1, Config::get('app.theme_majorca.maj_show_login_button')); ?><?php echo t('Show login button'); ?>
	            </label>
	        </div>
	        <ul>
            	<li><?php echo t('Login button is displayed at the bottom of the page'); ?></li>
            </ul>
	    </div>

	</fieldset>

	<?php echo $token->output('submit');?>

	<div class="ccm-dashboard-form-actions-wrapper">
		<div class="ccm-dashboard-form-actions">
			<a href="<?php echo View::url('/dashboard/pages/majorca_theme_options/setting'); ?>" class="btn btn-default pull-left"><?php echo t('Cancel'); ?></a>
			<?php echo $app->make('helper/form')->submit('save', t('Save Changes'), array('class' => 'btn btn-primary pull-right')); ?>
		</div>
	</div>
</form>