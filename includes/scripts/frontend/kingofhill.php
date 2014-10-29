<?php

namespace pizzazz\includes\scripts\frontend;

class KingOfHill
{
    public function enqueue() {
        wp_enqueue_style( 'pizzazz-kingofthehill',
            plugins_url() . '/pizzazz/includes/themes/kingofhill/css/theme.css',
            null,
            null,
            'all' );
        wp_enqueue_style('dashicons');
        wp_enqueue_script(
            'pizzazz-slider-js',
            plugins_url() . '/pizzazz/includes/themebase/js/slider.js',
            array( 'jquery' )
        );
        wp_enqueue_script(
            'pizzazz-kingofthehill-js',
            plugins_url() . '/pizzazz/includes/themes/kingofhill/js/theme.js',
            array( 'jquery' )
        );
    }
}