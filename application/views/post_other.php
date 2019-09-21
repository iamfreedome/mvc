<!--POSTS HERE-->
 <?php echo $_SESSION['board_id']?>
 <?php $base = base_url().'index.php/board/answer/'; $base_del = base_url().'index.php/board/del_post/'; foreach ($resi as $row): if ($row->deleted != 1) {  //was { ?>

<div class="col-lg-5 col-lg-offset-2" id="div<?php echo $row->post_id; ?>">
 Заголовок: <?php echo $row->title; ?> -> Тема: <?php echo $row->theme; ?> 
 <p>
  
 <?php echo $row->text; ?> <!-- ответить ссылка-->
 <br>
 <a href="<?php echo $base.$row->post_id ?>">
  <?php echo (isset($_SESSION['user_id']) ? ' Ответить ' : '') ?>
 </a> 
 
  <a href="<?php echo $base_del.$row->post_id ?>"><!-- удалить ссылка-->
 <?php $flag = (isset($_SESSION['user_id'])&&(($_SESSION['user_id'] == $row->user_id) or ($_SESSION['user_id'] == $row->board_id)));	echo ($flag ? ' Удалить ' : '') ?>
 </a>
 </p>
 
</div>

 
 <?php } endforeach; //was }?>
