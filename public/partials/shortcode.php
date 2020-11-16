<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    PartnersDiscount
 * @subpackage PartnersDiscount/public/partials
 */

$items = "";

if ($arr_posts->have_posts()) : 

   $counter = 0;

   ob_start();
   while ($arr_posts->have_posts()) : $arr_posts->the_post();
      $partner = new PartnersDiscount_Partner($arr_posts->post);

      if($partner->is_expired()) {
         continue;
      }
      ?>
      <div class="partner-item clearfix">
         <div class="partner-thumb">
            <?php the_post_thumbnail() ?>
         </div>
         <div class="partner-detail">
            <?php the_content() ?>
         </div>
         <div class="partner-button">
            <button type="button" class="btn btn-primary partner-redeem-btn" data-id="<?php echo get_the_ID(); ?>"><?php _e($button_text); ?></button>
         </div>
      </div>
      <?php
   endwhile;
   $items = ob_get_clean();
   wp_reset_postdata();
endif;
?>

<div class="partners-wrapper">
   <div class="partner-items clearfix">
      <?php echo $items; ?>
   </div>
</div>
