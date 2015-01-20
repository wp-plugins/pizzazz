<?php

namespace pizzazz\includes;

class Activation
{
    public function activate()
    {
        if (!current_user_can('activate_plugins')) return;
        $this->_checkAdminReferrer('activate');
        update_option('pizzazz_version_number', PIZZAZZ_VERSION);
        if (get_option('pizzazz_show_social_share') === false) update_option('pizzazz_show_social_share', false);
        if (get_option('pizzazz_show_custom_fields') === false) update_option('pizzazz_show_custom_fields', true);
    }

    public function deactivate()
    {
        if(!current_user_can('activate_plugins')) return;
        $this->_checkAdminReferrer('deactivate');
        delete_option('pizzazz');
    }

    static public function uninstall()
    {
        if(!current_user_can('activate_plugins')) return;
        check_admin_referer('bulk-plugins');
        if(__FILE__ !== WP_UNINSTALL_PLUGIN) return;
    }

    protected function _checkAdminReferrer($method)
    {
        $plugin = (isset($_REQUEST['plugin'])) ? $_REQUEST['plugin'] : '';
        check_admin_referer("{$method}-plugin_{$plugin}");
    }

    static public function displayMessage()
    {
        if(get_option('pizzazz') === 'PIZZAZZ') return;
        update_option('pizzazz', 'PIZZAZZ');
        include_once(PIZZAZZ_INCLUDES_PATH . 'html/activation-message.php');
    }
}