<div class="wrap">

	<h1><?php echo __( "Settings" ); ?></h1>

	<hr class="wp-header-end">

	<form action="" id="wpcd_settings_form" method="POST">

		<h2><?php echo __( "Local Git User" ); ?></h2>

		<table class="form-table">
			
			<tbody>

<!--User Name Settings Field-->
				<tr>
					<th scope="row">
						<label for="wpcd_user_name">
                            <?php echo __( "Git User Name" ); ?><b>*</b>
                        </label>
					</th>
					<td>
						<input type="text"
                               class="wpcd_input regular-text"
                               id="wpcd_user_name"
                               name="wpcd_user_name"
                               value="<?php echo get_option( "_wpcd_username" ); ?>">
						<p class="description">
                            <?php echo __( "Your Git username" )?>
                        </p>
					</td>
				</tr>

<!--User Email Settings Field-->
				<tr>
					<th scope="row">
						<label for="wpcd_user_email">
                            <?php echo __( "Git User Email" ); ?><b>*</b>
                        </label>
					</th>
					<td>
						<input type="email"
                               class="wpcd_input regular-text"
                               id="wpcd_user_email"
                               name="wpcd_user_email"
                               value="<?php echo get_option( "_wpcd_useremail" ); ?>">
						<p class="description">
                            <?php echo __( "Your Git email" )?>
                        </p>
					</td>
				</tr>

<!--Git Repository Path Settings Field-->
                <tr>
                    <th scope="row">
                        <label for="wpcd_repository_path">
                            <?php echo __( "Git Repository Path" ); ?><b>*</b>
                        </label>
                    </th>
                    <td>
                        <input type="text"
                               class="wpcd_input regular-text"
                               id="wpcd_repository_path"
                               name="wpcd_repository_path"
                               value="<?php echo get_option( "_wpcd_repository" ); ?>">
                        <p class="description">
                            <?php echo __( "Git Repository Path" )?>
                        </p>
                    </td>
                </tr>

			</tbody>

		</table>

        <h2><?php echo __( "Connection Type" ); ?></h2>

		<table class="form-table">

			<tbody>

				<tr>
					<th scope="row">
						<label for="ConnectionTypeHttps">
                            <?php echo __( "HTTPS" ); ?><b>*</b>
                        </label>
					</th>
					<td>
                        <input type="radio"
                               name="wpcd_connection_type"
                               class="connection_type"
                               id="ConnectionTypeHttps"
                               value="https"
                               <?php echo (get_option('_wpcd_connection') == 'https')? 'checked' : ''?>
                               <?php echo (get_option('_wpcd_connection') === FALSE)? 'checked' : ''?>>
						<p class="description">
                            <?php echo __("Use HTTPS Connection Type"); ?>
                        </p>
					</td>
				</tr>
                <tr>
                    <th scope="row">
                        <label for="ConnectionTypeSsh">
                            <?php echo __( "SSH" ); ?><b>*</b>
                        </label>
                    </th>
                    <td>
                        <input type="radio"
                               name="wpcd_connection_type"
                               class="connection_type"
                               id="ConnectionTypeSsh"
                               value="ssh"
                               <?php echo (get_option('_wpcd_connection') == 'ssh')? 'checked' : ''?>>
                        <p class="description">
                            <?php echo __("Use SSH Connection Type"); ?>
                        </p>
                    </td>
                </tr>

			</tbody>

		</table>
        <table class="form-table" >
            <tbody>
                <tr>
                    <td colspan="2">
                        <input type="submit"
                               class="wpcd_submit button button-primary button-large"
                               id="save_user_data"
                               value="Save User">
                    </td>
                </tr>
            </tbody>
        </table>

        <h2><?php echo __( "HTTPS Credentials" ); ?></h2>

        <table class="form-table" >
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="git_user_name">
                            <?php echo __( "Git User Email" ); ?><b>*</b>
                        </label>
                    </th>
                    <td>
                        <input type="text"
                               name="git_user_name"
                               id="git_user_name"
                               class="wpcd_input regular-text"
                               value="<?php echo get_option( "_wpcd_creds_username" ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="git_user_password">
                            <?php echo __( "Git User Password" ); ?><b>*</b>
                        </label>
                    </th>
                    <td>
                        <input type="password"
                               name="git_user_password"
                               id="git_user_password"
                               class="wpcd_input regular-text"
                               value="<?php echo get_option( "_wpcd_creds_password" ); ?>">
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="form-table" >
            <tbody>
            <tr>
                <td colspan="2">
                    <input type="submit"
                           class=" button button-primary button-large"
                           id="save_credentials"
                           value="Save Credentials">
                </td>
            </tr>
            </tbody>
        </table>
        <h2><?php echo __( "SSH Keys" ); ?></h2>

		<table class="form-table">
	
			<tbody>
	
				<tr>
					<th scope="row">
						<label for="wpcd_public_key">
                            <?php echo __( "Public RSA Key" ); ?><b>*</b>
                        </label>
					</th>
					<td>
						<textarea class="wpcd_textarea large-text code"
                                  rows="10"
                                  cols="50"
                                  name="wpcd_public_key"
                                  id="wpcd_public_key"
                                  readonly="true"><?php echo $public; ?>
                        </textarea>
						<p class="description">
                            <?php echo __( "Your public ssh key, put it on <a href='https://github.com'><i>Github</i></a> or <a href='https://bitbucket.org/'><i>Bitbucket</i></a>" )?> for connect via SSH.
                        </p>
					</td>
				</tr>

			</tbody>

		</table>

        <table class="form-table" >
            <tbody>
            <tr>
                <td colspan="2">
                    <input type="submit"
                           class="wpcd_test_connection button button-primary button-large"
                           id="wpcd_test_connection"
                           value="Test connection">
                </td>
            </tr>
            </tbody>
        </table>

	</form>

</div>