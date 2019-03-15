<?php if (count($positions) > 0): ?>
<select id="Position" name="Position">
<?php for ($i = 0; $i < count($positions); ++$i) { ?>
    <option value="<?php echo $positions[$i]->Position; ?>"><?php echo $positions[$i]->Position; ?></option>
<?php } ?>
</select>
<?php else: ?>
<select id="Position" name="Position">
	<option value="">No Position has been assign for this department</option>
</select>
<?php endif;?>