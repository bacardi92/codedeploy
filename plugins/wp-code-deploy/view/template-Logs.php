<div class="wrap">

	<h1><?php echo __( "Logs" ); ?></h1>

	<table class="form-table" id="logsWrapper">
		
		<tbody>

			<tr>
				<th>
					<?php echo __( "Select Logs File" ); ?>
				</th>
				<td>
					<?php if( isset( $logFiles ) && count( $logFiles ) ): ?>
						<select id="getLogFile">
							<?php foreach ( $logFiles as $filename => $filepath ): ?>
								<option value="<?php echo $filepath; ?>"
                                    <?php echo (date("Y-m").".log" == $filename)? 'selected': '';?>>
                                    <?php echo $filename; ?>
                                </option>
							<?php endforeach; ?>
						</select>
					<?php endif; ?>
				</td>
			</tr>

			<tr>
				<th>
					<?php echo __( "Logs Content" ); ?>
				</th>
				<td>
					<textarea class="wpcd_textarea large-text code"
                              rows="40"
                              cols="50"
                              name="wpcd_logs"
                              id="wpcd_logs"
                              readonly="true"><?php echo file_get_contents( WPCD_PLUGIN_LOGS_DIR.date( "Y-m" ).".log" ); ?></textarea>
				</td>
			</tr>

		</tbody>
	</table>
</div>