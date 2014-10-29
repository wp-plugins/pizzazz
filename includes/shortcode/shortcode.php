<?php

namespace pizzazz\includes\shortcode;

use pizzazz\includes\customposts\PortfolioItem;
use pizzazz\includes\themes\kingofhill\KingOfHillTheme;

class Shortcode {

    protected $tags = array('pizzazz');
    protected $atts;
    protected $content;

    public function display($atts, $content, $tag) {
        if( ! in_array( $tag, $this->tags ) ) return $content;
        $this->atts = $atts;
        $this->content = $content;
        return $this->$tag();
    }

    private function pizzazz() {
        $id = ( is_array( $this->atts ) && array_key_exists( 'id', $this->atts ) ) ? $this->atts['id'] : 0;
        $itemPosts = new PortfolioItem();
        $items = $itemPosts->getItems();
        $kingOfHill = new KingOfHillTheme();
        $kingOfHill->setItems( $items );
        return $kingOfHill->display();
    }
}