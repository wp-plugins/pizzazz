<?php

namespace pizzazz\includes\postmeta;

use pizzazz\includes\customposts\PortfolioItem;

class PortfolioItemVideo
{
    protected $metaKey = '_pizzazz_item_video';

    static public function add()
    {
        $video = new static;
        add_meta_box(
            'videodiv',
            __('Video URL', 'pizzazz'),
            array(&$video, 'displayMetaBox'),
            PortfolioItem::POST_TYPE,
            'side'
        );
    }

    public function displayMetaBox()
    {
        include(PIZZAZZ_INCLUDES_PATH . '/postmeta/html/portfolio-item-video.php');
    }

    public function load($postId)
    {
        return get_post_meta($postId, $this->metaKey, true);
    }

    public function save($postId)
    {
        update_post_meta($postId, $this->metaKey, $this->getMetaFromRequest());
    }

    public function getMetaFromRequest()
    {
        return (isset($_POST['videoUrl'])) ? sanitize_text_field($_POST['videoUrl']) : '';
    }
}