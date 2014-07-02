<?php

namespace Pizzazz\includes\Menu;

use Pizzazz\includes\Menu\Pages\ItemForm;
use Pizzazz\includes\Menu\Pages\Portfolio;

class Menu {

    public function addPages() {
        $this->_addPortfoliosPage();
    }

    protected function _addPortfoliosPage() {
        add_menu_page('Pizzazz - ', 'Pizzazz', 'manage_options', 'pizzazz_portfolios');
    }
}