<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



/* settings page menu */

function dm_rme_settings_menu()
{
	if ( 0 && is_multisite() && is_network_admin() && current_user_can('manage_network') ) // multisite suport delayed till next release
	{
		add_submenu_page(
			'plugins.php',
			esc_html__( 'Recovery Mode Email', 'custom-recovery-mode-email' ),
			esc_html__( 'Recovery Mode Email', 'custom-recovery-mode-email' ),
			'manage_options',
			'dm_rme_settings',
			'dm_rme_settings_page'
		);
	} 
	else if ( current_user_can('manage_options') )
	{
		add_submenu_page(
			'options-general.php',
			esc_html__( 'Recovery Mode Email', 'custom-recovery-mode-email' ),
			esc_html__( 'Recovery Mode Email', 'custom-recovery-mode-email' ),
			'manage_options',
			'dm_rme_settings',
			'dm_rme_settings_page'
		);
	}
}


if ( 0 && is_multisite() && is_network_admin() && current_user_can('manage_network') ) // multisite suport delayed till next release
{ 
	add_action('network_admin_menu', 'dm_rme_settings_menu'); 
} 
else if ( current_user_can('manage_options') )
{ 
	add_action( 'admin_menu', 'dm_rme_settings_menu' ); 
}



/* update values */

function dm_rme_settings_page() 
{
	$fields_number = 4;
	
	if ( !empty($_POST) && check_admin_referer('dm_rme_wpnonce') && ( current_user_can('manage_options') || current_user_can('manage_network') ) ) 
	{
		if ( isset($_POST['option_page']) && sanitize_text_field($_POST['option_page']) == 'dm_rme_settings' )
		{
			if ( isset($_POST['action']) && sanitize_text_field($_POST['action']) == 'update' )
			{
				if ( isset($_POST['dm-rme-options']) && !empty($_POST['dm-rme-options']) && count($_POST['dm-rme-options']) == $fields_number )
				{
					$dm_rme_options = array();
					$dm_rme_options['recovery-mode-mail-sender-name']  = isset( $_POST['dm-rme-options']['recovery-mode-mail-sender-name'] )  ? sanitize_text_field( $_POST['dm-rme-options']['recovery-mode-mail-sender-name'] ) : null;
					$dm_rme_options['recovery-mode-mail-sender-email'] = isset( $_POST['dm-rme-options']['recovery-mode-mail-sender-email'] ) ? sanitize_email( $_POST['dm-rme-options']['recovery-mode-mail-sender-email'] ) : null;
					$dm_rme_options['recovery-mode-email']             = isset( $_POST['dm-rme-options']['recovery-mode-email'] )             ? sanitize_email( $_POST['dm-rme-options']['recovery-mode-email'] ) : null;
					$dm_rme_options['recovery-mode-email-rate-limit']  = isset( $_POST['dm-rme-options']['recovery-mode-email-rate-limit'] )  ? (float) $_POST['dm-rme-options']['recovery-mode-email-rate-limit'] : null;
					if ( !$dm_rme_options['recovery-mode-email-rate-limit'] ) $dm_rme_options['recovery-mode-email-rate-limit'] = null; // (float) sets null to 0, but we want null

					if ( ( empty($dm_rme_options['recovery-mode-email']) || sanitize_email($dm_rme_options['recovery-mode-email']) ) &&
							 ( empty($dm_rme_options['recovery-mode-email-rate-limit']) || is_numeric($dm_rme_options['recovery-mode-email-rate-limit']) ) &&
							 ( empty($dm_rme_options['recovery-mode-mail-sender-name']) || sanitize_text_field($dm_rme_options['recovery-mode-mail-sender-name']) ) &&
							 ( empty($dm_rme_options['recovery-mode-mail-sender-email']) || sanitize_email($dm_rme_options['recovery-mode-mail-sender-email']) ) 
							 )
					{
						update_option('dm-rme-options', $dm_rme_options);
						echo '<div class="updated" data-update-details="progress-1"><p>'. esc_html__( 'Your preferences have been saved!', 'custom-recovery-mode-email' ) .'</p></div>';
					}
					else
					{
						echo '<div class="error" data-update-details="progress-1"><p>'. esc_html__( 'Error: The data you have entered is not valid!', 'custom-recovery-mode-email' ) .'</p></div>';
					}
				}
			}
		}
	}


/* get values */

	$dm_rme_values = '';
	$dm_rme_values = get_option('dm-rme-options', null);

	$recovery_mode_email             = '';
	$recovery_mode_email_rate_limit  = '';
	$recovery_mode_mail_sender_name  = '';
	$recovery_mode_mail_sender_email = '';

	if ( $dm_rme_values != null )
	{ 
		$recovery_mode_email             = $dm_rme_values['recovery-mode-email'];
		$recovery_mode_email_rate_limit  = $dm_rme_values['recovery-mode-email-rate-limit'];
		$recovery_mode_mail_sender_name  = $dm_rme_values['recovery-mode-mail-sender-name'];
		$recovery_mode_mail_sender_email = $dm_rme_values['recovery-mode-mail-sender-email'];
	}



/* settings page */

?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Custom Recovery Mode Email Settings', 'custom-recovery-mode-email' ) ?></h1>
	<hr class="wp-header-end">

	<form method="POST">

		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="option_page" value="dm_rme_settings" />
		<?php wp_nonce_field( 'dm_rme_wpnonce' ); ?>

		<h2><?php esc_html_e( 'Recovery Mode Email', 'custom-recovery-mode-email' ) ?></h2>
		<p><?php esc_html_e( 'Set the recipient address which will be used when WordPress sends an email if a Fatal Error occurred.', 'custom-recovery-mode-email' ) ?></p>

		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="dm-rme-options[recovery-mode-email]"><?php esc_html_e( 'Recipient Address', 'custom-recovery-mode-email' ) ?></label></th>
					<td>
						<input type="email" class="regular-text" name="dm-rme-options[recovery-mode-email]" id="dm-rme-options[recovery-mode-email]" aria-describedby="recovery-mode-email-desc" value="<?php echo $recovery_mode_email; ?>" placeholder="<?php esc_html_e( 'recipient', 'custom-recovery-mode-email' ) ?>@<?php echo $_SERVER['HTTP_HOST']; ?>">
						<p class="description" id="recovery-mode-email-desc"><?php esc_html_e( 'Ex. name', 'custom-recovery-mode-email' ) ?>@<?php echo $_SERVER['HTTP_HOST'];  ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<br class="clear">

		<h2><?php esc_html_e( 'Recovery Mode Email Rate Limit', 'custom-recovery-mode-email' ) ?></h2>
		<p><?php esc_html_e( 'Set the rate limit between sending new recovery mode email links.', 'custom-recovery-mode-email' ) ?></p>

		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="dm-rme-options[recovery-mode-email-rate-limit]"><?php esc_html_e( 'Number of days', 'custom-recovery-mode-email' ) ?></label></th>
					<td>
						<input type="number" step="any" name="dm-rme-options[recovery-mode-email-rate-limit]" id="dm-rme-options[recovery-mode-email-rate-limit]" aria-describedby="recovery-mode-email-rate-limit-desc" value="<?php echo $recovery_mode_email_rate_limit; ?>" placeholder="1">
						<p class="description" id="recovery-mode-email-rate-limit-desc"><?php printf ( __( 'Choose the number of days. If you prefer a shorter time, you can set the interval to: <em>1 hour = 0.04166</em> or <em>1 minute = 0.0006945</em>.', 'custom-recovery-mode-email' ) ) ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<br class="clear">

		<h2><?php esc_html_e( 'Mail Sender Settings', 'custom-recovery-mode-email' ) ?></h2>
		<p><?php esc_html_e( 'Set default Sender Name and Email.', 'custom-recovery-mode-email' ) ?></p>

		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="dm-rme-options[recovery-mode-mail-sender-name]"><?php esc_html_e( 'Mail Sender Name', 'custom-recovery-mode-email' ) ?></label></th>
					<td>
						<input type="text" class="regular-text" name="dm-rme-options[recovery-mode-mail-sender-name]" id="dm-rme-options[recovery-mode-mail-sender-name]" aria-describedby="recovery-mode-mail-sender-name-desc" value="<?php echo $recovery_mode_mail_sender_name; ?>" placeholder="<?php esc_html_e( 'Website Name', 'custom-recovery-mode-email' ) ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="dm-rme-options[recovery-mode-mail-sender-email]"><?php esc_html_e( 'Mail Sender Email', 'custom-recovery-mode-email' ) ?></label></th>
					<td>
						<input type="email" class="regular-text" name="dm-rme-options[recovery-mode-mail-sender-email]" id="dm-rme-options[recovery-mode-mail-sender-email]" aria-describedby="recovery-mode-mail-sender-email-desc" value="<?php echo $recovery_mode_mail_sender_email; ?>" placeholder="<?php esc_html_e( 'sender', 'custom-recovery-mode-email' ) ?>@<?php echo $_SERVER['HTTP_HOST']; ?>">
						<p class="description" id="recovery-mode-mail-sender-email-desc"><?php esc_html_e( 'Ex. name', 'custom-recovery-mode-email' ) ?>@<?php echo $_SERVER['HTTP_HOST']; ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<br class="clear">

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'custom-recovery-mode-email' ) ?>">
		</p>

		<br class="clear">

	</form>

<br class="clear">
</div>

<?php 
}

