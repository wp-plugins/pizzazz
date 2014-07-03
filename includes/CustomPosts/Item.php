<?php

namespace Pizzazz\includes\CustomPosts;

use Pizzazz\Pizzazz;

class Item {

    protected $arguments = array();
    protected $postType = 'pizzazz_item';

    public function getPostType() {
        return $this->postType;
    }

    public function register() {
        $this->_loadArguments();
        register_post_type($this->postType, $this->arguments);
        remove_post_type_support($this->postType, 'media');
    }

    protected function _loadArguments() {
        $this->arguments = array(
            'labels'        => $this->_getLabels(),
            'public'        => true,
            'show_in_menu'  => 'pizzazz_portfolios',
            'supports'      => array('title', 'editor', 'thumbnail')
        );
    }

    protected function _getLabels() {
        return array(
            'name'                  => \__('Items', PIZZAZZ_TEXT_DOMAIN),
            'singular_name'         => \__('Item', PIZZAZZ_TEXT_DOMAIN),
            'add_new'               => \__('Add New', PIZZAZZ_TEXT_DOMAIN),
            'add_new_item'          => \__('Add New Item', PIZZAZZ_TEXT_DOMAIN),
            'edit_item'             => \__('Edit', PIZZAZZ_TEXT_DOMAIN),
            'new_item'              => \__('Edit Item', PIZZAZZ_TEXT_DOMAIN),
            'all_items'             => \__('Items', PIZZAZZ_TEXT_DOMAIN),
            'view_item'             => \__('View Item', PIZZAZZ_TEXT_DOMAIN),
            'search_items'          => \__('Search Items', PIZZAZZ_TEXT_DOMAIN),
            'not_found'             => \__('No Items Found', PIZZAZZ_TEXT_DOMAIN),
            'not_found_in_trash'    => \__('No Items Found in Trash', PIZZAZZ_TEXT_DOMAIN),
            'parent_item_colon'     => \__('', PIZZAZZ_TEXT_DOMAIN),
            'menu_name'             => \__('Items', PIZZAZZ_TEXT_DOMAIN)
        );
    }

