	

<?php $this->load->view('templates/header_board',array('title' => 'Доски пользователей !'));?> 

<?php $this->load->view('templates/auth_header',$ai);?> 

<nav>
<?php foreach ($resi as $row):  $base = base_url().'index.php/board/view/'?>
	<p>
		Доска пользователя: <a href="<?php echo $base.$row->user_id.'/'.$row->username; ?>">
		<?php echo $row->username; ?></a> 
 
 
	</p>
 
 <?php endforeach; ?>
</nav>
<?php $this->load->view('templates/footer_board');?>