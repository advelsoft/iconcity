<?php if (count($emails) > 0): ?>
<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="<?php echo $emails[0]->Email; ?>" />
<?php else: ?>
<input id="Email" name="Email" placeholder="Email" type="text" class="form-control" value="" />
<?php endif;?>