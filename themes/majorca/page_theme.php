<?php
namespace Concrete\Package\ThemeMajorca\Theme\Majorca;

use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme implements ThemeProviderInterface {

	public function registerAssets() {
        //$this->providesAsset('javascript', 'bootstrap/*');
		$this->providesAsset('css', 'bootstrap/*');
		$this->providesAsset('css', 'blocks/form');
		$this->providesAsset('css', 'core/frontend/*');

		$this->requireAsset('javascript', 'jquery');
		$this->requireAsset('javascript', 'bootstrap/tooltip');
		$this->requireAsset('javascript', 'picturefill');
		$this->requireAsset('javascript', 'jquery-migrate');
		$this->requireAsset('javascript', 'jquery-easing');
		$this->requireAsset('javascript', 'simple-lightbox');
		$this->requireAsset('javascript', 'slick');
		$this->requireAsset('javascript', 'shuffle');
		$this->requireAsset('javascript', 'tab');
		$this->requireAsset('javascript', 'collapse');
		$this->requireAsset('javascript', 'modal');
		$this->requireAsset('javascript', 'app');
		$this->requireAsset('javascript', 'main');

		//$this->requireAsset('css', 'bootstrap');
		//$this->requireAsset('css', 'bootstrap-theme');
		$this->requireAsset('css', 'font-awesome');
		$this->requireAsset('css', 'bootstrap/tooltip');
	}

    protected $pThemeGridFrameworkHandle = 'bootstrap3';

    public function getThemeName()
    {
        return t('Majorca');
    }

    public function getThemeDescription()
    {
        return t('Smart and Modern responsive theme with Theme Customizer, Theme Options. Support for blogs, portfolios, layouts and more.');
    }

    public function getThemeBlockClasses()
    {
		return [
			'autonav' => [
                'block-sidebar-wrapped',
            ],
            'content' => [
                'block-sidebar-wrapped',
                'block-sidebar-padded',
            ],
            'date_navigation' => ['block-sidebar-padded'],
            'feature' => [
            	'feature-home-page',
            	'feature-circle-icon',
            	'block-sidebar-wrapped',
            ],
            'file' => [
            	'align-center',
            	'default-btn',
            	'primary-btn',
            	'success-btn',
            	'large-btn',
            ],
            'google_map' => [
	            'block-sidebar-wrapped',
            ],
            'horizontal_rule' => [
	            'thin-border-emboss',
	            'thin-border-gradation',
	            'border-slash',
	            'border-dotted',
	            'square-icon',
	            'circle-icon',
	            'diamond-icon',
	            'heart-icon',
	            'star-icon',
	            'scissors-icon',
            ],
            'image' => [
                'image-right-tilt',
                'image-circle',
                'thin-border-image',
                'middle-border-image',
                'middle-border-gap-image',
                'shadow-pale-image',
                'shadow-middle-image',
                'shadow-deep-image',
                'shadow-pale-inset-image',
                'shadow-middle-inset-image',
                'shadow-deep-inset-image',
                'circle-image',
                'circle-thin-border-image',
                'circle-middle-border-image',
                'circle-drop-shadow-pale-image',
                'circle-drop-shadow-middle-image',
                'circle-drop-shadow-deep-image',
            ],
            'majorca_feature_color' => [
	            'feature-circle-icon',
            ],
            'majorca_testimonial_carousel' => [
	            'image-circle',
            ],
            'majorca_testimonial_sns' => [
	            'image-circle',
            ],
            'next_previous' => ['block-sidebar-wrapped'],
            'page_list' => [
                'recent-blog-entry',
                'blog-entry-list',
                'page-list-with-buttons',
                'block-sidebar-wrapped',
            ],
			'page_title' => [
                'title-center',
                'title-right',
                'accent',
                'block-sidebar-wrapped',
            ],
            'share_this_page' => [
                'light-color',
                'block-sidebar-wrapped',
            ],
			'social_links' => [
                'light-color',
            ],
            'switch_language' => [
	            'align-center',
	            'align-right',
            ],
            'tags' => ['block-sidebar-wrapped'],
            'testimonial' => [
            	'testimonial-bio',
            	'image-circle',
            ],
            'topic_list' => ['block-sidebar-wrapped'],
        ];
    }

    /**
     * @return array
     */
    public function getThemeAreaClasses()
    {
	    return [
            'Page Header' => [
            	'area-content-accent',
            	'area-content-dark',
            ],

            'Page Footer' => [
            	'area-content-accent',
            	'area-content-dark',
            ],

            'Main' => [
            	'padding-right',
            	'padding-left',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getThemeDefaultBlockTemplates()
    {
        return [
            'calendar' => 'bootstrap_calendar.php',
        ];
    }

    /**
     * @return array
     */
    public function getThemeResponsiveImageMap()
    {
        return [
            'large' => '900px',
            'medium' => '768px',
            'small' => '0',
        ];
    }

    /**
     * @return array
     */
    public function getThemeEditorClasses()
    {
        return [
	        ['title' => t('Title Crosshead'), 'menuClass' => 'title-crosshead', 'spanClass' => 'title-crosshead', 'forceBlock' => 1],
	        ['title' => t('Title Subhead'), 'menuClass' => 'title-subhead', 'spanClass' => 'title-subhead', 'forceBlock' => 1],
            ['title' => t('Title Thin'), 'menuClass' => 'title-thin', 'spanClass' => 'title-thin', 'forceBlock' => 1],
            ['title' => t('Title Caps'), 'menuClass' => 'title-caps', 'spanClass' => 'title-caps', 'forceBlock' => 1],
            ['title' => t('Title Caps Bold'), 'menuClass' => 'title-caps-bold', 'spanClass' => 'title-caps-bold', 'forceBlock' => 1],
            ['title' => t('Title Serif'), 'menuClass' => 'title-serif', 'spanClass' => 'title-serif', 'forceBlock' => 1],
            ['title' => t('Title Playball'), 'menuClass' => 'title-playball', 'spanClass' => 'title-playball', 'forceBlock' => 1],
            ['title' => t('Title Lobster'), 'menuClass' => 'title-lobster', 'spanClass' => 'title-lobster', 'forceBlock' => 1],
            ['title' => t('Title Caveat'), 'menuClass' => 'title-caveat', 'spanClass' => 'title-caveat', 'forceBlock' => 1],
            ['title' => t('Image Caption'), 'menuClass' => 'image-caption', 'spanClass' => 'image-caption', 'forceBlock' => '-1'],
            ['title' => t('Standard Button'), 'menuClass' => '', 'spanClass' => 'btn btn-default', 'forceBlock' => '-1'],
            ['title' => t('Primary Button'), 'menuClass' => '', 'spanClass' => 'btn btn-primary', 'forceBlock' => '-1'],
            ['title' => t('Success Button'), 'menuClass' => '', 'spanClass' => 'btn btn-success', 'forceBlock' => '-1'],
            ['title' => t('Primary Text'), 'menuClass' => '', 'spanClass' => 'text-primary', 'forceBlock' => '-1'],
            ['title' => t('Success Text'), 'menuClass' => '', 'spanClass' => 'text-success', 'forceBlock' => '-1'],
            ['title' => t('Info Text'), 'menuClass' => '', 'spanClass' => 'text-info', 'forceBlock' => '-1'],
            ['title' => t('Warning Text'), 'menuClass' => '', 'spanClass' => 'text-warning', 'forceBlock' => '-1'],
            ['title' => t('Danger Text'), 'menuClass' => '', 'spanClass' => 'text-danger', 'forceBlock' => '-1'],
            ['title' => t('Oredered List'), 'menuClass' => '', 'spanClass' => 'oredered-list-style', 'forceBlock' => '-1'],
        ];
    }

    /**
     * @return array
     */
    public function getThemeAreaLayoutPresets()
    {
        $presets = [
            [
                'handle' => 'left_sidebar',
                'name' => 'Left Sidebar',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-sm-4"></div>',
                    '<div class="col-sm-8"></div>',
                ],
            ],
            [
                'handle' => 'right_sidebar',
                'name' => 'Right Sidebar',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-sm-8"></div>',
                    '<div class="col-sm-4"></div>',
                ],
            ],
            [
                'handle' => 'testimonial_carousel',
                'name' => 'Testimonial Carousel',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="carousel-team carousel-item"></div>',
                ],
            ],
            [
                'handle' => 'split_standard',
                'name' => 'Split Standard',
                'container' => '<div class="row split-area"></div>',
                'columns' => [
                    '<div class="split-left"></div>',
                    '<div class="split-right"></div>',
                ],
            ],
            [
                'handle' => 'split_reverse',
                'name' => 'Split Reverse',
                'container' => '<div class="row split-area reverse"></div>',
                'columns' => [
                    '<div class="split-right"></div>',
                    '<div class="split-left"></div>',
                ],
            ],
            [
                'handle' => 'offset_1',
                'name' => 'Offset 1column',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-md-10 col-md-offset-1"></div>',
                ],
            ],
            [
                'handle' => 'offset_2',
                'name' => 'Offset 2columns',
                'container' => '<div class="row"></div>',
                'columns' => [
                    '<div class="col-md-8 col-md-offset-2"></div>',
                ],
            ],
        ];

        return $presets;
    }
}
