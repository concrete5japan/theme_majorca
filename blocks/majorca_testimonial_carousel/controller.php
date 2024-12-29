<?php
namespace Concrete\Package\ThemeMajorca\Block\MajorcaTestimonialCarousel;

use Concrete\Core\Block\BlockController;
use Concrete\Core\File\Tracker\FileTrackableInterface;
use Concrete\Core\Statistics\UsageTracker\AggregateTracker;
use Concrete\Core\Sharing\ShareThisPage\Service;
use Database;
use Page;
use Concrete\Core\Editor\LinkAbstractor;
use Core;

class Controller extends BlockController implements FileTrackableInterface
{
    protected $btTable = 'btMajorcaTestimonial_carousel';
    protected $btExportTables = array('btMajorcaTestimonial_carousel', 'btMajorcaTestimonial_carouselEntries');
    protected $btInterfaceWidth = "600";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "550";
    protected $btCacheBlockRecord = true;
    protected $btExportFileColumns = array('fID');
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btIgnorePageThemeGridFrameworkContainer = true;
    protected $btDefaultSet = 'theme_majorca';

    /**
     * @var \Concrete\Core\Statistics\UsageTracker\AggregateTracker
     */
    protected $tracker;
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



    /**
     * Instantiates the block controller.
     *
     * @param BlockType|null $obj
     * @param \Concrete\Core\Statistics\UsageTracker\AggregateTracker $tracker
     */
    public function __construct($obj = null, AggregateTracker $tracker = null)
    {
        parent::__construct($obj);
        $this->tracker = $tracker;
    }

    public function getBlockTypeDescription()
    {
        return t("Display your images and captions in an attractive slideshow format.");
    }

    public function getBlockTypeName()
    {
        return t("Majorca Testimonial Carousel");
    }

    public function getSearchableContent()
    {
        $content = '';
        $db = $this->app->make('database');
        $v = array($this->bID);
        $q = 'select * from btMajorcaTestimonial_carouselEntries where bID = ?';
        $r = $db->query($q, $v);
        foreach ($r as $row) {
            $content .= $row['name'].' ';
            $content .= $row['position'].' ';
        }

        return $content;
    }

    public function add()
    {
        $this->set('services', json_encode($this->services));
        $this->requireAsset('core/file-manager');
//        $this->requireAsset('core/sitemap');
        $this->set('tmeId',0);
    }

    public function edit()
    {
        $this->set('services', json_encode($this->services));
        $this->requireAsset('core/file-manager');
//        $this->requireAsset('core/sitemap');
        $db = $this->app->make('database');
        $entries = $db->GetAll('SELECT * from btMajorcaTestimonial_carouselEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $rows = array();
        foreach($entries as $en){
          $en['companyURL'] = rawurldecode($en['companyURL']);
          $rows[] = $en;
        }

        $this->set('rows', $rows);

        $query = $db->GetAll('SELECT max(tmeId) as tmeIdMax from btMajorcaTestimonial_carouselEntries where bID = ?',array($this->bID));
        if(is_numeric($query[0]['tmeIdMax'])){
          $this->set('tmeId',$query[0]['tmeIdMax']);
        }else{
          $this->set('tmeId',0);
        }
    }

    public function composer()
    {
        $this->edit();
    }

    public function registerViewAssets($outputContent = '')
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();

        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('responsive-slides');

        $al->register('javascript', 'responsiveslides', 'blocks/image_slider/responsiveslides.js');
        $this->requireAsset('javascript', 'blocks/image_slider/responsiveslides');

        $al->register('css', 'responsiveslides', 'blocks/image_slider/responsiveslides.css');
        $this->requireAsset('css', 'blocks/image_slider/responsiveslides');
    }

