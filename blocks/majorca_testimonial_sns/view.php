<?php
defined('C5_EXECUTE') or die("Access Denied.");
$noAvatarSrc = $this->getBlockURL(). '/img/avatar_none.png';
$image = $image ?? '';
?>
<div class="ccm-block-testimonial-wrapper">
    <div class="ccm-block-testimonial">
        <?php if ($image): ?>

            <div class="ccm-block-testimonial-image"><?php echo $image ?></div>
        <?php else: ?>
        	<div class="ccm-block-testimonial-image"><img src="<?php echo $noAvatarSrc; ?>" alt="No Avatar"></div>
        <?php endif; ?>

        <div class="ccm-block-testimonial-text">

            <div class="ccm-block-testimonial-name">
                <?php echo h($name)?>
            </div>

        <?php if ($position && $company && $companyURL): ?>
            <div class="ccm-block-testimonial-position">
                <?php echo t('%s, <a href="%s">%s</a>', h($position), $companyURL, h($company))?>
            </div>
        <?php endif; ?>

        <?php if ($position && !$company && $companyURL): ?>
            <div class="ccm-block-testimonial-position">
                <?php echo t('<a href="%s">%s</a>', $companyURL, h($position))?>
            </div>
        <?php endif; ?>

        <?php if ($position && $company && !$companyURL): ?>
            <div class="ccm-block-testimonial-position">
                <?php echo t('%s, %s', h($position), h($company))?>
            </div>
        <?php endif; ?>

        <?php if ($position && !$company && !$companyURL): ?>
            <div class="ccm-block-testimonial-position">
                <?php echo h($position)?>
            </div>
        <?php endif; ?>

        <?php if ($paragraph): ?>
            <div class="ccm-block-testimonial-paragraph"><?php echo h($paragraph)?></div>
        <?php endif; ?>


        		<ul class="testimonial-sns list-inline">
              <?php
                $socialLinks = json_decode($socialLink,true);
                if(is_array($socialLinks)){
                  foreach($socialLinks as $key => $service){
                    if($service['isView']){ ?>
                      <li><a href="<?php echo h($service['url']); ?>" class="testimonial-circle-icon"><i class="fab fa-<?php echo h($key);?>"></i></a></li>
                    <?php }
                  }
                }
               ?>
            </ul>
        </div>
    </div>
</div>
