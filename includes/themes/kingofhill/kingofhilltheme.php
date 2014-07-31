<?php

namespace pizzazz\includes\themes\kingofhill;

class KingOfHillTheme {

    protected $items = array();
    protected $_baseWidth = 400;
    protected $_thumbnailWidth = 350;
    protected $_thumbnailHeight = 150;

    public function setItems($items) {
        $this->items = $items;
    }

    public function display(){
        $this->_setBaseWidth();
        $this->_setThumbnailDimensions();
        ob_start();
        require_once( 'layout.php' );
        return ob_get_clean();
    }

    public function _setBaseWidth(){
        $size = getimagesize($this->items[0]->imagePath);
        $this->_baseWidth = $size[0];
    }

    protected function _setThumbnailDimensions(){
        $this->_thumbnailWidth = $this->items[0]->thumbnailWidth;
        $this->_thumbnailHeight = $this->items[0]->thumbnailHeight;
    }
}