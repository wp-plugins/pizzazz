<?php

namespace pizzazz\includes\menu;

class Menu {

    public function addPages()
    {
        $this->_addPortfoliosPage();
        $this->_addSettingsPage();
        $this->_addBugPage();
        $this->_addEnticingPage();
    }

    protected function _addPortfoliosPage()
    {
        add_menu_page('Pizzazz - ', 'Pizzazz', 'manage_options', 'pizzazz_portfolios', '', 'dashicons-admin-post');
    }

    protected function _addSettingsPage()
    {
        add_submenu_page(
            'pizzazz_portfolios',
            'Pizzazz Settings',
            'Settings',
            "manage_options",
            'pizzazz_settings',
            array(&$this, 'displySettingsPage')
        );
    }

    public function displySettingsPage()
    {
        include(PIZZAZZ_INCLUDES_PATH . 'menu/html/settings.php');
    }

    protected function _addEnticingPage()
    {
        add_submenu_page(
            'pizzazz_portfolios',
            'Premium for Free',
            'Premium for Free',
            "manage_options",
            'pizzazz_enticing',
            array(&$this, 'displayEnticingPage')
        );
    }

    public function displayEnticingPage()
    {
        include(PIZZAZZ_INCLUDES_PATH . 'menu/html/enticing.php');
    }

    protected function _addBugPage()
    {
            add_submenu_page(
                'pizzazz_portfolios',
                'How To Report a Bug',
                'Report a Bug',
                "manage_options",
                'pizzazz_bug',
                array(&$this, 'displayBugPage')
            );
    }

    public function displayBugPage()
    {
        include(PIZZAZZ_INCLUDES_PATH . 'menu/html/bug.php');
    }
}
