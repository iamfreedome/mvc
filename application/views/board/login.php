
  <?php $this->load->view('templates/header_board',array('title' => 'Страница Авторизации!')); ?>
	<div class="col-lg-5 col-lg-offset-2">
		<p>Заполните поля для авторизации на нашем сайте
		</p>
	
		<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
		<form action="" method="POST"> 
			<div class="form-group">
				<label for="username" > Имя пользователя (USERNAME) </label>
				<input class="form-control" name="username" id="username" type="text">
			</div>
	
			<div class="form-group">
				<label for="password" > Пароль</label>
				<input class="form-control" name="password" id="password" type="password">
			</div>
		
			<div>
				<button class="btn btn-primary" name="login">Войти</button>
			</div> 
		</form>

	</div>
   <?php $this->load->view('templates/footer_board');	?>