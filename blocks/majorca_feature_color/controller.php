<?php
namespace Concrete\Package\ThemeMajorca\Block\MajorcaFeatureColor;

use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\Html\Service\FontAwesomeIcon;
use Page;
use Concrete\Core\Block\BlockController;
use Less_Parser;
use Less_Tree_Rule;
use Core;

class Controller extends BlockController
{
    public $helpers = array('form');

    protected $btInterfaceWidth = 400;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btExportPageColumns = array('internalLinkCID');
    protected $btInterfaceHeight = 520;
    protected $btTable = 'btMajorcaFeatureColor';
    protected $btDefaultSet = 'theme_majorca';

    public function getBlockTypeDescription()
    {
        return t("Displays an icon, a title, and a short paragraph description.");
    }

    public function getBlockTypeName()
    {
        return t("Majorca Feature Color");
    }

    public function getLinkURL()
    {
        if (!empty($this->externalLink)) {
            return $this->externalLink;
        } else {
            if (!empty($this->internalLinkCID)) {
                $linkToC = Page::getByID($this->internalLinkCID);

                return (empty($linkToC) || $linkToC->error) ? '' : $this->app->make('helper/navigation')->getLinkToCollection(
                    $linkToC
                );
            } else {
                return '';
            }
        }
    }

    public function getParagraph()
    {
        return LinkAbstractor::translateFrom($this->paragraph);
    }

    public function getParagraphEditMode()
    {
        return LinkAbstractor::translateFromEditMode($this->paragraph);
    }

    public function registerViewAssets($outputContent = '')
    {
        $this->requireAsset('css', 'font-awesome');
        if (is_object($this->block) && $this->block->getBlockFilename() == 'hover_description') {
            // this isn't great but it's the only way to do this and still make block
            // output caching available to this block.
            $this->requireAsset('javascript', 'bootstrap/tooltip');
            $this->requireAsset('css', 'bootstrap/tooltip');
        }
    }

    public function add()
    {
        $this->edit();
    }

    public function view()
    {
        $this->set('paragraph', LinkAbstractor::translateFrom($this->paragraph));
        $this->set('linkURL', $this->getLinkURL());
    }

    protected function getIconClasses()
    {
        $icons = [];
        if (class_exists(FontAwesomeIcon::class)) {
            // V9
            $txt = $this->app->make('helper/text');
            $webfonts = [
                [
                    'prefix' => 'far',
                    'handle' => 'fa-regular-400',
                ],
                [
                    'prefix' => 'fas',
                    'handle' => 'fa-solid-900',
                ],
                [
                    'prefix' => 'fab',
                    'handle' => 'fa-brands-400',
                ],
            ];
            foreach ($webfonts as $webfont) {
                $webfontsvg = DIR_BASE_CORE . '/css/webfonts/' . $webfont['handle'] . '.svg';
                if (file_exists($webfontsvg)) {
                    $xml = simplexml_load_file($webfontsvg);
                    foreach ($xml->defs->font->glyph as $glyph) {
                        $icons[] = $webfont['prefix'] . ' fa-' . $glyph['glyph-name'];
                    }
                }
            }
        } else {
            // V8
            $iconLessFile = DIR_BASE_CORE . '/css/build/vendor/font-awesome/variables.less';
            if (file_exists($iconLessFile)) {
                $l = new Less_Parser();
                $parser = $l->parseFile($iconLessFile, false, true);
                $rules = $parser->rules;
                foreach ($rules as $rule) {
                    if (($rule instanceof Less_Tree_Rule) && strpos($rule->name, '@fa-var') === 0) {
                        $name = str_replace('@fa-var-', '', $rule->name);
                        $icons[] = $name;
                    }
                }
                asort($icons);
            }
        }
        return $icons;
    }

    public function edit()
    {
        $this->requireAsset('css', 'font-awesome');
        $this->requireAsset('core/colorpicker');
        $classes = $this->getIconClasses();

        // let's clean them up
        $icons = array('' => t('Choose Icon'));
        $txt = $this->app->make('helper/text');
        foreach ($classes as $class) {
            $icons[$class] = $txt->unhandle($class);
        }
        $this->set('icons', $icons);
    }

    public function getSearchableContent()
    {
        return $this->title . ' ' . $this->paragraph;
    }

    public function save($args)
    {
        switch (isset($args['linkType']) ? intval($args['linkType']) : 0) {
            case 1:
                $args['externalLink'] = '';
                break;
            case 2:
                $args['internalLinkCID'] = 0;
                break;
            default:
                $args['externalLink'] = '';
                $args['internalLinkCID'] = 0;
                break;
        }
        $args['paragraph'] = LinkAbstractor::translateTo($args['paragraph']);
        unset($args['linkType']);
        parent::save($args);
    }
}
