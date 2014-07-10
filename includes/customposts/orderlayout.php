<input type="hidden" name="pizzazz_order" value="<?php echo $this->meta['order']; ?>" />
<?php echo wp_nonce_field('editpost', 'pizzazz_order_nonce'); ?>