    public function addColumns($columns) {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'order'     => 'Order',
            'thumbnail' => 'Thumbnail',
            'title'     => 'Title',
            'date'      => 'Date'
        );
        return $columns;
    }

    public function fillColumn($column, $postId) {
        $columns = array(
            'thumbnail' => '_loadThumbnailColumn',
            'order'     => '_loadOrderFieldColumn'
        );
        if(!in_array($column, array_keys($columns))) return;
        $this->$columns[$column]($postId);
    }

    protected function _loadThumbnailColumn($postId) {
        if(!$imageId = get_post_meta($postId, '_thumbnail_id', true)) return;
        $imagePath = get_post_meta($imageId, '_wp_attached_file', true);
        $upload = trailingslashit(wp_upload_dir()['baseurl']);
        echo '<img src="' . $upload . $imagePath . '" />';
    }

    protected function _loadOrderFieldColumn($postId) {
        $meta = $this->load($postId);
        echo '<input type="text" name="order[]" value="' . $meta['order'] . '" />';
    }

    public function addSorting($columns) {
        $custom = array('order' => 'order');
        return wp_parse_args($custom, $columns);
    }

    public function orderListRows($vars) {
        if( $vars['post_type'] !== $this->postType || ( isset( $vars['orderby'] ) && $vars['orderby'] !== 'order' ) ) return $vars;
        $orderVars = array(
            'meta_key'  => '_pizzazz_item_order',
            'orderby'   => 'meta_value_num'
        );
        if (!isset($vars['order'])) $orderVars['order'] = 'asc';
        return array_merge($vars, $orderVars);
    }

    public function getItems() {
        $items = $this->_loadItems();
        $noImages = array();
        foreach($items as $key => $item) {
            if(!$this->_addImagePathsToItem($item)) $noImages[] = $key;
        }
        foreach($noImages as $noImage) {
            unset($items[$noImage]);
        }
        return $items;
    }

    protected function _loadItems() {
        $arguments = array(
            'post_type'         => $this->postType,
            'posts_per_page'    => '-1',
            'meta_key'          => '_pizzazz_item_order',
            'orderby'           => 'meta_value_num',
            'order'             => 'ASC',
        );
        $itemsQuery = new \WP_Query($arguments);
        return $itemsQuery->get_posts();
    }

    protected function _addImagePathsToItem(&$item) {
        if(!$imageId = get_post_meta($item->ID, '_thumbnail_id', true)) return false;
        $attachmentMeta = get_post_meta($imageId, '_wp_attachment_metadata', true);
        $upload = trailingslashit(wp_upload_dir()['baseurl']);
        $thumbnail = substr($attachmentMeta['file'], 0, 8) . $attachmentMeta['sizes']['thumbnail']['file'];
        $item->imagePath = $upload . $attachmentMeta['file'];
        $item->thumbnailPath = $upload . $thumbnail;
        return true;
    }

    public function addImageMetaBox() {
        $screen = get_current_screen();
        if($screen->post_type !== $this->postType) return;
        remove_meta_box('postimagediv', 'custom_post_type', 'side');
        add_meta_box('postimagediv',
            __('Portfolio Image', PIZZAZZ_TEXT_DOMAIN),
            'post_thumbnail_meta_box',
            $this->postType,
            'side',
            'high');
    }

    public function addMetaBoxes() {
        add_meta_box(
            'orderdiv',
            __('Item Order', PIZZAZZ_TEXT_DOMAIN),
            array(&$this, 'displayMetaBox'),
            $this->postType
        );
    }

    public function displayMetaBox() {
        $itemId = get_the_ID();
        $this->meta = $this->load($itemId);
        include_once('orderlayout.php');
    }

    public function load($itemId) {
        $meta = array();
        $meta['order'] = get_post_meta($itemId, '_pizzazz_item_order', true);
        return $meta;
    }

    public function save($itemId) {
        $order = ($_POST['pizzazz_order']) ? $_POST['pizzazz_order'] : count($this->getItems()) + 1;
        update_post_meta($itemId, '_pizzazz_item_order', $order);
    }

    public function saveOrder() {
        if(!$this->_beforeSaveOrder()) {
            return;
        }
        $postIds = array_map('intval', $_REQUEST['post']);
        $order = array_map('intval', $_REQUEST['order']);
        foreach($postIds as $key => $id){
            $_POST['pizzazz_order'] = $order[$key];
            $this->save($id);
        }
        $this->_redirect($postIds);
    }

    protected function _beforeSaveOrder() {
        global $typenow;
        if($typenow !== $this->postType) return false;
        $wp_list_table = _get_list_table('WP_Posts_List_Table');
        $action = $wp_list_table->current_action();
        if($action != 'saveOrder') return false;
        if(!isset($_REQUEST['post']) || empty($_REQUEST['post'])) return false;
        if(!isset($_REQUEST['order']) || empty($_REQUEST['order'])) $this->_displayError();
        return true;
    }

    protected function _redirect($postIds) {
        $sendback = remove_query_arg(
            array(
                'orderSaved',
                'untrashed',
                'deleted',
                'action',
                'action2',
                'tags_input',
                'post_author',
                'comment_status',
                'ping_status',
                '_status',
                'post',
                'bulk_edit',
                'post_view'
            ),
            wp_get_referer()
        );
        if(!$sendback) $sendback = admin_url('edit.php?post_type=' . $this->postType);
        $wp_list_table = _get_list_table('WP_Posts_List_Table');
        $sendback = add_query_arg(array('orderSaved' => count($postIds), 'paged' => $wp_list_table->get_pagenum()), $sendback);
        wp_redirect($sendback);
        exit();
    }

    protected function _displayError() {
        $title = __('WordPress Failure Notice');
        $html = __('Error loading order values.', PIZZAZZ_TEXT_DOMAIN);
        if (wp_get_referer()) $html .= "</p><p><a href='" . esc_url(remove_query_arg('updated', wp_get_referer())) . "'>" . __('Please try again.') . "</a>";
        wp_die($html, $title, array('response' => 403));
    }

    public function saveOrderNotice() {
        global $post_type, $pagenow;
        if($pagenow != 'edit.php' || $post_type != $this->postType || !isset($_REQUEST['orderSaved']) || (int) !$_REQUEST['orderSaved']) return;
        $message = sprintf(_n('Item order saved.', '%s items order saved.', $_REQUEST['orderSaved']), number_format_i18n($_REQUEST['orderSaved']));
        echo "<div class=\"updated\"><p>{$message}</p></div>";
    }

    public function addItemListHeader() {
        global $post_type, $pagenow;
        if($post_type !== $this->postType || $pagenow !== 'edit.php' || (isset($_REQUEST['post_status']) && $_REQUEST['post_status'] === 'trash')) return;
        echo '<div class="updated survey-link"><p>We are working on a premium version of Pizzazz, take our <a href="http://bluebridgedev.com/pizzazz-survey" target="_blank">three question survey</a> for a chance to win a free copy when it is released.</p></div>';
    }
}