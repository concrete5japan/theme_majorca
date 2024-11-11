<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}

$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
$getString = $app->make('helper/validation/identifier')->getString(18);
$tabs = array(
    array('slides-'.$getString, t('Slides'), true),
    array('options-'.$getString, t('Options'))
);
echo $app->make('helper/concrete/ui')->tabs($tabs);
$id = $controller->getIdentifier();
?>
<script>
    var CCM_EDITOR_SECURITY_TOKEN = "<?php echo $app->make('helper/validation/token')->generate('editor'); ?>";
    <?php
    $editorJavascript = $app->make('editor')->outputStandardEditorInitJSFunction();
    ?>

    $(document).ready(function() {
        var tmeId = <?php echo $tmeId ?>;
        var ccmReceivingEntry = '';
        var testmonialEntriesContainer = $('.majorca-testimonial-carousel-entries-<?php echo $bID?>');
        var _templateSlide = _.template($('#testimonialCarouselTemplate-<?php echo $bID?>').html());

        var attachDelete = function($obj) {
            $obj.click(function() {
                var deleteIt = confirm('<?php echo t('Are you sure?'); ?>');
                if (deleteIt === true) {
                    var slideID = $(this).closest('.majorca-testimonial-carousel-entry').find('.editor-content').attr('id');

                    $(this).closest('.majorca-testimonial-carousel-entry-<?php echo $bID?>').remove();
                    doSortCount();
                }
            });
        };

        var attachFileManagerLaunch = function($obj) {
            $obj.click(function() {
                var oldLauncher = $(this);
                ConcreteFileManager.launchDialog(function(data) {
                    ConcreteFileManager.getFileDetails(data.fID, function(r) {
                        jQuery.fn.dialog.hideLoader();
                        var file = r.files[0];
                        oldLauncher.html(file.resultsThumbnailImg);
                        oldLauncher.next('.image-fID').val(file.fID);
                    });
                });
            });
        };

        var doSortCount = function() {
            $('.majorca-testimonial-carousel-entry-<?php echo $bID?>').each(function(index) {
                $(this).find('.majorca-testimonial-carousel-entry-sort').val(index);
            });
        };

        testmonialEntriesContainer.on('change', 'select[data-field=entry-link-select]', function() {
            var container = $(this).closest('.majorca-testimonial-carousel-entry-<?php echo $bID?>');
            switch (parseInt($(this).val())) {
                case 2:
                    container.find('div[data-field=entry-link-page-selector]').addClass('hide-slide-link').removeClass('show-slide-link');
                    container.find('div[data-field=entry-link-url]').addClass('show-slide-link').removeClass('hide-slide-link');
                    break;
                case 1:
                    container.find('div[data-field=entry-link-url]').addClass('hide-slide-link').removeClass('show-slide-link');
                    break;
                    container.find('div[data-field=entry-link-page-selector]').addClass('show-slide-link').removeClass('hide-slide-link');
                default:
                    container.find('div[data-field=entry-link-page-selector]').addClass('hide-slide-link').removeClass('show-slide-link');
                    container.find('div[data-field=entry-link-url]').addClass('hide-slide-link').removeClass('show-slide-link');
                    break;
            }
        });

        <?php if ($rows) {
            foreach ($rows as $row) {
               ?>
               testmonialEntriesContainer.append(_templateSlide({
                    tmeId: 0<?php echo intval($row['tmeId']); ?>,
                    fID: '<?php echo $row['fID']; ?>',
                    <?php if (File::getByID($row['fID'])) { ?>
                      image_url: '<?php echo File::getByID($row['fID'])->getThumbnailURL('file_manager_listing'); ?>',
                    <?php } else { ?>
                      image_url: '',
                    <?php } ?>
                    name: '<?php echo h($row['name']); ?>',
                    position: '<?php echo h($row['position']); ?>',
                    company: '<?php echo h($row['company']); ?>',
                    companyURL: '<?php echo h($row['companyURL']); ?>',
                    paragraph: '<?php echo h($row['paragraph']); ?>',
                    socialLink: <?php echo $row['socialLink'] ? $row['socialLink'] : $services; ?>,
                    sort_order: '<?php echo $row['sort_order']; ?>',
                }));
            <?php }
        } ?>

        doSortCount();
        testmonialEntriesContainer.find('select[data-field=entry-link-select]').trigger('change');

        $('.add-majorca-testimonial-carousel-entry-<?php echo $bID?>').click(function() {
            var thisModal = $(this).closest('.ui-dialog-content');
            testmonialEntriesContainer.append(_templateSlide({
                tmeId: ++tmeId,
                fID: '',
                image_url: '',
                name: '',
                position: '',
                company: '',
                companyURL: '',
                paragraph: '',
                socialLink: <?php echo $services ?>,
                sort_order: '',
            }));

            $('.majorca-testimonial-carousel-entry-<?php echo $bID?>').not('.slide-closed').each(function() {
                $(this).addClass('slide-closed');
                var thisEditButton = $(this).closest('.majorca-testimonial-carousel-entry-<?php echo $bID?>').find('.btn.ccm-edit-slide');
                thisEditButton.text(thisEditButton.data('slideEditText'));
            });
            var newSlide = $('.majorca-testimonial-carousel-entry-<?php echo $bID?>').last();
            var closeText = newSlide.find('.btn.ccm-edit-slide').data('slideCloseText');
            newSlide.removeClass('slide-closed').find('.btn.ccm-edit-slide').text(closeText);

            thisModal.scrollTop(newSlide.offset().top);
            attachDelete(newSlide.find('.delete-majorca-testimonial-carousel-entry-<?php echo $bID?>'));
            attachFileManagerLaunch(newSlide.find('.ccm-pick-slide-image'));
            doSortCount();
        });

        $('.majorca-testimonial-carousel-entries-<?php echo $bID?>').on('click','.ccm-edit-slide', function() {
            $(this).closest('.majorca-testimonial-carousel-entry-<?php echo $bID?>').toggleClass('slide-closed');
            var thisEditButton = $(this);
            if (thisEditButton.data('slideEditText') === thisEditButton.text()) {
                thisEditButton.text(thisEditButton.data('slideCloseText'));
            } else if (thisEditButton.data('slideCloseText') === thisEditButton.text()) {
                thisEditButton.text(thisEditButton.data('slideEditText'));
            }
        });

        $('.majorca-testimonial-carousel-entries-<?php echo $bID?>').sortable({
            placeholder: "ui-state-highlight",
            axis: "y",
            handle: "i.fa-arrows",
            cursor: "move",
            update: function() {
                doSortCount();
            }
        });

        attachDelete($('.delete-majorca-testimonial-carousel-entry-<?php echo $bID?>'));
        attachFileManagerLaunch($('.ccm-pick-slide-image-<?php echo $bID?>'));

        $('.majorca-testimonial-carousel-entries-<?php echo $bID?>').on('click','.social-toggle-button-<?php echo $bID?>', function(){
          var button = $(this);
          $('#' + button.data('id')).slideToggle(function(){
            if ($(this).is(':visible')) {
              button.children().css('color','#000000');
              $('#' + button.data('id') + '-chk').prop("value",1);

            }else{
              button.children().css('color','#999999');
              $('#' + button.data('id') + '-chk').prop("value",0);
            }
          });
        });
      });

