<div class="wrap">
	<h1><?php _e('Partners Discount Settings'); ?></h1>

	<?php 
	$tokens = [
		"[PARTNER_NAME]",
		"[PARTNER_EXPIRY_DATE]",
		"[PARTNER_EMAIL]",
		"[TODAY_DATE]",
		"[USER_NAME]",
		"[USER_ID]",
		"[USER_MEMBERSHIP_CODE]",
	];
	?>

	<?php if( !empty($messages) ): ?>
		<div id="setting-error-settings_updated" class="notice notice-<?php echo $messages['status']; ?> settings-error is-dismissible"> 
			<p><strong><?php echo $messages['message']; ?></strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.') ?></span></button>
		</div>
	<?php endif; ?>

	<form action="" method="post">
		<div class="os-tabs">
			<ul>
				<!-- <li class="active"><a href="#tab-general">General</a></li> -->
				<li class="active"><a href="#tab-step-email">Email Settings</a></li>
			</ul>
		</div>
		<div class="os-tab-content" id="tab-general">
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Primary Color'); ?></th>
						<td>
						<input name="partnersdiscount[primary_color]" type="text"  value="<?php echo PartnersDiscount_Utill::get_option('primary_color', '#0071bc'); ?>" data-default-color="#0071bc" size="50" placeholder="" class="os-color-picker"></td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<div class="os-tab-content active" id="tab-step-email">
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Tokens'); ?> <small>(Useable in email templates and subjects)</small></th>
						<td><?php echo "<code>".implode('</code> <code>', $tokens)."</code>"; ?></small></td>
					</tr>
					<tr>
						<th colspan="2"><hr></th>
					</tr>
					<tr>
						<th colspan="2"><h2>User Email</h2></th>
					</tr>
					<tr>
						<th scope="row"><?php _e('Enable User Email'); ?></th>
						<td>
							<select name="partnersdiscount[enable_user_email]">
								<?php 
								echo PartnersDiscount_Utill::select_options([
									'yes' => 'Yes',
									'no' => 'No',
								], PartnersDiscount_Utill::get_option('enable_user_email', 'yes'));
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Subject'); ?></th>
						<td>
						<input name="partnersdiscount[client_email_subject]" type="text"  value="<?php echo PartnersDiscount_Utill::get_option('client_email_subject', ''); ?>" size="50" placeholder="Subject here"></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('User Email Template'); ?></th>
						<td>
							<?php 
							wp_editor( PartnersDiscount_Utill::get_option('client_email_template', ""), 'client_email_template', array( 
								    'textarea_name' => 'partnersdiscount[client_email_template]',
								    'media_buttons' => false,
								    'textarea_rows' => 8,
								    'media_buttons' => true
							) );
							?>
							<p><small>Tokens: <?php echo "<code>".implode('</code> <code>', $tokens)."</code>"; ?></small></p>
						</td>
					</tr>
					<tr>
						<th colspan="2"><hr></th>
					</tr>
					<tr>
						<th colspan="2"><h2>Partner Email</h2></th>
					</tr>
					<tr>
						<th scope="row"><?php _e('Enable Partber Email'); ?></th>
						<td>
							<select name="partnersdiscount[enable_partner_email]">
								<?php 
								echo PartnersDiscount_Utill::select_options([
									'yes' => 'Yes',
									'no' => 'No',
								], PartnersDiscount_Utill::get_option('enable_partner_email', 'yes'));
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Subject'); ?></th>
						<td>
						<input name="partnersdiscount[partner_email_subject]" type="text"  value="<?php echo PartnersDiscount_Utill::get_option('partner_email_subject', ''); ?>" size="50" placeholder="Subject here"></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Partner Email Template'); ?></th>
						<td>
							<?php 
							wp_editor( PartnersDiscount_Utill::get_option('partner_email_template', ""), 'partner_email_template', array( 
								    'textarea_name' => 'partnersdiscount[partner_email_template]',
								    'media_buttons' => false,
								    'textarea_rows' => 8,
								    'media_buttons' => true
							) );
							?>
							<p><small>Tokens: <?php echo "<code>".implode('</code> <code>', $tokens)."</code>"; ?></small></p>
						</td>
					</tr>
					<tr>
						<th colspan="2"><hr></th>
					</tr>
					<tr>
						<th colspan="2"><h2>Admin Email</h2></th>
					</tr>
					<tr>
						<th scope="row"><?php _e('Enable Admin Email'); ?></th>
						<td>
							<select name="partnersdiscount[enable_admin_email]">
								<?php 
								echo PartnersDiscount_Utill::select_options([
									'yes' => 'Yes',
									'no' => 'No',
								], PartnersDiscount_Utill::get_option('enable_admin_email', 'yes'));
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Admin Email'); ?></th>
						<td>
						<input name="partnersdiscount[admin_email]" type="email"  value="<?php echo PartnersDiscount_Utill::get_option('admin_email', ''); ?>" size="50" placeholder="mail@example.com"></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Subject'); ?></th>
						<td>
						<input name="partnersdiscount[admin_email_subject]" type="text"  value="<?php echo PartnersDiscount_Utill::get_option('admin_email_subject', ''); ?>" size="50" placeholder="Subject Here"></td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Admin Email Template'); ?></th>
						<td>
							<?php 
							wp_editor( PartnersDiscount_Utill::get_option('admin_email_template', ""), 'admin_email_template', array( 
								    'textarea_name' => 'partnersdiscount[admin_email_template]',
								    'media_buttons' => false,
								    'textarea_rows' => 8,
								    'media_buttons' => true
							) );
							?>
							<p><small>Tokens: <?php echo "<code>".implode('</code> <code>', $tokens)."</code>"; ?></small></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<p class="submit">
	    	<input type="hidden" name="partnersdiscount_options" value="1" />
	    	<input type="submit" class="button-primary" value="<?php _e('Submit'); ?>"/>
		</p>
	</form>
</div>
