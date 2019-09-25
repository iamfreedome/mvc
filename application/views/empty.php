 
<div class="col-lg-5 col-lg-offset-2">

	
	<?php if(isset($_SESSION['user_logged'])) { ?>
		<div class="alert alert-success"> <?php echo 'Пользтователь: '.$_SESSION['username']; ?></div>
		<a href="<?php echo base_url(); ?>index.php/auth/logout">Выйти </a>
	<?php 
	} else {?> 
	<p> <a href="<?php echo base_url(); ?>index.php/auth/login">Авторизуйтесь </a> или <a href="<?php echo base_url(); ?>index.php/auth/register">зарегистрируйтесь </a>, чтобы оставлять комментарии.
	</p>
	<?php }  ?>
	
	

	<br /> 
	
</div>

<h4>На этой доске нет записей! </h4>

 