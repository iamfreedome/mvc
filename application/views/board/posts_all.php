<?php $this->load->view('templates/header_board',array('title' => "Все посты пользователя $uname !"));?>

<?php $this->load->view('templates/auth_header',$ai);?> 

<!--POSTS HERE-->
<?php $this->load->view('board/post_other', array('resi' => $resi, 'pi' => $pi, 'ai' => $ai)); ?>
 
<?php $this->load->view('board/script');?>	
	
<?php $this->load->view('templates/footer_board');?>
 
 