<?php

namespace pizzazz\includes\postmeta;

class PortfolioItemCustomFields
{
    static public function add()
    {
        if (intval(get_option('pizzazz_show_custom_fields')))
            add_meta_box(
                'postcustom',
                __('Custom Fields', 'pizzazz'),
                array(new static, 'displayMetaBox'),
                null,
                'normal',
                'core');
    }

    public function displayMetaBox(\WP_Post $post) {
        post_custom_meta_box($post);
    }

}