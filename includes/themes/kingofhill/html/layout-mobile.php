<?php

if(!defined('ABSPATH')) die(-1);
?>
<div id="pizzazz" class="mobile">

    <?php foreach($this->_items as $key => $item) : ?>

        <div class="pi-container clearfix">

            <div id="pi-focus-<?php echo $key ?>">

                <div class="pi-focus">

                    <?php if(isset($item->imagePath)) : ?>

                        <img src="<?php echo $item->imagePath; ?>"
                             width="<?php echo $this->_baseWidth; ?>"
                            <?php if($key === 0) echo ' id="initialImage"'; ?>/>

                    <?php else : ?>

                        <span class="pi-notice"><?php echo __('No image available', 'pizzazz'); ?></span>

                    <?php endif; ?>

                </div>

                <div class="pi-meta">

                    <h2><?php echo $this->_formatTitle($item->post_title); ?></h2>

                    <p><?php echo apply_filters('the_content', $item->post_content); ?></p>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

