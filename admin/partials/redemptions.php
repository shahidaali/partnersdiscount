<div class="wrap">
	<h1><?php _e('Partners Redemptions'); ?></h1>

	<?php if( !empty($messages) ): ?>
		<div id="setting-error-settings_updated" class="notice notice-<?php echo $messages['status']; ?> settings-error is-dismissible"> 
			<p><strong><?php echo $messages['message']; ?></strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.') ?></span></button>
		</div>
	<?php endif; ?>

	<form action="" method="post">
		<table class="wp-list-table widefat fixed striped posts partners-table">
			<thead>
				<tr>
					<th><?php _e('ID') ?></th>
					<th><?php _e('Logo') ?></th>
					<th><?php _e('Name') ?></th>
					<th><?php _e('Redemptions') ?></th>
					<th><?php _e('Status') ?></th>
					<th><?php _e('Expiry') ?></th>
					<th><?php _e('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if ($partners->have_posts()) : 
				   $counter = 0;
				   while ($partners->have_posts()) : $partners->the_post();
				      $partner = new PartnersDiscount_Partner($partners->post);
				      ?>
				      <tr>
				      	<td><?php the_ID(); ?></td>
				      	<td><?php the_post_thumbnail(); ?></td>
				      	<td><?php the_title(); ?></td>
				      	<td><?php echo count(PartnersDiscount_Partner::get_redemptions(['partner_id' => get_the_ID()])->posts); ?></td>
				      	<td><?php _e($partner->post_status) ?></td>
				      	<td><?php echo $partner->get_partner_expiry() ?></td>
				      	<td><a href="<?php echo admin_url('post.php?post='.get_the_ID().'&action=edit') ?>" target="_blank">Edit</a></td>
				      </tr>
				      <?php
				   endwhile;
				   wp_reset_postdata();
				endif;
				?>
			</tbody>
		</table>
	</form>
</div>
