<?php

namespace pizzazz\includes\scripts\frontend;

class Lightbox
{
    static public function addLightbox()
    {
        $lightbox = new static;
        $lightbox->enqueue();
    }

    public function enqueue() {
        wp_enqueue_style( 'pizzazz-lightbox',
            plugins_url() . '/pizzazz/assets/css/featherlight.min.css');
        wp_enqueue_script(
            'pizzazz-lightbox',
            plugins_url() . '/pizzazz/assets/js/featherlight.min.js',
            array('jquery')
        );
    }
}