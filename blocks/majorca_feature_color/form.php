<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
/** @var \Concrete\Block\Feature\Controller $controller */
/** @var \Concrete\Core\Form\Service\Form $form */
$bID = $bID ?? 0;
$icon = $icon ?? '';
$title = $title ?? '';
$titleFormat = $titleFormat ?? '';
$internalLinkCID = $internalLinkCID ?? 0;
$externalLink = $externalLink ?? '';
$colorPicker = $colorPicker ?? '';
?>

<fieldset>
    <legend><?php echo t('Display'); ?></legend>
    <div class="form-group ccm-block-select-icon">
        <?php echo $form->label('icon', t('Icon'))?>
        <div id="ccm-icon-selector-<?= h($bID) ?>">
            <icon-selector name="icon" selected="<?= h($icon) ?>" title="<?= t('Choose Icon') ?>" empty-option-label="<?= h(tc('Icon', '** None Selected')) ?>" />
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $("#colorPicker").spectrum({
                    "color":"<?php echo $colorPicker != "" ? $colorPicker: 'rgb(0,0,0)'; ?>",
                    "flat": true,
                    "appendTo":"body",
                    "containerClassName":"",
                    "replacerClassName":"",
                    "flat":false,"showInput":true,
                    "allowEmpty":false,
                    "showButtons":true,
                    "clickoutFiresChange":true,
                    "showInitial":true,
                    "showPalette":true,
                    "showPaletteOnly":false,
                    "hideAfterPaletteSelect":false,
                    "togglePaletteOnly":true,
                    "showSelectionPalette":false,
                    "localStorageKey":false,
                    "preferredFormat":'rgb',
                    "showAlpha":true,
                    "disabled":false,
                    "maxSelectionSize":7,
                    "cancelText":"<?php echo t('Cancel')?>",
                    "chooseText":"<?php echo t('Choose')?>",
                    "togglePaletteMoreText":"more",
                    "togglePaletteLessText":"less",
                    "clearText":"Clear Color Selection",
                    "noColorSele0ctedText":"No Color Selected",
                    "theme":"sp-light","selectionPalette":[],
                    "offset":null,
                    hide: function(color) {
                       $('.sp-container').hide();
                    },
                    beforeShow: function(tinycolor) {
                        $('.sp-container').show();
                    },"palette":[["#ffffff","#000000","#ff0000","#ff8000","#ffff00","#008000","#0000ff","#4b0082","#9400d3"]]});
        });
    </script>


    <div class="form-group">
        <?php  echo $form->label("colorPicker", t("Icon Color Picker")); ?>
        <p style="font-size: .8em; line-height: 1.2;"><i class="fas fa-asterisk"></i> <?php  echo t("Please pick up a color in the picker or input in RGB color values.<br>For example: rgb(0, 0, 255)"); ?></p>
        <?php  echo isset($btFieldsRequired) && in_array('colorPicker', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
        <div><?php  echo $form->text("colorPicker", $colorPicker, array (
      'placeholder' => NULL,
    )); ?></div>
    </div>

    <div class="form-group">
        <?php echo $form->label('title', t('Title')); ?>
        <?php echo $form->text('title', $title); ?>
    </div>

    <div class="form-group">
        <?php echo $form->label('paragraph', t('Paragraph:'));?>
        <?php
        $editor = Core::make('editor');
        echo $editor->outputBlockEditModeEditor('paragraph', $controller->getParagraphEditMode());
        ?>
    </div>

</fieldset>

<fieldset>
    <legend><?php echo t('Link'); ?></legend>

    <div class="form-group">
        <select name="linkType" data-select="feature-link-type" class="form-control">
            <option value="0" <?php echo (empty($externalLink) && empty($internalLinkCID) ? 'selected="selected"' : ''); ?>><?php echo t('None'); ?></option>
            <option value="1" <?php echo (empty($externalLink) && !empty($internalLinkCID) ? 'selected="selected"' : ''); ?>><?php echo t('Another Page'); ?></option>
            <option value="2" <?php echo (!empty($externalLink) ? 'selected="selected"' : ''); ?>><?php echo t('External URL'); ?></option>
        </select>
    </div>

    <div data-select-contents="feature-link-type-internal" style="display: none;" class="form-group">
        <?php echo $form->label('internalLinkCID', t('Choose Page:')); ?>
        <?php echo $app->make('helper/form/page_selector')->selectPage('internalLinkCID', $internalLinkCID); ?>
    </div>

    <div data-select-contents="feature-link-type-external" style="display: none;" class="form-group">
        <?php echo $form->label('externalLink', t('URL')); ?>
        <?php echo  $form->text('externalLink', $externalLink); ?>
    </div>

</fieldset>

<script type="text/javascript">
$(function() {
    Concrete.Vue.activateContext('cms', function(Vue, config) {
        new Vue({
            el: '#ccm-icon-selector-<?= h($bID) ?>',
            components: config.components
        })
    })
    $('select[data-select=feature-link-type]').on('change', function() {
       if ($(this).val() == '0') {
           $('div[data-select-contents=feature-link-type-internal]').hide();
           $('div[data-select-contents=feature-link-type-external]').hide();
       }
       if ($(this).val() == '1') {
           $('div[data-select-contents=feature-link-type-internal]').show();
           $('div[data-select-contents=feature-link-type-external]').hide();
       }
       if ($(this).val() == '2') {
           $('div[data-select-contents=feature-link-type-internal]').hide();
           $('div[data-select-contents=feature-link-type-external]').show();
       }
    }).trigger('change');
});
</script>

<style type="text/css">
    div.ccm-block-feature-select-icon {
        position: relative;
    }
    div.ccm-block-feature-select-icon i {
        position: absolute;
        right: -25px;
        top: 10px;
    }
    [data-preview="icon"] {
        font-size: 50px;
    }
</style>
