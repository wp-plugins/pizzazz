<?php if (!defined('ABSPATH')) die(-1); ?>

<p>Youtube or Vimeo video</p>

<input type="url"
       name="videoUrl"
       value="<?php if(isset($_REQUEST['post'])) echo $this->load(intval($_REQUEST['post'])); ?>" />