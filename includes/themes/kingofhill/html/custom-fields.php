<?php

if (!defined('ABSPATH')) die(-1);

if (!intval(get_option('pizzazz_show_custom_fields')))
    return;

?>
<?php if ($meta = get_post_meta($item->ID)): ?>

    <?php $triggered = false; ?>

    <?php $i = 0; ?>

    <?php foreach ($meta AS $label => $value): ?>

        <?php if (is_protected_meta($label, 'post')) continue; ?>

        <div class="custom-row clearfix">

            <div class="pz-custom-label"><span><?php echo $label ?></span></div>

            <div class="pz-custom-value"><?php echo $value[0] ?></div>

        </div>

        <?php $i++; ?>

    <?php endforeach; ?>

<?php endif; ?>