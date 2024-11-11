<?php
namespace Concrete\Package\ThemeMajorca;

use Package;
use Config;
use BlockType;
use SinglePage;
use PageTheme;
use BlockTypeSet;
use Asset;
use AssetList;

class Controller extends Package
{

	protected $pkgHandle = 'theme_majorca';
	protected $appVersionRequired = '8.0.0';
	protected $pkgVersion = '1.0.2';
	protected $pkgAllowsFullContentSwap = true;

	public function getPackageDescription()
	{
    	return t("A smart and modern responsive theme based on the Bootstrap framework.");
	}

	public function getPackageName()
	{
    	return t('Majorca');
	}

/*
	public function swapContent($options)
    {
		$ci = new ContentImporter();
		$ci->importContentFile($this->getPackagePath() . '/content.xml');
    }
*/

	public function swapContent($options)
    {
        if ($this->validateClearSiteContents($options)) {
            $this->app->make('cache/request')->disable();

            $pl = new PageList();
            $pages = $pl->getResults();
            foreach ($pages as $c) {
                $c->delete();
            }

            $fl = new FileList();
            $files = $fl->getResults();
            foreach ($files as $f) {
                $f->delete();
            }

            // clear stacks
            $sl = new StackList();
            foreach ($sl->get() as $c) {
                $c->delete();
            }

            $home = Page::getByID(HOME_CID);
            $blocks = $home->getBlocks();
            foreach ($blocks as $b) {
                $b->deleteBlock();
            }

            $pageTypes = PageType::getList();
            foreach ($pageTypes as $ct) {
                $ct->delete();
            }

            // now we add in any files that this package has
            if (is_dir($this->getPackagePath() . '/content_files')) {
                $ch = new ContentImporter();
                $computeThumbnails = true;
                if ($this->contentProvidesFileThumbnails()) {
                    $computeThumbnails = false;
                }
                $ch->importFiles($this->getPackagePath() . '/content_files', $computeThumbnails);
            }

            // now we parse the content.xml if it exists.
            if (is_dir($this->getPackagePath() . '/content.xml')) {
				$ci = new ContentImporter();
				$ci->importContentFile($this->getPackagePath() . '/content.xml');
			}

            $this->app->make('cache/request')->enable();
        }
    }

	public function install()
	{
    	$pkg = parent::install();
        $this->installOrUpgrade();
	}


    public function upgrade()
    {
	    parent::upgrade();
        $this->installOrUpgrade();
    }

