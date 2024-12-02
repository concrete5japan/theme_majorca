<?php defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
if ($c->isEditMode()) { ?>
	<div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
		<div style="padding: 80px 0px 0px 0px"><?php echo t('Google Map disabled in edit mode.')?></div>
	</div>
<?php  } else { ?>
	<?php  if( strlen($title)>0){ ?><div class="map-title"><h3><?php echo $title?></h3></div><?php  } ?>
	<div id="googleMapCanvas<?php echo $bID?>" class="googleMapCanvas" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>"></div>
	<p class="map-link"><a href="https://www.google.com/maps/place/<?php echo h($location) ?>/@<?php echo $latitude ?>,<?php echo $longitude ?>,15z" target="_blank" class="link-arrow"><?php echo t('View Larger Map'); ?></a></p>
<?php  } ?>

<?php
/*
    Note - this goes in here because it's the only way to preserve block caching for this block. We can't
    set these values through the controller
*/
?>

<script type="text/javascript">
    function googleMapInit<?php echo $bID?>() {
        try{
            var latlng = new google.maps.LatLng(<?php echo $latitude?>, <?php echo $longitude?>);
            var mapOptions = {
                zoom: <?php echo $zoom?>,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                scrollwheel: <?php echo !!$scrollwheel ? "true" : "false"?>,
                draggable: <?php echo !!$scrollwheel ? "true" : "false"?>,
                mapTypeControl: false,
                styles: [
						{
							"elementType": "all", "stylers": [{ "hue": "#2e3e24" }, { "saturation": "-80" }]
						}
				],

            };
            var map = new google.maps.Map(document.getElementById('googleMapCanvas<?php echo $bID?>'), mapOptions);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                icon : {
			        url : "<?php echo $view->getThemePath()?>/css/build/img/marker_olive.png",
			    },
			    animation: google.maps.Animation.DROP,
            });
        }catch(e){
            $("#googleMapCanvas<?php echo $bID?>").replaceWith("<p>Unable to display map: "+e.message+"</p>")}
    }
    $(function() {
        var t;
        var startWhenVisible = function (){
            if ($("#googleMapCanvas<?php echo $bID?>").is(":visible")){
                window.clearInterval(t);
                googleMapInit<?php echo $bID?>();
                return true;
            }
            return false;
        };
        if (!startWhenVisible()){
            t = window.setInterval(function(){startWhenVisible();},100);
        }
    });

function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

</script>
