<?php //view/shkaf/listBook.php 
//<h2> СОДЕРЖИМОЕ ШКАФА </h2>

?>
<?php foreach ($listbook as $nameBook): ?>
<h3><?php echo $nameBook['book_name']//print_r($nameBook)//$nameBook['book_name'] 
?></h3>
	
	<!--//<div class='main'>
		<?php // echo $news_item['text'] ?>
		</div>
		-->
		<p> 
		<a href="book_open/<?php echo $nameBook['path'] ?>"> Достать и открыть книгу </a> </p>
		<p> 
		<a href="book_append/<?php echo $nameBook['path'] ?>"> Дописать в книгу </a> </p>
		<p> 
		<!--<a href="<?php echo 'shkaf/' ?>"> Положить книгу \ </a> </p> -->

<?php endforeach ?>
