<!--POSTS HERE-->
 
 <?php foreach ($resi as $row): if ($row->deleted != 1) {?>

	<div class="col-lg-5 col-lg-offset-2" id="div<?php echo $row->post_id; ?>">
	Заголовок: <?php echo $row->title; ?> -> Тема: <?php echo $row->theme; ?> 
 
	<?php if ( $row->comment_id > 0) { echo '<div class="alert-info" align="right">"',$row->comment,'"</div>';
	} ?>
 
	<p><strong>
		<?php echo $row->text; ?> </strong><!-- ответить ссылка-->
		<br>
		<a href="<?php echo $pi['base'].$row->post_id ?>">
			<?php echo (($ai['user_logged']) ? ' Ответить ' : '') ?>
		</a> 
 
		<a href="<?php echo $pi['base_del'].$row->post_id ?>"><!-- удалить ссылка-->
			<?php $flag = ($ai['user_logged'])&&(($ai['user_id'] == $row->user_id) or ($ai['user_id'] == $row->board_id));	echo ($flag ? ' Удалить ' : '') ?>
		</a>
	</p>
 
	</div>

 
 <?php } endforeach; //was }?>
 