<?php if (!defined('ABSPATH')) die(-1); ?>

<div class="wrap">

    <h2>Pizzazz Options</h2>

    <form action="options.php" method="post">

        <?php settings_fields('pizzazz-options'); ?>

        <table class="form-table">

            <tbody>

            <tr>
                <th>Show social share icons</th>
                <td>

                    <label><input type="radio" name="pizzazz_show_social_share" value="1"
                            <?php if (intval(get_option('pizzazz_show_social_share'))) echo 'checked="checked"'; ?>/>
                        <span>Yes</span></label>

                    <label><input type="radio" name="pizzazz_show_social_share" value="0"
                            <?php if (!intval(get_option('pizzazz_show_social_share'))) echo 'checked="checked"'; ?>/>
                        <span>No</span></label>

                </td>
            </tr>

            </tbody>

        </table>

        <?php submit_button(); ?>

    </form>

</div>