

<?php echo validation_errors(); ?>

<?php echo form_open('shkaf/book_add') ?>
	<label for="">Название книги</label>
	<input type="input" name="title" /> <br />
	
	<label for="text">Текст Книги</label>
	<textarea name ="text"> </textarea> <br />
	
	<input type="submit" name="submit" value="Дописать книгу" />
	
</form>