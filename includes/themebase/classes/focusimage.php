<?php

namespace pizzazz\includes\themebase\classes;

use pizzazz\includes\scripts\frontend\Lightbox;

class FocusImage {

    protected $_item = null;
    protected $_buffer = '';
    protected $_id = null;
    protected $_widthHtml = null;
    protected $_widthCss = null;
    protected $_isMobile = false;

    public function __construct($item, $config = array()){
        $this->_item = $item;
        if(array_key_exists('id', $config)) $this->_id = ' id="' . $config['id']. '" ';
        if(array_key_exists('mobile', $config)) $this->_isMobile = $config['mobile'];
        if(array_key_exists('width', $config)){
            $this->_widthHtml = ' width="' . $config['width'] . '" ';
            $this->_widthCss = ' width: ' . $config['width'] . 'px;';
        }
    }

    protected function _build(){
        if($this->_noImage()) return $this->_buildImageNotSet();
        if($this->_isMobile && $this->_videoLauncher()) return $this->_buildMobileVideoLauncherImage();
        if($this->_videoLauncher()) return $this->_buildVideoLauncherImage();
        return $this->_buildImage();
    }

    protected function _noImage(){
        return(!isset($this->_item->imagePath));
    }

    protected function _videoLauncher(){
        return($this->_item->videoUrl);
    }

    public function __toString(){
        $this->_build();
        return $this->_buffer;
    }

    protected function _buildImageNotSet(){
        $msg = __('No image available', 'pizzazz');
        $this->_buffer = <<<HTML
<span class="pi-notice" style="{$this->_widthCss}">
         $msg
</span>
HTML;
    }

    protected function _buildMobileVideoLauncherImage()
    {
        $this->_buffer = $this->_buffer = <<<HTML
        <a href="{$this->_item->videoUrl}" class="pi-video-connector">
            <span class="pi-play"></span>
            <img src="{$this->_item->imagePath}" {$this->_id} {$this->_widthHtml} />
        </a>
HTML;
    }
    
    protected function _buildVideoLauncherImage(){
        Lightbox::addLightbox();
        $this->_buffer = <<<HTML
        <a href="javascript: launchFeatherLight('#pz-video-{$this->_item->ID}');" class="pi-video-connector">

            <span class="pi-play"></span>

            <img src="{$this->_item->imagePath}" {$this->_id} {$this->_widthHtml} />

        </a>
HTML;
    }

    protected function _buildImage(){
        $this->_buffer = <<<HTML
            <img src="{$this->_item->imagePath}" {$this->_id} {$this->_widthHtml} />
HTML;
    }

}
