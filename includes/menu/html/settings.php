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


                <h3>What sort of settings does Pizzazz Premium have?</h3>

                    <img src="<?php echo plugins_url(); ?>/pizzazz/assets/images/premiumSettings.png" width="527"/>
<br /><br />
        <a href="http://giveitpizzazz.com/portfolio-plugin-wordpress?utm_source=Free%20Plugin%20Settings&utm_medium=copy&utm_campaign=plugin" class="button-primary">Take the Tour</a>


</div>