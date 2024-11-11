<?php
namespace Concrete\Package\ThemeMajorca\Controller\SinglePage\Dashboard\Pages;

use Concrete\Core\Page\Controller\DashboardPageController;

class MajorcaThemeOptions extends DashboardPageController
{
    public function view()
    {
        $this->redirect('/dashboard/pages/majorca_theme_options/setting');
    }
}
