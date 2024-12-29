<?php defined('C5_EXECUTE') or die("Access Denied.");
if (!isset($app)) {
    $app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
}
?>


<?php
$fo = null;
if ($fID > 0) {
    $fo = File::getByID($fID);
}
?>

<div class="form-group">
    <?php echo $form->label('fID', t('Picture'));?>
    <?php
    $al = $app->make('helper/concrete/asset_library');
    echo $al->file('ccm-b-file', 'fID', t('Choose File'), $fo);
    ?>
</div>

<div class="form-group">
    <?php echo $form->label('name', t('Name'));?>
    <?php echo $form->text('name', $name)?>
</div>

<div class="form-group">
    <?php echo $form->label('position', t('Position'));?>
    <?php echo $form->text('position', $position)?>
</div>

<div class="form-group">
    <?php echo $form->label('company', t('Company'));?>
    <?php echo $form->text('company', $company)?>
</div>

<div class="form-group">
    <?php echo $form->label('companyURL', t('Company URL'));?>
    <?php echo $form->text('companyURL', $companyURL)?>
</div>

<div class="form-group">
    <?php echo $form->label('paragraph', t('Bio/Quote')) ?>
    <?php echo $form->textarea('paragraph', $paragraph, array('rows' => 5))?>
</div>

<p style="margin-top: 5px; margin-bottom: 5px; color: #4290be; font-weight: bold;"><?php echo t('Choose Social Links to Show'); ?></p>

<?php
$socialLinks = json_decode($socialLink,true);
$services = count($socialLinks) ? $socialLinks : $services;

foreach($services as $key => $service){
  $color ='#999999';
  if($service['isView'] == 1){
    $color = "#000000";
  } ?>
  <a href="javascript:void(0)" class="social-toggle-button-<?php echo $bID?>" id="social-toggle-button-<?php echo $bID?>-<?php echo h($key);?>" data-id="<?php echo h($key);?>-container-<?php echo $bID?>"><i class="fa fa-<?php echo h($key); ?>" style="color:<?php echo $color?>"></i></a>
<?php }

foreach($services as $key => $service){
  $hidden = 'none';
  if($service['isView'] == 1){
    $hidden = '';
  } ?>

  <div class="form-group" id="<?php echo h($key);?>-container-<?php echo $bID?>" style="display:<?php echo h($hidden) ?>">
    <input type="hidden" id="<?php echo h($key);?>-container-<?php echo $bID?>-name" name="socialLink[<?php echo h($key);?>][viewName]" value="<?php echo h($service['viewName']);?>">
    <input type="hidden" id="<?php echo h($key);?>-container-<?php echo $bID?>-chk" name="socialLink[<?php echo h($key);?>][isView]" value="<?php echo h($service['isView']);?>">
    <label for="<?php echo h($key);?>" class="control-label"><?php echo h($service['viewName']); ?></label>
    <input type="text" id="<?php echo h($key);?>-<?php echo $bID?>" name="socialLink[<?php echo h($key);?>][url]" value="<?php echo h($service['url']);?>" class="form-control ccm-input-text">
  </div>
<?php } ?>

<script>
$('.social-toggle-button-<?php echo $bID?>').on('click', function(){
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
});</script>
