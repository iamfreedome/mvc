
    
<div class="col-lg-5 col-lg-offset-2">

	<!--<h1>Страница регистрации</h1> -->
	<p>Заполните поля для комментирования доски на нашем сайте
	</p>
	<?php if(isset($_SESSION['success'])) { ?>
		<div class="alert alert-success"> <?php echo $_SESSION['success']; ?> <br />
		<?php if (isset($_SESSION['username'])) echo 'Пользтователь: '.$_SESSION['username']; ?>
		</div>
	<?php 
	} ?>
	
	<?php echo validation_errors('<div class="alert alert-danger">','</div>'); //(поля формы заголовок, тема, текст сообщения, кнопка «отправить»)?>
	
	<form action="" method="POST"> 
	<div class="form-group">
		<label for="title" > Заголовок </label>
		<input class="form-control" name="title" id="title" type="text">
	</div>
	
	<div class="form-group">
		<label for="theme" > Тема</label>
		<input class="form-control" name="theme" id="theme" type="text">
	</div>

	<div class="form-group">
		<label for="text" > Текст комментария</label>
		<input class="form-control" name="text" id="text" type="text">
	</div>
	
	<div>
			<button class="btn btn-primary" name="comment">Отправить (Комментировать)</button>
		</div> 
	</form>

</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed 
    <script src="<?php //echo base_url();?>assets/js/bootstrap.min.js"></script>
  </body>
</html> -->