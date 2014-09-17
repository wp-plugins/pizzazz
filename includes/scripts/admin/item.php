<?php

namespace pizzazz\includes\scripts\admin;

class Item {

    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_style( 'pizzazz-item-style', PIZZAZZ_URL . 'assets/css/item.css' );
        if ( ( isset( $_REQUEST['post_status'] ) && $_REQUEST['post_status'] === 'trash' ) ) return;
        wp_enqueue_script( 'pizzazz-item-script', PIZZAZZ_URL . 'assets/js/item.js', array(), false, true );
        $this->_localizeScript();
    }

    protected function _localizeScript() {
        $data = array(
            'pizzazzMediaAction' => __( 'Save Order', 'pizzazz' )
        );
        wp_localize_script( 'pizzazz-item-script', 'Pizzazz', $data );
    }
}