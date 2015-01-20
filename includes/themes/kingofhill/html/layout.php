<?php

if(!defined('ABSPATH')) die(-1);

use pizzazz\Pizzazz;
use pizzazz\includes\media\VideoLoader;
use pizzazz\includes\themebase\classes\FocusImage;
?>
<div id="pizzazz">

    <?php if ($this->options->share) include 'social.php'; ?>

    <div class="pi-container clearfix">

        <div id="pi-main-pane">

            <div class="pi-focus pie-box">

                <?php $item = $this->_items[0]; ?>

                <?php echo new FocusImage($item, array( 'width' => $this->_baseWidth,
                                                        'id' => 'initialImage',
                                                        'mobile' => Pizzazz::isMobile()
                )); ?>

            </div>

            <div class="pi-meta pie-box">

                <h2><?php echo $this->_formatTitle($item->post_title); ?></h2>

                <div class="pi-content clearfix">

                <?php echo apply_filters('the_content', $item->post_content); ?>

                <?php include 'custom-fields.php'; ?>

                </div>

            </div>

        </div>
    </div>

    <div class="pi-container">

        <div id="carouselWrapper" class="clearfix">

            <div class="carouselControls carouselBox">
                <a href="javascript:void(0);" class="prev sides" id="pz-thumbSliderLeft">
                    <span class="pz-slider-btn">&nbsp;</span>
                </a>
            </div>

            <div class="carouselBox">

                <div class="carousel">

                    <ul>

                        <?php foreach ($this->_items as $key => $item) : ?>

                            <li>

                                <a href="javascript:updateFocus('pi-focus-<?php echo $key ?>');" class="pi-thumb-link">

                                    <img src="<?php echo $item->thumbnailPath; ?>"
                                         width="<?php echo $this->_thumbnailWidth; ?>"
                                         height="<?php echo $this->_thumbnailHeight; ?>"
                                         style="<?php printf('min-width: %spx; min-height: %spx;',
                                                        $this->_thumbnailWidth,
                                                        $this->_thumbnailHeight); ?>"
                                         class="pi-thumb"
                                        <?php if (!isset($this->item->thumbnailPath)) printf('alt="%s"',
                                            __('no image available', 'pizzazz')); ?>
                                        />
                                </a>

                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            </div>

            <div class="carouselControls carouselBox">
                <a href="javascript:void(0);" class="next sides" id="pz-thumbSliderRight">
                    <span class="pz-slider-btn">&nbsp;</span>
                </a>
            </div>

        </div>

    </div>

</div>

<div id="pi-items" class="pi-hide">

    <?php $videos = array(); ?>

    <?php foreach($this->_items as $key => $item) : ?>

        <div id="pi-focus-<?php echo $key ?>">

            <div class="pi-focus pie-box">

                <?php echo new FocusImage($item, array( 'width' => $this->_baseWidth,
                                                        'mobile' => Pizzazz::isMobile()
                )); ?>

            </div>

            <div class="pi-meta pie-box">

                <h2><?php echo $this->_formatTitle($item->post_title); ?></h2>

                <div class="pi-content clearfix">

                <?php echo apply_filters('the_content', $item->post_content); ?>

                <?php include 'custom-fields.php'; ?>

                </div>

            </div>

        </div>

        <?php if($item->videoUrl) : ?>

            <?php $videos[] = $item; ?>

        <?php endif; ?>

    <?php endforeach; ?>

</div>

<div id="loaded" style="display: none;">

    <?php foreach($videos as $item): ?>

        <?php echo VideoLoader::getEmbedCode($item); ?>

    <?php endforeach; ?>

</div>