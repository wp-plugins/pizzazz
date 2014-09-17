<?php

if(!defined('ABSPATH')) die(-1);
?>
<div id="pizzazz">

    <div class="pi-container clearfix">

        <div id="pi-main-pane">

            <div class="pi-focus">

                <?php if(isset($this->_items[0]->imagePath)) : ?>

                    <img src="<?php echo $this->_items[0]->imagePath; ?>" id="initialImage"
                         width="<?php echo $this->_baseWidth; ?>" />

                <?php else : ?>

                    <span class="pi-notice" style="width: <?php echo $this->_baseWidth; ?>">

                        <?php echo __('No image available', 'pizzazz'); ?>

                    </span>

                <?php endif; ?>

            </div>

            <div class="pi-meta">

                <h2><?php echo $this->_formatTitle($this->_items[0]->post_title); ?></h2>

                <p><?php echo apply_filters('the_content', $this->_items[0]->post_content); ?></p>

            </div>

        </div>
    </div>

    <div class="pi-container">

        <div id="carouselControlsAbove">
            <a href="javascript:void(0);" class="prev"><span>&nbsp;</span> </a>
            <a href="javascript:void(0);" class="next"><span>&nbsp;</span></a>
        </div>

        <div id="carouselWrapper" class="clearfix">

            <div class="carouselBox">

                <div class="carousel">

                    <ul>

                        <?php foreach ($this->_items as $key => $item) : ?>

                            <li>

                                <a href="javascript:updateFocus('pi-focus-<?php echo $key ?>');">
                                    <img src="<?php echo $item->thumbnailPath; ?>"
                                         width="<?php echo $this->_thumbnailWidth; ?>"
                                         height="<?php echo $this->_thumbnailHeight; ?>"
                                         class="pi-thumb"
                                        <?php if(!isset($this->item->thumbnailPath)) printf('alt="%s"',
                                            __('no image available', 'pizzazz')); ?>
                                        />
                                </a>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            var width = $('div.pi-container').width();

            var thumbs = 5;
            if (width < 935) {
                thumbs = 4;
            }
            if (width < 800) {
                thumbs = 3;
            }

            var thumbsCount = $('.carousel li').length;

            if(thumbsCount < thumbs) {
                $('#carouselControlsAbove').hide();
                $('.carouselControls').hide();
                $(".carousel").jCarouselLite({
                    btnNext: "",
                    btnPrev: "",
                    circular: false,
                    visible: thumbsCount
                });
            } else {
                $('#carouselControlsAbove').show();
                $('.carouselControls').show();
                $(".carousel").jCarouselLite({
                    btnNext: ".next",
                    btnPrev: ".prev",
                    visible: thumbs
                });
            }

            var centerCarousel = function(){
                var totalWidth = 0;
                $('.carousel').each(function(){
                    totalWidth += $(this).width();
                });
                if(totalWidth !== 0) {
                    $('#carouselWrapper').css('width', totalWidth);
                }
            };

            centerCarousel();

        });
    </script>

</div>

<div id="pi-items" class="pi-hide">

    <?php foreach($this->_items as $key => $item) : ?>

        <div id="pi-focus-<?php echo $key ?>">

            <div class="pi-focus">

                <?php if(isset($item->imagePath)) : ?>

                    <img src="<?php echo $item->imagePath; ?>" width="<?php echo $this->_baseWidth; ?>"/>

                <?php else : ?>

                    <span class="pi-notice"><?php echo __('No image available', 'pizzazz'); ?></span>

                <?php endif; ?>

            </div>

            <div class="pi-meta">

                <h2><?php echo $this->_formatTitle($item->post_title); ?></h2>

                <p><?php echo apply_filters('the_content', $item->post_content); ?></p>

            </div>

        </div>

    <?php endforeach; ?>

</div>