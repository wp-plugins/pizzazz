<?php

if(!defined('ABSPATH')) die(-1);

?>
<div class="pi-social">

    <span class="twitter">
        <a href="http://twitter.com/share"
           class="twitter-share-button"
           data-url="<?php the_permalink(); ?>">Tweet</a>
    </span>

    <span class="facebook">
        <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-type="button_count"></div>
    </span>

    <span class="google">
        <g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone>
    </span>

</div>