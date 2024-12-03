<?php
namespace Concrete\Package\ThemeMajorca\Block\MajorcaTestimonialSns;

use Concrete\Core\Block\BlockController;
use Core;

class Controller extends BlockController
{
    public $helpers = array('form');

    protected $btInterfaceWidth = 450;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btInterfaceHeight = 560;
    protected $btExportFileColumns = array('fID');
    protected $btTable = 'btMajorcaTestimonialSns';
    protected $btDefaultSet = 'theme_majorca';

    protected $services = array(
            'facebook' => array('viewName' => 'Facebook', 'isView' => '', 'url' =>''),
            'twitter' => array('viewName' => 'Twitter', 'isView' => '', 'url' =>''),
            'github' => array('viewName' => 'GitHub', 'isView' => '', 'url' =>''),
            'instagram' => array('viewName' => 'Instagram', 'isView' => '', 'url' =>''),
            'linkedin' => array('viewName' => 'LinkedIn', 'isView' => '', 'url' =>''),
            'google-plus' => array('viewName' => 'Google Plus', 'isView' => '', 'url' =>''),
            'pinterest-p' => array('viewName' => 'Pinterest', 'isView' => '', 'url' =>''),
            'tumblr' => array('viewName' => 'Tumblr', 'isView' => '', 'url' =>''),
            'youtube' => array('viewName' => 'You Tube', 'isView' => '', 'url' =>''),
        );

    public function getBlockTypeDescription()
    {
        return t("Displays a quote or paragraph next to biographical information and a person's picture.");
    }

    public function getBlockTypeName()
    {
        return t("Majorca Testimonial SNS");
    }

    public function getSearchableContent()
    {
        return $this->name . "\n" . $this->position . "\n" . $this->company . "\n" . $this->paragraph;
    }

    public function view()
    {
        $image = false;
        if ($this->fID) {
            $f = \File::getByID($this->fID);
            if (is_object($f)) {
                $image = $this->app->make('html/image', ['f' => $f] )->getTag();
                $image->alt($this->name);
                $this->set('image', $image);
            }
        }
        $sec = $this->app->make('helper/security');
    }

    public function add(){
      $this->set('services', $this->services);
    }

    public function edit(){
      $this->set('services', $this->services);
    }

    public function save($args){
      if(is_array($args['socialLink'])){
        $args['socialLink'] = json_encode($args['socialLink']);
      }
      parent::save($args);
    }
}
