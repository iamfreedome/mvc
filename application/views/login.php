<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Страница авторизации</title>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
   
  </head>
  <body>
  <?php print_r($_SESSION); ?>
		<div class="col-lg-5 col-lg-offset-2">

			<h1>Страница авторизации</h1>
			<p>Заполните поля для авторизации на нашем сайте
			</p>
	<?php if(isset($_SESSION['success'])) { ?>
			<div class="alert alert-success"> <?php echo $_SESSION['success']; ?></div>
	<?php 
	} ?>
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
    