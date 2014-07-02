<?php

namespace Pizzazz\includes\Scripts\FrontEnd;

class KingOfHill {

    public function enqueue() {
        wp_enqueue_script(
            'pizzazz-kingofthehill-js',
            plugins_url() . '/pizzazz/includes/themes/kingofhill/js/theme.js',
            array( 'jquery' )
        );
        wp_enqueue_style( 'pizzazz-kingofthehill-css',
            plugins_url() . '/pizzazz/includes/themes/kingofhill/css/theme.css',
            null,
            null,
            'all' );
    }
}