</script>

<style>
    .majorca-testimonial-carousel-block-container input[type="text"],
    .majorca-testimonial-carousel-block-container textarea {
        display: block;
        width: 100%;
    }
    .majorca-testimonial-carousel-block-container .btn-success {
        margin-bottom: 20px;
    }
    .majorca-testimonial-carousel-entries {
        padding-bottom: 30px;
        position: relative;
    }
    .majorca-testimonial-carousel-block-container .slide-well {
        min-height: 20px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
    .ccm-pick-slide-image {
        padding: 5px;
        cursor: pointer;
        background: #dedede;
        border: 1px solid #cdcdcd;
        text-align: center;
        vertical-align: middle;
        width: 72px;
        height: 72px;
        display: table-cell;
    }
    .ccm-pick-slide-image img {
        max-width: 100%;
    }
    .majorca-testimonial-carousel-entry {
        position: relative;
    }
    .majorca-testimonial-carousel-entry.slide-closed .form-group {
        display: none;
    }

    .majorca-testimonial-carousel-entry .form-group {
        margin-left: 0px !important;
        margin-right: 0px !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
        border-bottom: none !important;
    }

    .majorca-testimonial-carousel-entry.slide-closed .form-group:first-of-type {
        display: block;
        margin-bottom: 0px;
    }
    .majorca-testimonial-carousel-entry.slide-closed .form-group:first-of-type label {
        display: none;
    }
    .btn.ccm-edit-slide {
        position: absolute;
        top: 10px;
        right: 127px;
    }
    .btn.ccm-delete-testmonial-entry {
        position: absolute;
        top: 10px;
        right: 41px;
    }
    .majorca-testimonial-carousel-block-container i:hover {
        color: #428bca;
    }
    .majorca-testimonial-carousel-block-container i.fa-arrows {
        position: absolute;
        top: 6px;
        right: 5px;
        cursor: move;
        font-size: 20px;
        padding: 5px;
    }
    .majorca-testimonial-carousel-block-container .ui-state-highlight {
        height: 94px;
        margin-bottom: 15px;
    }
    .majorca-testimonial-carousel-entries .ui-sortable-helper {
        -webkit-box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
        -moz-box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
        box-shadow: 0px 10px 18px 2px rgba(54,55,66,0.27);
    }
    .majorca-testimonial-carousel-block-container .show-slide-link {
        display: block;
    }
    .majorca-testimonial-carousel-block-container .hide-slide-link {
        display: none;
    }

    select {
	    padding-bottom: 3px;
    }
    .sns-url {
	    padding: 8px 10px;
    }

    .ccm-ui p.social-links-label {
	    margin-top: 5px;
	    margin-bottom: 5px;
        color: #4290be;
		font-weight: bold;
    }
</style>

<div id="ccm-tab-content-slides-<?php echo $getString?>" class="ccm-tab-content">
    <div class="majorca-testimonial-carousel-block-container">
        <div class="majorca-testimonial-carousel-entries majorca-testimonial-carousel-entries-<?php echo $bID?>">

        </div>
        <div>
            <button type="button" class="btn btn-success ccm-add-testmonial-entry add-majorca-testimonial-carousel-entry-<?php echo $bID?>"><?php echo t('Add Testmonial Item'); ?></button>
        </div>
    </div>
</div>

<div id="ccm-tab-content-options-<?php echo $getString?>" class="ccm-tab-content">
    <label class="control-label"><?php echo t('Navigation'); ?></label>
    <div class="form-group">
        <div class="radio">
			<label><input type="radio" name="<?php echo $view->field('navigationType'); ?>" value="0" <?php echo $navigationType > 0 ? '' : 'checked'; ?> /><?php echo t('Arrows'); ?></label>
		</div>
		<div class="radio">
			<label><input type="radio" name="<?php echo $view->field('navigationType'); ?>" value="1" <?php echo $navigationType == 1 ? 'checked' : ''; ?> /><?php echo t('Bullets'); ?></label>
		</div>
		<div class="radio">
			<label><input type="radio" name="<?php echo $view->field('navigationType'); ?>" value="2" <?php echo $navigationType == 2 ? 'checked' : ''; ?> /><?php echo t('Arrows & Bullets'); ?></label>
		</div>
    </div>
    <div class="form-group">
        <?php echo $form->label($view->field('timeout'), t('Slide Duration')); ?>
        <div class="input-group" style="width: 150px">
        <?php echo $form->number($view->field('timeout'), $timeout ? $timeout : 4000, array('min' => '1', 'max' => '99999'))?><span class="input-group-addon"><?php echo t('ms'); ?></span>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->label($view->field('speed'), t('Slide Transition Speed')); ?>
        <div class="input-group" style="width: 150px">
        <?php echo $form->number($view->field('speed'), $speed ? $speed : 500, array('min' => '1', 'max' => '99999'))?><span class="input-group-addon"><?php echo t('ms'); ?></span>
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
            <?php
            echo $form->checkbox($view->field('noAnimate'), 1, $noAnimate);
            echo t('Disable Automatic Slideshow');
            ?>
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
            <?php
            echo $form->checkbox($view->field('pause'), 1, $pause);
            echo t('Pause Slideshow on Hover');
            ?>
            </label>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->label($view->field('maxWidth'), t('Maximum Slide Width (0 means no limit)')); ?>
        <div class="input-group" style="width: 150px">
        <?php echo $form->number($view->field('maxWidth'), $maxWidth ? $maxWidth : 0, array('min' => '0', 'max' => '9999'))?><span class="input-group-addon"><?php echo t('px'); ?></span>
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
            <?php
            echo $form->checkbox($view->field('infinite'), 1, $infinite ? $infinite : 1);
            echo t('Infinite loop sliding');
            ?>
            </label>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->label($view->field('slidesToShow'), t('Number of item to show')); ?>
        <div class="input-group" style="width: 150px">
        <?php echo $form->number($view->field('slidesToShow'), $slidesToShow ? $slidesToShow : 3, array('min' => '1', 'max' => '4'))?>
        </div>
    </div>
</div>

<script type="text/template" id="testimonialCarouselTemplate-<?php echo $bID?>">
  <div class="majorca-testimonial-carousel-entry majorca-testimonial-carousel-entry-<?php echo $bID?> slide-well slide-closed" value="<%=tmeId%>">
    <input type="hidden" name="tmeId[]" value="<%=tmeId%>">
    <div class="form-group">
        <label class="control-label"><?php echo t('Image'); ?></label>
        <div class="ccm-pick-slide-image ccm-pick-slide-image-<?php echo $bID?>">
            <% if (image_url.length > 0) { %>
                <img src="<%= image_url %>" />
            <% } else { %>
                <i class="fa fa-picture-o"></i>
            <% } %>
        </div>
        <input type="hidden" name="<?php echo $view->field('fID'); ?>[]" class="image-fID" value="<%=fID%>" />
    </div>

    <div class="form-group">
        <label for="name-<%=tmeId%>" class="control-label"><?php echo t('Name'); ?></label>
        <input type="text" id="name-<%=tmeId%>" name="name[]" value="<%= name %>" class="form-control ccm-input-text">
    </div>

    <div class="form-group">
        <label for="position-<%=tmeId%>" class="control-label"><?php echo t('Position'); ?></label>
        <input type="text" id="position-<%=tmeId%>" name="position[]" value="<%= position %>" class="form-control ccm-input-text">
    </div>

    <div class="form-group">
        <label for="company-<%=tmeId%>" class="control-label"><?php echo t('Company'); ?></label>
        <input type="text" id="company-<%=tmeId%>" name="company[]" value="<%= company %>" class="form-control ccm-input-text">
    </div>

    <div class="form-group">
        <label for="companyURL-<%=tmeId%>" class="control-label"><?php echo t('Company URL'); ?></label>
        <input type="text" id="companyURL-<%=tmeId%>" name="companyURL[]" value="<%= companyURL %>" class="form-control ccm-input-text">
    </div>

    <div class="form-group">
        <label for="paragraph-<%-tmeId%>" class="control-label"><?php echo t('Bio/Quote'); ?></label>
        <textarea id="paragraph-<%=tmeId%>" name="paragraph[]" rows="5" class="form-control"><%= paragraph %></textarea>
    </div>

	<p class="social-links-label"><?php echo t('Choose Social Links to Show'); ?></p>

    <% _.each(socialLink, function(value,key) { %>
      <%
       var color ='#999999';
       if(value.isView == 1){
          color = "#000000";
      }%>
	  <a href="javascript:void(0)" class="social-toggle-button-<?php echo $bID?>" id="social-toggle-button-<?php echo $bID?>-<%=key%>-<%=tmeId%>" data-id="<%=key%>-container-<%=tmeId%>-<?php echo $bID?>"><i class="fa fa-<%=key%>" style="color:<%-color%>"></i></a>
    <% }); %>

    <% _.each(socialLink, function(value,key) { %>
      <%
       var hidden = 'none';
       if(value.isView == 1){
          hidden = '';
      }%>

      <div class="form-group" id="<%=key%>-container-<%=tmeId%>-<?php echo $bID?>" style="display:<%-hidden%>">
        <input type="hidden" id="<%=key%>-container-<%=tmeId%>-<?php echo $bID?>-name" name="socialLink[<%=key%>][viewName][]" value="<%-value.viewName %>">
        <input type="hidden" id="<%=key%>-container-<%=tmeId%>-<?php echo $bID?>-chk" name="socialLink[<%=key%>][isView][]" value="<%=value.isView %>"">
        <label for="<%=key%>-<%=tmeId%>" class="control-label"><%-value.viewName %></label>
        <input type="text" id="<%=key%>-<%=tmeId%>-<?php echo $bID?>" name="socialLink[<%=key%>][url][]" value="<%-value.url %> " class="form-control ccm-input-text">
      </div>
    <% }); %>

    <button type="button" class="btn btn-sm btn-default ccm-edit-slide ccm-edit-slide-<?php echo $bID?>" data-slide-close-text="<?php echo t('Collapse Testmonial Item'); ?>" data-slide-edit-text="<?php echo t('Edit Testmonial Item'); ?>"><?php echo t('Edit Testmonial Item'); ?></button>
    <button type="button" class="btn btn-sm btn-danger ccm-delete-testmonial-entry delete-majorca-testimonial-carousel-entry-<?php echo $bID?>"><?php echo t('Remove'); ?></button>
    <i class="fa fa-arrows"></i>
    <input class="majorca-testimonial-carousel-entry-sort" type="hidden" name="<?php echo $view->field('sortOrder'); ?>[]" value="<%=sort_order%>"/>
  </div>
</script>
