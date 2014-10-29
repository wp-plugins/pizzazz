<?php

namespace pizzazz\includes\scripts;

class Script
{
    protected $_adminScripts;
    protected $_frontEndScripts;

    public function __construct()
    {
        $this->_adminScripts = $this->_loadAdminScripts();
        $this->_frontEndScripts = $this->_loadFrontEndScripts();
    }

    protected function _loadAdminScripts()
    {
        return array(
            'edit-pizzazz_item'             => array('\admin\item'),
            'pizzazz_item'                  => array('\admin\item'),
            'pizzazz_page_pizzazz_enticing' => array('\admin\enticing'),
        );
    }

    protected function _loadFrontEndScripts()
    {
        return array(
            'themebase' => array('\frontend\themebase'),
            'king-of-hill'  => array('\frontend\kingofhill')
        );
    }

    public function enqueueAdmin()
    {
        $screen = get_current_screen();
        if(!isset($this->_adminScripts[$screen->id])) return false;
        $this->_enqueueScripts($this->_adminScripts[$screen->id]);
    }

    public function enqueueFrontEnd()
    {
        foreach($this->_frontEndScripts as $scripts){
            $this->_enqueueScripts($scripts);
        }
    }

    protected function _enqueueScripts($scripts) {
        foreach($scripts as $script){
            $scriptObject = $this->_loadScript($script);
            $scriptObject->enqueue();
        }
    }

    protected function _loadScript($script) {
        $scriptClass = __NAMESPACE__ . $script;
        $scriptObject = new $scriptClass;
        return $scriptObject;
    }
}