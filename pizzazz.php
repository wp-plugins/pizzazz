<?php
/*
Plugin Name: Pizzazz
Plugin URI: http://www.bluebridgedev.com/download/pizzazz.zip
Description: An attractive and simple portfolio.
Version: 1.0.5
Author: Blue Bridge Development
Author URI: http://www.bluebridgedev.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

namespace pizzazz;

use pizzazz\includes\shortcode\Shortcode;
use pizzazz\includes\customPosts\Item;
use pizzazz\includes\menu\Menu;
use pizzazz\includes\scripts\Script;

require_once 'defines.php';
require_once 'autoload.php';

class Pizzazz {

    public function execute() {
        $this->_activationHooks();
        $this->_actions();
    }

    protected function _activationHooks() {
        register_activation_hook(__FILE__, array(&$this, 'activate'));
    }

    protected function _actions() {
        add_action('init', array(&$this, 'init'));
        add_action('admin_menu', array(&$this, 'adminMenu'));
        add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueueScripts'));
        add_action('do_meta_boxes', array(&$this, 'updateImageMetaBoxTitle'));
        add_action('add_meta_boxes', array(&$this, 'addMetaboxes'));
        add_action('save_post', array(&$this, 'savePost'));
        add_action('load-edit.php', array(&$this, 'bulkAction'));
        add_action('admin_notices', array(&$this, 'adminNotices'));
        add_shortcode('pizzazz', array(&$this, 'displayShortcode'));
    }

    public function activate() {
        update_option('pizzazz_version_number', PIZZAZZ_VERSION);
    }

    public function init() {
        load_plugin_textdomain(PIZZAZZ_TEXT_DOMAIN, false, PIZZAZZ_PATH . '/languages/');
        add_filter('manage_pizzazz_item_posts_columns', array(&$this, 'addColumns'));
        add_action('manage_pizzazz_item_posts_custom_column', array(&$this, 'fillColumn'), 10, 2);
        add_filter('manage_edit-pizzazz_item_sortable_columns', array(&$this, 'addColumnSorting'));
        add_filter('request', array(&$this, 'orderByColumn'));
        $item = new Item();
        $item->register();
    }

    public function adminMenu() {
        $menu = new Menu();
        $menu->addPages();
    }

    public function adminEnqueueScripts() {
        $script = new Script();
        $script->enqueueAdmin();
    }

    public function enqueueScripts() {
        $script = new Script();
        $script->enqueueFrontEnd();
    }

    public function addColumns($columns) {
        $item = new Item();
        return $item->addColumns($columns);
    }

    public function fillColumn($column, $postId) {
        $item = new Item();
        $item->fillColumn($column, $postId);
    }

    public function addColumnSorting($columns) {
        $item = new Item();
        return $item->addSorting($columns);
    }

    public function orderByColumn($vars) {
        if ( !$vars || !isset( $vars['post_type' ] ) ) return $vars;
        $item = new Item();
        return $item->orderListRows($vars);
    }

    public function updateImageMetaBoxTitle() {
        $item = new Item();
        $item->addImageMetaBox();
    }

    public function addMetaBoxes() {
        $item = new Item();
        $item->addMetaBoxes();
    }

    public function savePost($id) {
        if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;
        $item = new Item();
        if(!isset($_POST['action']) || $_POST['post_type'] !== $item->getPostType()) return;
        check_admin_referer($_POST['action'], 'pizzazz_order_nonce');
        $item->save($id);
    }

    public function bulkAction() {
        if(!isset($_REQUEST['mode'])) $_REQUEST['mode'] = 'excerpt';
        $item = new Item();
        $item->saveOrder();
    }

    public function adminNotices() {
        $item = new Item();
        $item->addItemListHeader();
        $item->saveOrderNotice();
    }

    function displayShortcode($atts, $content, $tag) {
        $shortcode = new Shortcode();
        return $shortcode->display($atts, $content, $tag);
    }
}

$pizzazz = new Pizzazz();
$pizzazz->execute();
