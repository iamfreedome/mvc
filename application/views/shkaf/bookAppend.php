

<?php //echo validation_errors(); ?>

<?php echo form_open('shkaf/make_append/'.$path) ?>
	
	<label for="text">Текст который дополнит книгу</label>
	<textarea name ="text"> </textarea> <br />
	
	<input type="submit" name="submit" value="Дописать книгу" />
	
</form>