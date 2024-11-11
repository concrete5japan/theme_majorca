<?php
namespace Concrete\Package\ThemeMajorca\Controller\SinglePage\Dashboard\Pages\MajorcaThemeOptions;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Validation\ResponseInterface;
use Config;
use PermissionKey;
use Permissions;
use Localization;
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

class Setting extends DashboardPageController
{
    public function view()
    {
        $this->set('form', $this->app->make('helper/form'));
        $this->set('valt', $this->app->make('helper/validation/token'));
        $this->set('valc', $this->app->make('helper/concrete/validation'));
    }

    public function submit()
    {
        $vals = $this->app->make('helper/validation/strings');
        $valt = $this->app->make('helper/validation/token');
        $valc = $this->app->make('helper/concrete/validation');

		Config::save('app.theme_majorca.maj_mobile_nav_position', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_mobile_nav_position'));
		Config::save('app.theme_majorca.maj_global_nav_position', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_global_nav_position'));
		Config::save('app.theme_majorca.maj_header_layout', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_header_layout'));
		Config::save('app.theme_majorca.maj_header_dark_color', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_header_dark_color') ? true:false);
		Config::save('app.theme_majorca.maj_footer_layout', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_footer_layout'));
		Config::save('app.theme_majorca.maj_home_splash_area', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_home_splash_area'));
		Config::save('app.theme_majorca.maj_splash_image', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_image'));
		Config::save('app.theme_majorca.maj_splash_video_mp4', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_mp4'));
		Config::save('app.theme_majorca.maj_splash_video_webm', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_webm'));
		Config::save('app.theme_majorca.maj_splash_video_ogg', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_ogg'));
		Config::save('app.theme_majorca.maj_splash_video_poster', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_poster'));
		Config::save('app.theme_majorca.maj_splash_video_play', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_play') ? true:false);
		Config::save('app.theme_majorca.maj_splash_video_preload', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_preload') ? true:false);
		Config::save('app.theme_majorca.maj_splash_video_loop', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_video_loop') ? true:false);
		Config::save('app.theme_majorca.maj_splash_skip_button', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_skip_button') ? true:false);
		Config::save('app.theme_majorca.maj_splash_heading', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_heading'));
		Config::save('app.theme_majorca.maj_splash_caption', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_caption'));
		Config::save('app.theme_majorca.maj_splash_button_text', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_splash_button_text'));
		Config::save('app.theme_majorca.maj_page_transition', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_page_transition') ? true:false);
		Config::save('app.theme_majorca.maj_jquery_appear', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_jquery_appear') ? true:false);
		Config::save('app.theme_majorca.maj_show_login_button', $this->app->make(\Concrete\Core\Http\Request::class)->request->get('maj_show_login_button') ? true:false);
		$this->set('success', t('Settings saved successfully.'));
    }
}
