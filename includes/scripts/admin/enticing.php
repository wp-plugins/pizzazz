<?php

namespace pizzazz\includes\scripts\admin;

class Enticing {

    public function enqueue() {
        wp_enqueue_style( 'pizzazz-enticing-style', PIZZAZZ_URL . 'assets/css/enticing.css' );
    }
}