<div id="pizzazz">

    <div class="pi-container">

        <div id="pi-main-pane">

            <div class="pi-focus">

                <img src="<?php echo $this->items[0]->imagePath; ?>" width="440" id="initialImage" />

            </div>

            <div class="pi-meta">

                <h2><?php echo $this->items[0]->post_title; ?></h2>

                <p><?php echo $this->items[0]->post_content; ?></p>

            </div>

        </div>
    </div>

    <div class="pi-container">

        <?php foreach($this->items as $key => $item) : ?>

            <a href="javascript:updateFocus('pi-focus-<?php echo $key ?>');">
                <img src="<?php echo $item->thumbnailPath; ?>" width="150"
                     height="150" class="pi-thumb"/>
            </a>

        <?php endforeach; ?>

    </div>

</div>

<div id="pi-items" class="pi-hide">

    <?php foreach($this->items as $key => $item) : ?>

        <div id="pi-focus-<?php echo $key ?>">

            <div class="pi-focus">

                <img src="<?php echo $item->imagePath; ?>" width="440" />

            </div>

            <div class="pi-meta">

                <h2><?php echo $item->post_title; ?></h2>

                <p><?php echo $item->post_content; ?></p>

            </div>

        </div>

    <?php endforeach; ?>

</div>