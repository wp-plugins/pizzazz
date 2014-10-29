<?php

namespace pizzazz\includes\scripts\frontend;

class Themebase {
    public function enqueue() {
        wp_enqueue_style( 'pizzazz-themebase',
            plugins_url() . '/pizzazz/includes/themebase/css/base.css',
            null,
            null,
            'all' );
        wp_enqueue_style('dashicons');
    }
}