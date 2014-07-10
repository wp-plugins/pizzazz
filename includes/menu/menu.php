<?php

namespace pizzazz\includes\menu;

class Menu {

    public function addPages() {
        $this->_addPortfoliosPage();
    }

    protected function _addPortfoliosPage() {
        add_menu_page('Pizzazz - ', 'Pizzazz', 'manage_options', 'pizzazz_portfolios');
    }
}
