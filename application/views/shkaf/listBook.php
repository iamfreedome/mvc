

<?php //view/shkaf/listBook.php
//<h2> СОДЕРЖИМОЕ ШКАФА </h2>
$this->load->view('templates/header_shkaf',array ('title' => 'СОДЕРЖАНИЕ ШКАФА'));
?>
<?php foreach ($listbook as $nameBook): ?>
<h3><?php echo $nameBook['book_name']// 
?></h3>
	
		<p> 
			<a href="book_open/<?php echo $nameBook['path'] ?>"> Достать и открыть книгу </a> </p>
		<p> 
			<a href="book_append/<?php echo $nameBook['path'] ?>"> Дописать в книгу </a> </p>
		<p> 
		

<?php endforeach; 
$this->load->view('templates/footer_shkaf');
?>
