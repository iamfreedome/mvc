


<?php $this->load->view('templates/header_shkaf',array ('title' => 'Дописать в книгу!')); ?>

<h3><?php echo urldecode($book_name); ?> </h3>
<div>
	<?php echo $text; ?>
</div>

<?php echo form_open('shkaf/make_append/'.$path) ?>
	
	<label for="text">Текст который дополнит книгу</label>
	<textarea name ="text"> </textarea> <br />
	
	<input type="submit" name="submit" value="Дописать книгу" />
	
</form>

<?php $this->load->view('templates/footer_shkaf');?>