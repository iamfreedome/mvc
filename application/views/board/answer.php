<?php $this->load->view('templates/header_board',array('title' => "Ответить пользователю $answer!"));?>
    
<div class="col-lg-5 col-lg-offset-2">

	<!--<h1>Страница регистрации</h1> -->
	<p>Заполните поля, чтобы ответить на сообщение:" <?php echo $text; ?> "
	</p>
	
	
	<?php echo validation_errors('<div class="alert alert-danger">','</div>'); //(поля формы заголовок, тема, текст сообщения, кнопка «отправить»)?>
	
	<form action="" method="POST"> 
	<div class="form-group">
		<label for="title" > Заголовок </label>
		<input class="form-control" name="title" id="title" type="text">
	</div>

	<div class="form-group">
		<label for="text" > Текст комментария</label>
		<input class="form-control" name="text" id="text" type="text">
	</div>
	
	<div>
			<button class="btn btn-primary" name="comment">Ответить (Комментировать)</button>
		</div> 
	</form>

</div> 

<?php $this->load->view('templates/footer_board');?>