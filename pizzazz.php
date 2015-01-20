<?php
/*
Plugin Name: Pizzazz
Plugin URI: http://www.giveitpizzazz.com/
Description: Portfolio Plugin that is a snap to setup, makes you look awesome, and builds sales.
Version: 1.4.0
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

use pizzazz\includes\Activation;
use pizzazz\includes\shortcode\Shortcode;
use pizzazz\includes\customPosts\PortfolioItem;
use pizzazz\includes\menu\Menu;
use pizzazz\includes\scripts\Script;

require_once 'defines.php';
require_once 'autoload.php';
if(!class_exists('uagent_info')) require_once PIZZAZZ_INCLUDES_PATH . 'mdetect.php';

class Pizzazz {

    static public function isMobile() {
        if(get_option('pizzazz_force_mobile')) return true;
        $mobileDetect = new \uagent_info();
        $isMobile = $mobileDetect->DetectMobileQuick();
        return $isMobile;
    }

    public function execute() {
        $this->_activationHooks();
        $this->_actions();
    }

    protected function _activationHooks() {
        $activation = new Activation();
        register_activation_hook(__FILE__, array(&$activation, 'activate'));
        register_deactivation_hook(__FILE__, array(&$activation, 'deactivate'));
        register_uninstall_hook(__FILE__, array('\pizzazz\includes\Activation', 'uninstall'));
    }

    protected function _actions() {
        add_action('init', array(&$this, 'init'));
        add_action('admin_menu', array(&$this, 'adminMenu'));
        add_action('admin_init', array(&$this, 'adminInit'));
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
        load_plugin_textdomain('pizzazz', false, PIZZAZZ_PATH . '/languages/');
        add_filter('manage_pizzazz_item_posts_columns', array(&$this, 'addColumns'));
        add_action('manage_pizzazz_item_posts_custom_column', array(&$this, 'fillColumn'), 10, 2);
        add_filter('manage_edit-pizzazz_item_sortable_columns', array(&$this, 'addColumnSorting'));
        add_filter('request', array(&$this, 'orderByColumn'));
        $item = new PortfolioItem();
        $item->register();
    }

    public function adminMenu() {
        $menu = new Menu();
        $menu->addPages();
    }

    public function adminInit() {
        register_setting('pizzazz-options', 'pizzazz_show_social_share');
        register_setting('pizzazz-options', 'pizzazz_force_mobile');
        register_setting('pizzazz-options', 'pizzazz_show_custom_fields');
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
        $item = new PortfolioItem();
        return $item->addColumns($columns);
    }

    public function fillColumn($column, $postId) {
        $item = new PortfolioItem();
        $item->fillColumn($column, $postId);
    }

    public function addColumnSorting($columns) {
        $item = new PortfolioItem();
        return $item->addSorting($columns);
    }

    public function orderByColumn($vars) {
        if(!$vars || !isset($vars['post_type'])) return $vars;
        $item = new PortfolioItem();
        return $item->orderListRows($vars);
    }

    public function updateImageMetaBoxTitle() {
        $item = new PortfolioItem();
        $item->addImageMetaBox();
    }

    public function addMetaBoxes() {
        $item = new PortfolioItem();
        $item->addMetaBoxes();
    }

    public function savePost($id) {
        if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;
        if(!isset($_POST['action']) || $_POST['action'] !== 'editpost' || $_POST['post_type'] !== PortfolioItem::POST_TYPE){
            return;
        }
        check_admin_referer($_POST['action'], 'pizzazz_order_nonce');
        $item = new PortfolioItem();
        $item->save($id);
    }

    public function bulkAction() {
        if(!isset($_REQUEST['mode'])) $_REQUEST['mode'] = 'excerpt';
        $item = new PortfolioItem();
        $item->saveOrder();
    }

    public function adminNotices() {
        $item = new PortfolioItem();
        $item->addItemListHeader();
        $item->saveOrderNotice();
        Activation::displayMessage();
    }

    function displayShortcode($atts, $content, $tag) {
        $shortcode = new Shortcode();
        return $shortcode->display($atts, $content, $tag);
    }
}

$pizzazz = new Pizzazz();
$pizzazz->execute();
