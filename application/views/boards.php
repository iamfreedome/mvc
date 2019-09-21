 
<div class="col-lg-5 col-lg-offset-2">

	
	<?php if(isset($_SESSION['user_logged'])) { ?>
		<a href="<?php echo base_url(); ?>index.php/auth/logout">Выйти </a>
		
		<div class="alert alert-success"> <?php echo 'Пользтователь: '.$_SESSION['username']; ?>
		<a href="<?php echo base_url()."index.php/board/all_posts" ?>">Все комментарии. </a> ||
		<a href="<?php echo base_url()."index.php/board/my_board" ?>"> Личная стена </a> ||
		
		
		
		</div>
		
	<?php 
	} else {?> 
	<p> <a href="<?php echo base_url(); ?>index.php/auth/login">Авторизуйтесь </a> или <a href="<?php echo base_url(); ?>index.php/auth/register">зарегистрируйтесь </a>, чтобы оставлять комментарии.
	</p>
	<?php }  ?>
	
	

	<br /> 
	
</div>

<?php foreach ($resi as $row):  $base = base_url().'index.php/board/view/'?>
 <p>
 Доска пользователя: <a href="<?php echo $base.$row->user_id.'/'.$row->username; ?>">
 <?php echo $row->username; ?></a> <?php //print_r ($row);?>
 <?php //print ($row->username);?>
 
 </p>
 
 <?php endforeach; ?>

 
 <!--//print_r ($resi);
 //echo $title." " //print_r($resi)
 //?> -->