    public function getEntries()
    {
        $db = $this->app->make('database');
        $r = $db->GetAll('SELECT * from btMajorcaTestimonial_carouselEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        // in view mode, linkURL takes us to where we need to go whether it's on our site or elsewhere
        $rows = array();
        foreach ($r as $q) {
            $q['socialLink'] = json_decode($q['socialLink'], true);
            $q['companyURL'] = rawurldecode($q['companyURL']);
            $rows[] = $q;
        }
        return $rows;
    }

    public function view()
    {
        $this->set('rows', $this->getEntries());
    }

    public function duplicate($newBID)
    {
        parent::duplicate($newBID);
        $db = $this->app->make('database');
        $v = array($this->bID);
        $q = 'select * from btMajorcaTestimonial_carouselEntries where bID = ? order by sortOrder';
        $r = $db->query($q, $v);
        $i = 0;
        while ($row = $r->fetch()) {
          $db->executeQuery('INSERT INTO btMajorcaTestimonial_carouselEntries(tmeId, bID, fID, name, position, company, companyURL, paragraph, socialLink, sortOrder) values(?,?,?,?,?,?,?,?,?,?)',
              array(
                $i,
                $newBID,
                $row['fID'],
                $row['name'],
                $row['position'],
                $row['company'],
                $row['companyURL'],
                $row['paragraph'],
                $row['socialLink'],
                $i,
              )
          );
          $i++;
        }
    }

    public function delete()
    {
        $db = $this->app->make('database');
        $db->delete('btImageSliderEntries', array('bID' => $this->bID));
        parent::delete();

        $this->tracker->forget($this);
    }

    public function validate($args)
    {
        $error = $this->app->make('helper/validation/error');
        $timeout = intval($args['timeout']);
        $speed = intval($args['speed']);

        if (!$timeout) {
            $error->add(t('Slide Duration must be greater than 0.'));
        }
        if (!$speed) {
            $error->add(t('Slide Transition Speed must be greater than 0.'));
        }
        // https://github.com/viljamis/ResponsiveSlides.js/issues/132#issuecomment-12543345
        // "The 'timeout' (amount of time spent on one slide) has to be at least 100 bigger than 'speed', otherwise the function simply returns."
        if (($timeout - $speed) < 100) {
            $error->add(t('Slide Duration must be at least 100 ms greater than the Slide Transition Speed.'));
        }

        return $error;
    }

    public function save($data)
    {
        $args['navigationType'] = isset($data['navigationType']) ? intval($data['navigationType']) : 1;
        $args['timeout'] = intval($data['timeout']);
        $args['speed'] = intval($data['speed']);
        $args['noAnimate'] = isset($data['noAnimate']) ? 1 : 0;
        $args['pause'] = isset($data['pause']) ? 1 : 0;
        $args['maxWidth'] = isset($data['maxWidth']) ? intval($data['maxWidth']) : 0;
        $args['infinite'] = isset($data['infinite']) ? 1 : 0;
        $args['slidesToShow'] = intval($data['slidesToShow']);
        $args['navigationType'] = $data['navigationType'];

        parent::save($args);

        $db = $this->app->make('database');
        $db->executeQuery('DELETE from btMajorcaTestimonial_carouselEntries WHERE bID = ?', array($this->bID));

		if (isset($data['sortOrder'])) {
	        $count = count($data['sortOrder']);
	        $i = 0;

	        while ($i < $count) {

	          $socialLink = [];
	          foreach($this->services as $key => $value){
	            $socialLink[$key]['viewName'] = trim($data['socialLink'][$key]['viewName'][$i]);
	            $socialLink[$key]['isView'] = trim($data['socialLink'][$key]['isView'][$i]);
	            $socialLink[$key]['url'] = trim($data['socialLink'][$key]['url'][$i]);
	          }

	          $db->executeQuery('INSERT INTO btMajorcaTestimonial_carouselEntries(tmeId, bID, fID, name, position, company, companyURL, paragraph, socialLink, sortOrder) values(?,?,?,?,?,?,?,?,?,?)',
	                array(
	                    $i,
	                    $this->bID,
	                    intval($data['fID'][$i]),
	                    $data['name'][$i],
	                    $data['position'][$i],
	                    $data['company'][$i],
	                    rawurlencode($data['companyURL'][$i]),
	                    $data['paragraph'][$i],
	                    json_encode($socialLink),
	                    $i,
	                )
	            );
	            $i++;
	        }

        }

	      $this->tracker->track($this);
    }

    public function getUsedFiles()
    {
        return array_map(function($entry) {
            return $entry['fID'];
        }, $this->getEntries());
    }

    public function getUsedCollection()
    {
        return $this->getCollectionObject();
    }

}
