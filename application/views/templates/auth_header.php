<header>
<div class="col-lg-5 col-lg-offset-2">

	
	<?php if($user_logged) { ?>
		<a href="<?php echo base_url(); ?>index.php/auth/logout">Выйти </a>
		
		<div class="alert alert-success"> <?php echo 'Пользтователь: '.$username; ?>
		<a href="<?php echo base_url()."index.php/board/view_board" ?>">ДОСКИ ПОЛЬЗОВАТЕЛЕЙ. </a> ||
		<a href="<?php echo base_url()."index.php/board/all_posts" ?>">Все комментарии. </a> ||
		<a href="<?php echo base_url()."index.php/board/my_board" ?>"> Личная стена </a> ||
		<a href="<?php echo base_url()."index.php/board/comment/0" ?>"><?php echo ($board_id > 0 ? "Добавить комментарий к доске" : '');?></a>
		
		
		</div>
		
	<?php 
	} else {?> 
		<p> <a href="<?php echo base_url(); ?>index.php/auth/login">Авторизуйтесь </a> или <a href="<?php echo base_url(); ?>index.php/auth/register">зарегистрируйтесь </a>, чтобы оставлять комментарии.<a href="<?php echo base_url()."index.php/board/view_board" ?>">ДОСКИ ПОЛЬЗОВАТЕЛЕЙ. </a>
		</p>
	<?php }  ?>
	<br /> 
	
</div>




</header>