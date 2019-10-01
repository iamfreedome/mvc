<?php $this->load->view('templates/header_board',array('title' => 'Регистрация')); ?>
    
<div class="col-lg-5 col-lg-offset-2">

	<!--<h1>Страница регистрации</h1> -->
	<p>Заполните поля для регистрации на нашем сайте
	</p>
	
	<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
	<form action="" method="POST"> 
		<div class="form-group">
			<label for="username" > Имя пользователя (USERNAME) </label>
			<input class="form-control" name="username" id="username" type="text">
		</div>
	
		<div class="form-group">
			<label for="email" > EmaiL: (@)</label>
			<input class="form-control" name="email" id="email" type="text">
		</div>

		<div class="form-group">
			<label for="password" > Пароль (password)</label>
			<input class="form-control" name="password" id="password" type="password">
		</div>
	
		<div class="form-group">
			<label for="password" > Подтвердите пароль: (confirm)</label>
			<input class="form-control" name="password2" id="password" type="password">
		</div>
	
		<div>
			<button class="btn btn-primary" name="register">Зарегистрироваться </button>
		</div> 
	</form>

</div>

 <?php $this->load->view('templates/footer_board');?>