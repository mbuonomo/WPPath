<div class="wrapper">
<fieldset>
<legend>
      <?php _e('Your path credentials', PLUGIN_LOCALE); ?>
    </legend>
<div class="option">
      <label for="pathusername">
        <?php _e('Path Username', PLUGIN_LOCALE); ?>
      </label>
<input type="text" id="<?php echo $this->get_field_id('pathusername'); ?>" name="<?php echo $this->get_field_name('pathusername'); ?>" value="<?php echo $instance['pathusername']; ?>" class="">
    </div>
<div class="option">
      <label for="pathpassword">
        <?php _e('Path password', PLUGIN_LOCALE); ?>
      </label>
<input type="password" id="<?php echo $this->get_field_id('pathpassword'); ?>" name="<?php echo $this->get_field_name('pathpassword'); ?>" value="<?php echo $instance['pathpassword']; ?>" class="">
    </div>
	<div class="option">
	      <label for="pathpassword">
	        <?php _e('How many items', PLUGIN_LOCALE); ?>
	      </label>
	<input type="text" id="<?php echo $this->get_field_id('pathnbdisplay'); ?>" name="<?php echo $this->get_field_name('pathnbdisplay'); ?>" value="<?php echo ($instance['pathnbdisplay'])?$instance['pathnbdisplay']:'5'; ?>" class="">
	    </div>
</fieldset>
</div>
