<?php

namespace pizzazz\includes\themes\kingofhill;

class KingOfHillTheme {

    protected $items = array();

    public function setItems($items) {
        $this->items = $items;
    }

    public function display(){
        ob_start();
        require_once( 'layout.php' );
        return ob_get_clean();
    }
}