<div class="wrap">

	<h1><?php echo __("Deploy"); ?></h1>

    <hr class="wp-header-end">

    <h2><?php echo __( "Quick Deploy" ); ?></h2>

    <table class="form-table">

        <tbody>

            <tr>
                <th scope="row">
                    <label for="commit_id_q"><?php echo __("Commit ID"); ?></label>
                </th>
                <td>
                    <input class="regular-text"
                           id="commit_id_q"
                           type="text"
                           name="commit_id">
                    <p class="description">
                        <?php echo __("Place commit hash here."); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <input class="button button-primary"
                           id="quickDeploy"
                           type="submit"
                           name="quick_deploy"
                           value="Quick Deploy">
                </th>
            </tr>

        </tbody>

    </table>

    <h2><?php echo __( "Deploy with test environment" ); ?></h2>
    <table class="form-table">

        <tbody>

        <tr>
            <th scope="row">
                <label for="commit_id_t"><?php echo __("Commit ID"); ?></label>
            </th>
            <td>
                <input class="regular-text"
                       id="commit_id_t"
                       type="text"
                       name="commit_id">
                <p class="description">
                    <?php echo __("Place commit hash here."); ?>
                </p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="test_folder"><?php echo __("Test Folder"); ?></label>
            </th>
            <td>
                <input class="regular-text"
                       id="test_folder"
                       type="text"
                       name="test_folder">
                <p class="description">
                    <?php echo __("Will be created in Wordpress root folder."); ?>
                </p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <input class="button button-primary"
                       id="startDeploy"
                       type="submit"
                       name="start_deploy"
                       value="Start Deploy">
            </th>
        </tr>

        </tbody>

    </table>
</div>