	public function installOrUpgrade()
	{
	    $pkg = Package::getByHandle($this->pkgHandle);

	    if(!is_object(PageTheme::getByHandle('majorca'))){
			PageTheme::add('majorca', $pkg);
	    }


        //install or upgrade ThumbnailType
        $thumbnailTypes = array(
                            array('name' => 'Small','handle' => 'small', 'width' => 740),
                            array('name' => 'Medium','handle' => 'medium', 'width' => 940),
                            array('name' => 'Large','handle' => 'large', 'width' => 1140),
                         );
        foreach($thumbnailTypes as $tt){
		    $em = $this->app->make('Doctrine\ORM\EntityManagerInterface');
		    $thumbType = $em->getRepository('\Concrete\Core\Entity\File\Image\Thumbnail\Type\Type')->findOneBy(['ftTypeHandle' => $tt['handle']]);
		    if (!is_object($thumbType)) {
			    $type = new \Concrete\Core\Entity\File\Image\Thumbnail\Type\Type();
			    $type->setName($tt['name']);
			    $type->setHandle($tt['handle']);
			    $type->setWidth($tt['width']);
			    $type->save();
		    }
        }

		$bts = BlockTypeSet::getByHandle('majorca');
		if(!is_object($bts)) {
			$bts = BlockTypeSet::add('majorca', 'Majorca', $pkg);
		}

        // install or upgrade BlockType
        $blockHandles = array(
                         'majorca_testimonial_sns',
                         'majorca_topic_page_list',
                         'majorca_feature_color',
                         'majorca_slick_slider',
                         'majorca_testimonial_carousel',
                        );

        foreach($blockHandles as $bh){
            $bt = BlockType::getByHandle($bh);
            if (!is_object($bt)) {
                $bt = BlockType::installBlockType($bh, $pkg);
				$bts->addBlockType($bt);
            }
        }



        // install or upgrade Single Page
        $paths = array(
                    '/dashboard/pages/majorca_theme_options',
                    '/dashboard/pages/majorca_theme_options/setting',
                 );

        foreach($paths as $path){
            $pc = \Page::getByPath($path);
		    if($pc->getError() == COLLECTION_NOT_FOUND){
			    SinglePage::add($path, $pkg);
            }
        }



        // setting Config
        $configs = array(
                    'app.theme_majorca.maj_mobile_nav_position' => 'left',
                    'app.theme_majorca.maj_global_nav_position' => 'center',
                    'app.theme_majorca.maj_header_layout' => 'default',
                    'app.theme_majorca.maj_header_dark_color' => false,
                    'app.theme_majorca.maj_footer_layout' => 'default',
                    'app.theme_majorca.maj_home_splash_area' => 'none',
                    'app.theme_majorca.maj_splash_image' => '',
                    'app.theme_majorca.maj_splash_video_mp4' => '',
                    'app.theme_majorca.maj_splash_video_webm' => '',
                    'app.theme_majorca.maj_splash_video_ogg' => '',
                    'app.theme_majorca.maj_splash_video_poster' => '',
                    'app.theme_majorca.maj_splash_video_play' => false,
                    'app.theme_majorca.maj_splash_video_preload' => false,
                    'app.theme_majorca.maj_splash_video_loop' => false,
                    'app.theme_majorca.maj_splash_skip_button' => false,
                    'app.theme_majorca.maj_splash_heading' => '',
                    'app.theme_majorca.maj_splash_caption' => '',
                    'app.theme_majorca.maj_splash_button_text' => '',
                    'app.theme_majorca.maj_page_transition' => true,
                    'app.theme_majorca.maj_jquery_appear' => false,
                    'app.theme_majorca.maj_show_login_button' => false,
                   );

        foreach($configs as $key => $val){
	        if(!Config::get($key)){
	            Config::save($key , $val);
		    }
        }
	}

	public function on_start() {
        $this->registerAssets();
    }

	public function registerAssets () {
 		$al = AssetList::getInstance();

 		$al->register( 'javascript', 'jquery-migrate', 'js/vendor/jquery-migrate.min.js', array('version' => '1.2.1'), $this );
		$al->register( 'javascript', 'jquery-easing', 'js/vendor/jquery.easing.js', array('version' => '1.3'), $this );
		$al->register( 'javascript', 'simple-lightbox', 'js/vendor/simple-lightbox.js', array('version' => '1.12.2'), $this );
		$al->register( 'javascript', 'slick', 'js/vendor/slick.js', array('version' => '1.8.0'), $this );
		$al->register( 'javascript', 'shuffle', 'js/vendor/shuffle.js', array('version' => '5.0.3'), $this );
		$al->register( 'javascript', 'tab', 'js/vendor/tab.js', array('version' => '3.3.7'), $this );
		$al->register( 'javascript', 'collapse', 'js/vendor/collapse.js', array('version' => '3.3.7'), $this );
		$al->register( 'javascript', 'modal', 'js/vendor/modal.js', array('version' => '3.3.7'), $this );
		$al->register( 'javascript', 'app', 'js/app.js', array('version' => '1.0'), $this );
		$al->register( 'javascript', 'main', 'js/main.js', array('version' => '1.0'), $this );
		//$al->register( 'css', 'bootstrap', 'themes/majorca/css/bootstrap.css', array('version' => '3.3.5'), $this );
		//$al->register( 'css', 'bootstrap-theme', 'themes/majorca/css/bootstrap-theme.min.css', array('version' => '3.3.5'), $this );
	}
}
?>
