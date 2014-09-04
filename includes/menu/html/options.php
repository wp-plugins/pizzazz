<?php if (!defined('ABSPATH')) die(-1); ?>

<div class="wrap">
    <h2>Pizzazz Options</h2>

    <form action="options.php" method="post">
        <?php settings_fields('pizzazz-options'); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th>Subscription Email</th>
                <td>

                    <label for="pizzazz_subscriber_email">Email:</label>
                    <input type="text"
                           name="pizzazz_subscriber_email"
                           id="pizzazz_subscriber_email"
                           value="<?php echo get_option('pizzazz_subscriber_email'); ?>"
                        /><br /><br />
                    <span><em>If you have purchased a <strong>premium subscription</strong> from giveitpizzazz.com, enter your subscription email here to upgrade and receive commercial updates.</em></span>
                </td>
            </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>