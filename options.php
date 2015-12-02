<?php
add_action('admin_menu', 'botm_create_menu');

function botm_create_menu() {
    add_menu_page('Book of the Month Settings', 'General', 'administrator', __FILE__, 'botm_settings_age');
    add_action('admin_init', 'register_botm_settings');
}

function register_botm_settings() {
    register_setting('botm-settings-group', 'apikey');
}

function botm_settings_page() {
    ?>
    <div class="wrap">
        <h2>Book of the Month</h2>

        <form method="post" action="options.php">
            <?php settings_fields('botm-settings-group'); ?>
            <?php do_settings_sections('botm-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API Key</th>
                    <td><input type="text" name="apikey" value="<?php echo esc_attr(get_option('apikey')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}