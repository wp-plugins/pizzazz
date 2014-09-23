<?php

namespace pizzazz\includes\themes\kingofhill;

use pizzazz\Pizzazz;

class KingOfHillTheme {

    protected $_items = array();
    protected $_baseWidth = 400;
    protected $options;
    protected $_thumbnailWidth = 350;
    protected $_thumbnailHeight = 150;

    public function __construct() {
        $this->_loadOptions();
    }

    protected function _loadOptions(){
        $this->options = new \stdClass();
        $this->options->share = (intval(get_option('pizzazz_show_social_share')));
    }

    public function setItems($items) {
        $this->_items = $items;
    }

    public function display(){
        if(!empty($this->_items)) $this->_loadWidthSettings();
        ob_start();
        require_once($this->_loadLayout());
        return ob_get_clean();
    }

    protected function _loadWidthSettings(){
        $this->_setBaseWidth();
        $this->_setThumbnailDimensions();
    }

    public function _setBaseWidth($i = 0){
        if(isset($this->_items[$i]) && !isset($this->_items[$i]->imagePath)) $this->_setBaseWidth(++$i);
        if(!isset($this->_items[$i]) || !isset($this->_items[$i]->imagePath)) return false;
        $size = getimagesize($this->_items[$i]->imagePath);
        $this->_baseWidth = $size[0];
    }

    protected function _setThumbnailDimensions($i = 0){
        if(isset($this->_items[$i]) && !isset($this->_items[$i]->thumbnailWidth)) $this->_setThumbnailDimensions(++$i);
        if(!isset($this->_items[$i]) || !isset($this->_items[$i]->thumbnailWidth)) return false;
        $this->_thumbnailWidth = $this->_items[0]->thumbnailWidth;
        $this->_thumbnailHeight = $this->_items[0]->thumbnailHeight;
    }

    protected function _loadLayout(){
        if(empty($this->_items)) return 'html/noitems.php';
        return (!Pizzazz::isMobile()) ? 'html/layout.php' : 'html/layout-mobile.php';
    }

    protected function _formatTitle($title){
        $title = sanitize_text_field($title);
        $title = explode(' ', $title);
        $first = array_shift($title);
        $title = implode(' ', $title);
        return '<span class="pz-title">' . $first . '</span> ' . $title;
    }

}