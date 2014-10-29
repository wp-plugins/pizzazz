<?php

if(!defined('ABSPATH')) die(-1);

use pizzazz\includes\themebase\classes\FocusImage;

?>
<div id="pizzazz" class="mobile">

    <?php if ($this->options->share) include 'social.php'; ?>

    <?php foreach($this->_items as $key => $item) : ?>

        <div class="pi-container clearfix">

            <div id="pi-focus-<?php echo $key ?>">

                <div class="pi-focus">

                    <?php echo new FocusImage($item,
                        array('width' => $this->_baseWidth, 'id' => 'initialImage', 'mobile' => true)); ?>

                </div>

                <div class="pi-meta pie-box">

                    <h2 class="pi-bg-meta-heading"><?php echo $this->_formatTitle($item->post_title); ?></h2>

                    <div class="pi-content clearfix">

                        <?php echo apply_filters('the_content', $item->post_content); ?>

                        <?php include 'custom-fields.php'; ?>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

