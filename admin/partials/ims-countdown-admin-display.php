<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/amanwebexp/
 * @since      1.0.0
 * @package    Ims_Countdown
 * @subpackage Ims_Countdown/admin/partials
 */
?>

<div class="wrap">
	<h2>IMS Countdown Settings</h2>

	<form method="post" action="options.php">
		<?php settings_fields('imsc_settings');
		do_settings_sections('imsc_settings');
		wp_nonce_field('imsc_nonce_action', 'imsc_nonce');
		?>


		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="imsc_timezone">Select Time Zone</label></th>
				<td>
					<select name="imsc_timezone" id="imsc_timezone">
						<?php
						$sVal = get_option('imsc_timezone');
						if (!empty($imsc_config_timezone)) {
							foreach ($imsc_config_timezone as $key => $value) {
								echo '<option value="' . esc_attr($value) . '" ' . selected($sVal, $value, false) . '>' . esc_html($key) . '</option>';
							}
						} else {
							echo '<option value="">No timezones available</option>';
						}
						?>
					</select>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>