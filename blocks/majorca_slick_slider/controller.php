<?php
namespace Concrete\Package\ThemeMajorca\Block\MajorcaSlickSlider;

use Concrete\Core\Block\BlockController;
use Concrete\Core\File\Tracker\FileTrackableInterface;
use Concrete\Core\Statistics\UsageTracker\AggregateTracker;
use Database;
use Page;
use Concrete\Core\Editor\LinkAbstractor;
use Core;

class Controller extends BlockController implements FileTrackableInterface
{
    protected $btTable = 'btMajorcaSlickSlider';
    protected $btExportTables = array('btMajorcaSlickSlider', 'btMajorcaSlickSliderEntries');
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
        return t("Majorca Slick Slider");
    }

    public function getSearchableContent()
    {
        $content = '';
        $db = $this->app->make('database');
        $v = array($this->bID);
        $q = 'select * from btMajorcaSlickSliderEntries where bID = ?';
        $r = $db->query($q, $v);
        foreach ($r as $row) {
            $content .= $row['title'].' ';
            $content .= $row['description'].' ';
        }

        return $content;
    }

    public function add()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
    }

    public function edit()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
        $db = $this->app->make('database');
        $query = $db->GetAll('SELECT * from btMajorcaSlickSliderEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $this->set('rows', $query);
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
        $r = $db->GetAll('SELECT * from btMajorcaSlickSliderEntries WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        // in view mode, linkURL takes us to where we need to go whether it's on our site or elsewhere
        $rows = array();
        foreach ($r as $q) {
            if (!$q['linkURL'] && $q['internalLinkCID']) {
                $c = Page::getByID($q['internalLinkCID'], 'ACTIVE');
                $q['linkURL'] = $c->getCollectionLink();
                $q['linkPage'] = $c;
            }
            $q['description'] = LinkAbstractor::translateFrom($q['description']);
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
        $q = 'select * from btMajorcaSlickSliderEntries where bID = ?';
        $r = $db->query($q, $v);
        while ($row = $r->fetch()) {
            $db->executeQuery('INSERT INTO btMajorcaSlickSliderEntries (bID, fID, linkURL, title, description, sortOrder, internalLinkCID) values(?,?,?,?,?,?,?)',
                array(
                    $newBID,
                    $row['fID'],
                    $row['linkURL'],
                    $row['title'],
                    $row['description'],
                    $row['sortOrder'],
                    $row['internalLinkCID'],
                )
            );
        }
    }

    public function delete()
    {
        $db = $this->app->make('database');
        $db->delete('btMajorcaSlickSliderEntries', array('bID' => $this->bID));
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

    public function save($args)
    {
        $args += array(
            'timeout' => 4000,
            'speed' => 500,
        );
        $args['timeout'] = intval($args['timeout']);
        $args['speed'] = intval($args['speed']);
        $args['noAnimate'] = isset($args['noAnimate']) ? 1 : 0;
        $args['pause'] = isset($args['pause']) ? 1 : 0;
        $args['maxWidth'] = isset($args['maxWidth']) ? intval($args['maxWidth']) : 0;

		$args['infinite'] = isset($args['infinite']) ? 1 : 0;
        $args['fade'] = isset($args['fade']) ? 1 : 0;
        $args['centerMode'] = isset($args['centerMode']) ? 1 : 0;
        $args['centerPadding'] = isset($args['centerPadding']) ? intval($args['centerPadding']) : 0;
        $args['slidesToShow'] = isset($args['slidesToShow']) ? intval($args['slidesToShow']) : 0;
        $args['centerModeThumbNav'] = isset($args['centerModeThumbNav']) ? 1 : 0;

        $db = $this->app->make('database');
        $db->executeQuery('DELETE from btMajorcaSlickSliderEntries WHERE bID = ?', array($this->bID));
        parent::save($args);
        if (isset($args['sortOrder'])) {
            $count = count($args['sortOrder']);
            $i = 0;

            while ($i < $count) {
                $linkURL = $args['linkURL'][$i];
                $internalLinkCID = $args['internalLinkCID'][$i];
                switch (intval($args['linkType'][$i])) {
                    case 1:
                        $linkURL = '';
                        break;
                    case 2:
                        $internalLinkCID = 0;
                        break;
                    default:
                        $linkURL = '';
                        $internalLinkCID = 0;
                        break;
                }

                if (isset($args['description'][$i])) {
                    $args['description'][$i] = LinkAbstractor::translateTo($args['description'][$i]);
                }

                $db->executeQuery('INSERT INTO btMajorcaSlickSliderEntries (bID, fID, title, description, sortOrder, linkURL, internalLinkCID) values(?, ?, ?, ?,?,?,?)',
                    array(
                        $this->bID,
                        intval($args['fID'][$i]),
                        $args['title'][$i],
                        $args['description'][$i],
                        $args['sortOrder'][$i],
                        $linkURL,
                        $internalLinkCID,
                    )
                );
                ++$i;
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
